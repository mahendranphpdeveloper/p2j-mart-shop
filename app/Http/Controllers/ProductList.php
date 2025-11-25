<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\UnitSize;
use App\Models\UnitColor;
use App\Models\UnitMatrial;
use App\Models\UnitDesign;
use App\Models\Product;
use App\Models\Productunit;
use App\Models\ProductImage;
use App\Models\ProductKeyPoint;
use App\Models\MetaTitle;
use App\Models\MetaDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Models\Attribute;

class ProductList extends Controller
{
    public function index(Request $request)
    {
        $subcategory= SubCategory::find($request->subcategory_id);
        Log::info($subcategory);           
          
        $UnitColor = UnitColor::where('web_status', '0')->where('is_deleted', '0')->orderBy('web_order')->get();

        // Fetch all dynamic attributes from the attributes table
        // Only fetch attributes whose id is present in $subcategory->selected_attributes
        $selectedAttributeIds = [];
        if (!empty($subcategory->selected_attributes) && is_array($subcategory->selected_attributes)) {
            $selectedAttributeIds = array_keys($subcategory->selected_attributes);
        } elseif (!empty($subcategory->selected_attributes) && is_string($subcategory->selected_attributes)) {
            // If stored as json string, decode it
            $decodedAttrs = json_decode($subcategory->selected_attributes, true);
            if (is_array($decodedAttrs)) {
                $selectedAttributeIds = array_keys($decodedAttrs);
            }
        }

        $attributes = Attribute::orderBy('display_order')
            ->where('status', 'active')
            ->where('attribute_slug', '!=', 'color')
            ->whereIn('id', $selectedAttributeIds)
            ->get();
        $dynamicAttributes = [];

        foreach ($attributes as $attribute) {
            // Build model class name: "Unit" . StudlyCase(Singular(slug))
            $modelName = 'Unit' . \Illuminate\Support\Str::studly(\Illuminate\Support\Str::singular($attribute->attribute_slug));
            $modelClass = "App\\Models\\$modelName";

            // Try to fetch options from the related table if the model class exists
            if (class_exists($modelClass)) {
                $options = $modelClass::where('web_status', '0')->where('is_deleted', '0')->orderBy('web_order')->get();
            } else {
                $options = collect();
            }

            $dynamicAttributes[] = [
                'attribute' => $attribute,
                'options' => $options,
            ];
        }

  

        $product = Product::where("product_id", $request->input('pid'))->first();
        DB::connection()->enableQueryLog();
        $productkeypoint = ProductKeyPoint::select('key')->where("product_id", $request->input('pid'))->get();
        $metatitle = MetaTitle::select('title')->where("product_id", $request->input('pid'))->get();
        $metadescription = MetaDescription::select('description')->where("product_id", $request->input('pid'))->get();

        // Properly convert keypoints collection to comma-separated string if needed
        if ($productkeypoint instanceof \Illuminate\Support\Collection && $productkeypoint->count() > 0) {
            $productkeypoint = implode(',', $productkeypoint->pluck('key')->toArray());
        }
      
        return view("product.add", compact('UnitColor','dynamicAttributes', 'product', 'productkeypoint', 'metatitle', 'metadescription'));
    }

 public function saveBasicdetails(Request $request)
    {
        $res["error_code"] = 400;

        Log::info($request->all());
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255',
            'subcategory_id' => 'required|integer',
            'quantity' => 'required|integer|min:1', // Add validation for quantity
            'description' => 'nullable|string',
            'height' => 'nullable|numeric',
            'height_unit' => 'nullable|string|in:mm,cm,in,m',
            'width' => 'nullable|numeric',
            'width_unit' => 'nullable|string|in:mm,cm,in,m',
            'weight' => 'nullable|numeric',
            'weight_unit' => 'nullable|string|in:g,kg',
            'collection' => 'nullable|boolean',
            'warranty' => 'nullable|string|max:255',
            'return_policy' => 'nullable|string|max:255',
            'delivery_mode' => 'nullable|string|max:255',
            'customize' => 'nullable|boolean',
            'custom_type' => 'nullable|in:text,image,both',
            'cust_description' => 'nullable|string|max:500',
        ]);

        $edit_id = $request->input('pid');
        
        $data = [
            "product_name" => $request->input('name'),
            "subcategory_id" => $request->input('subcategory_id'),
            "slug" => Str::slug($request->input('name')),
            "description" => $request->input('description'),
            "quantity" => $request->input('quantity'),
            "height" => $request->input('height'),
            "height_unit" => $request->input('height_unit'),
            "width" => $request->input('width'),
            "width_unit" => $request->input('width_unit'),
            "weight" => $request->input('weight'),
            "weight_unit" => $request->input('weight_unit'),
            "collection" => $request->input('collection'),
            "warranty" => $request->input('warranty'),
            "return_policy" => $request->input('return_policy'),
            "delivery_mode" => $request->input('delivery_mode'),
            "customize" => $request->input('customize', 0),
            "custom_type" => $request->input('custom_type', null),
            "cust_description" => $request->input('cust_description'),
            "step1" => 1
        ];

        if ($edit_id == 0) {
            $status = Product::create($data);
            Log::info('craete');
            Log::info($status);
            if ($status) {
                $res["error_code"] = 200;
                $res["product_id"] = $status->product_id;
            }
        } else {
            $status = Product::where('product_id', $edit_id)->update($data);
            if ($status) {
                $res["error_code"] = 200;
                $res["product_id"] = $edit_id;
            }
        }
        
        Log::info($res);
        return response()->json($res);
    }

    public function savePricedetails(Request $request)
    {
        $res["error_code"] = 400;
        $edit_id = $request->input('pid');

        $data["web_price"] = $request->input('base_price');
        $data["web_discount_price"] = $request->input('discount_price');
        $data["web_status"] = $request->input('in_stock');
        $data["collection"] = $request->input('collection');
        $data["step2"] = 1;

        $status = Product::where('product_id', $edit_id)->update($data);
        if ($status) {
            $res["error_code"] = 200;
        }

        return response()->json($res);
        
    }

    public function getUnitList(Request $request)
    {
        $edit_id = $request->input('pid');
        \Log::info('getUnitList edit_id: ' . $edit_id);

        // Find the product and its subcategory_id
        $product = \App\Models\Product::where('product_id', $edit_id)->first();

        if (!$product) {
            return response()->json(['data' => []]);
        }

        // Get the subcategory related to this product
        $subcategory = \App\Models\SubCategory::where('id', $product->subcategory_id)->first();

        if (!$subcategory) {
            return response()->json(['data' => []]);
        }

        // selected_attributes is expected as json in subcategory table
        $selectedAttributesRaw = $subcategory->selected_attributes ?? null;
        if (is_string($selectedAttributesRaw)) {
            $selectedAttributes = json_decode($selectedAttributesRaw, true);
        } else {
            $selectedAttributes = (array)$selectedAttributesRaw;
        }

        // Prepare select fields, always static fields:
        $selectFields = [
            'product_unit.product_unit_id',
            'product_unit.stock',
            'product_unit.unit_price',
            'product_unit.mrp_price',
            'm_color.color_name',
            'm_color.color_code',
            'm_color.m_color_id',
        ];

        // Join and select for remaining dynamic selected attributes if exist
        // Each attribute is stored as m_{attribute}_id and {attribute}_name columns

        $dynamicAttributes = [];
        if (!empty($selectedAttributes)) {
            foreach ($selectedAttributes as $attrId => $attrSlug) {
                // The 'color' attribute is already included statically (m_color_id, color_name)
                if ($attrSlug === 'color') continue;

                // Formulate table and column names
                $attrTable = 'm_' . $attrSlug;
                $attrIdColumn = 'm_' . $attrSlug . '_id';
                $attrNameColumn = $attrSlug . '_name';

                // Aliasing columns for DataTables
                $attrIdField = $attrTable . '.' . $attrIdColumn . ' as m_' . $attrSlug . '_id';
                $attrNameField = $attrTable . '.' . $attrNameColumn . ' as ' . $attrSlug . '_name';

                $selectFields[] = $attrIdField;
                $selectFields[] = $attrNameField;

                $dynamicAttributes[] = [
                    'slug' => $attrSlug,
                    'table' => $attrTable,
                    'attrIdColumn' => $attrIdColumn
                ];
            }
        }

        $query = \App\Models\Productunit::query()
            ->select($selectFields)
            ->leftJoin('m_color', 'product_unit.m_color_id', '=', 'm_color.m_color_id')
            ->where('product_unit.is_deleted', 0)
            ->where('product_unit.product_id', $edit_id);

        // Join for each dynamic attribute based on column convention
        foreach ($dynamicAttributes as $att) {
            // Join on: product_unit.m_{attr}_id = m_{attr}.m_{attr}_id
            $query->leftJoin($att['table'], 'product_unit.' . $att['attrIdColumn'], '=', $att['table'] . '.' . $att['attrIdColumn']);
        }

        $get = $query->get();

        if (!$get) {
            $get = [];
        }

        return response()->json(['data' => $get]);
    }

    public function uploadVideo(Request $request)
    {

        $res['error_code'] = 400;
        if ($video_url = $request->file('web_video')) {
            $img_id = $request->input('image_id');
            $image = $request->file('web_video');

            $imagePath = public_path() . '/uploads/products/videos';
            if (!file_exists($imagePath)) { 
                mkdir($imagePath, 0755, true);
            }
            $imageName = uniqid() . '.' . $image->extension();
            $image->move($imagePath, $imageName);
            $status = ProductImage::where('product_image_id', $img_id)->update(['web_video' => $imageName]);
            if ($status) {
                $res['error_code'] = 200;
            }
            return response()->json($res);
        }
    }

    public function uploadImages(Request $request)
    {
        Log::info($request->all());
    
        $res['error_code'] = 400;
        if ($video_url = $request->input('video_url')) {
            $img_id = $request->input('image_id');
            $status = ProductImage::where('product_image_id', $img_id)->update(['web_video' => $video_url]);
            if ($status) {
                $res['error_code'] = 200;
            }
            return response()->json($res);
        }
    
        // Extracting data from the request
        $imageunit = $request->input('imageunit');
        $pid = $request->input('pid');
        $imagecount = $request->input('imagecount');
        $image = $request->file('product_images');
    
        // Directory to save images
        $imagePath = public_path() . '/uploads/products';
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }
    
        // Generate unique filename for the image
        $imageName = uniqid() . Str::slug($image->getClientOriginalName()) . '.' . $image->extension();
        $outputPath = $imagePath . '/' . $imageName;
    
        // Move the uploaded image to the directory without processing it
        $status = $image->move($imagePath, $imageName);
    
        if ($status) {
            if (ProductImage::where('product_image_id', $imageunit)->update(['web_image_' . $imagecount => $imageName])) {
                $res['error_code'] = 200;
                Product::where('product_id', $pid)->update(["step4" => 1]);
            }
        }
    
        return response()->json($res);
    
    }
    
    

    public function deleteProductVideo(Request $request)
    {

        $res['error_code'] = 400;
        $imageunit = $request->input('imageunit');
        $get_video = ProductImage::where('product_image_id', $imageunit)->get();

        if ($video_name = $get_video[0]->web_video) {

            $file_to_delete = getcwd() . '/uploads/products/videos' . '/' . $video_name;
            file_exists($file_to_delete) ? unlink($file_to_delete) : '';
            ProductImage::where('product_image_id', $imageunit)->update(['web_video' => null]);
            $res['error_code'] = 200;
            return response()->json($res);
        }
        return response()->json($res);
    }

    public function deleteProductImages(Request $request)
    {
        $res['error_code'] = 400;
        $imageunit = $request->input('imageunit');
        $pid = $request->input('pid');
        $imagecount = $request->input('imagecount');


        if (ProductImage::where('product_image_id', $imageunit)->update(['web_image_' . $imagecount => null])) {
            $res['error_code'] = 200;
        }
        return response()->json($res);
    }

    public function deleteProduct(Request $request)
    {

        $res["error_code"] = 400;
        $res["error_meg"] = "Deleted Failed";
        $id = $request->input('id');

        $pro_images = DB::table('product_image')->where('product_id', $id)->get();

        foreach ($pro_images as $pro_image) {

            $fields = ['web_image_1', 'web_image_2', 'web_image_3', 'web_image_4', 'web_image_5', 'web_video'];

            foreach ($fields as $field) {
                if (!is_null($pro_image->$field)) {
                    if ($field == 'web_video') {
                        $file_to_delete = public_path('uploads/products/videos/' . $pro_image->$field);
                        file_exists($file_to_delete) ? unlink($file_to_delete) : '';
                    } else {
                        $file_to_delete = public_path('uploads/products/' . $pro_image->$field);
                        file_exists($file_to_delete) ? unlink($file_to_delete) : '';
                    }
                }
            }
        }

        $status = DB::table('product_unit')->where('product_id', $id)->delete();
        $status = DB::table('product_keypoints')->where('product_id', $id)->delete();
        $status = DB::table('product_meta_description')->where('product_id', $id)->delete();
        $status = DB::table('product_image')->where('product_id', $id)->delete();
        $status = DB::table('product_meta_title')->where('product_id', $id)->delete();
        $status = Product::where('product_id', $id)->delete();

        // $status = Product::where('product_id', $id)->update(["is_deleted" => 1]);
        if ($status) {
            $res["error_code"] = 200;
            $res["error_meg"] = "Deleted Successfully";
        }
        return response()->json($res);
    }

    public function saveWordProduct(Request $request)
    {
        $res['error_code'] = 400;
        $keypoint = $request->input('keypoint');
        $data["product_id"] = $request->input('pid');

        ProductKeyPoint::where('product_id', $data["product_id"])->delete();

        foreach (explode(',', $keypoint) as $gg) {
            $data["key"] = $gg;
            ProductKeyPoint::create($data);
        }
        Product::where('product_id', $data["product_id"])->update(["step5" => 1]);
        //        if( ProductKeyPoint::where('product_image_id', $imageunit)->update(['web_image_'.$imagecount => null])){
        $res['error_code'] = 200;
        //        }
        return response()->json($res);
    }


    public function saveMetaTitle(Request $request)
    {
        $res['error_code'] = 400;
        $input = $request->input('input');
        $data["product_id"] = $request->input('pid');

        MetaTitle::where('product_id', $data["product_id"])->delete();

        foreach (explode(',', $input) as $get) {
            $data["title"] = $get;
            MetaTitle::create($data);
        }
        Product::where('product_id', $data["product_id"])->update(["step6" => 1]);
        $res['error_code'] = 200;
        return response()->json($res);
    }

    public function saveMetaDescription(Request $request)
    {
        $res['error_code'] = 400;
        $input = $request->input('input');
        $data["product_id"] = $request->input('pid');

        MetaDescription::where('product_id', $data["product_id"])->delete();

        foreach (explode(',', $input) as $get) {
            $data["description"] = $get;
            MetaDescription::create($data);
        }
        Product::where('product_id', $data["product_id"])->update(["step7" => 1]);
        $res['error_code'] = 200;
        return response()->json($res);
    }




    public function getProductImage(Request $request)
    {
        $productId = $request->input('pid');

        // First get product units by productId, order by product_unit_id ASC, then get images for those units
        $units = Productunit::where('product_id', $productId)
            ->orderBy('product_unit_id', 'asc')
            ->get();

        $unitIds = $units->pluck('product_unit_id')->all();

        $images = collect();
        if (!empty($unitIds)) {
            $images = ProductImage::select('product_image.*', 'm_color.color_name', 'm_color.color_code')
                ->whereIn('product_unit_id', $unitIds)
                ->join('m_color', 'm_color.m_color_id', '=', 'product_image.m_color_id')
                ->orderByRaw('FIELD(product_unit_id, ' . implode(',', $unitIds) . ')')
                ->get();
        }
            Log::info(print_r($images,true));
        return response()->json([
            'images' => $images,
            'error_code' => $images->isNotEmpty() ? 200 : 400,
        ]);
    }


    public function deleteUnitList(Request $request)
    {
        $res["error_code"] = 400;
        if (Productunit::where('product_unit_id', $request->input('uid'))->delete()) {
            $res["error_code"] = 200;
        }
        return response()->json($res);
    }

    public function storeUnitdetails(Request $request)
    {
        Log::info($request->all());
        $res["error_code"] = 400;

        // Prepare the base data array with required keys
        $data = [];
        $unit_id = $request->input('uid');

        // Always require product_id, fall back to 'pid'
        $data["product_id"] = $request->input('pid');

        // Dynamically add all attributes EXCEPT meta fields
        foreach ($request->all() as $key => $val) {
            // Exclude CSRF and routing-specific params
            if (in_array($key, ['_token', 'pid', 'uid'])) {
                continue;
            }
            // Allow all others directly
            $data[$key] = $val;
        }
        

        if ($unit_id == 0 || $unit_id == '') {



          
                // Columns to exclude from duplicate check
                // Find perfectly matched unit rows for this product, based only on attribute values (not using copy_unit_id in any way)
                $excludeKeys = [
                    'created_by', 'created_at', 'updated_by', 'updated_at',
                    'stock', 'product_unit_id', 'product_id','mrp_price','unit_price','is_deleted','product_id'
                ];

                $attributesToCheck = [];
                foreach ($data as $key => $val) {
                    if (!in_array($key, $excludeKeys) && $val !== null && $val !== '') {
                        $attributesToCheck[$key] = $val;
                    }
                }

                $query = Productunit::where('product_id', $request->input('pid'))
                    ->where('is_deleted', 0);

                // Only use the relevant attribute columns for searching matched rows
                foreach ($attributesToCheck as $key => $val) {
                    $query->where($key, $val);
                }

                // No reference to copy_unit_id at all

                $existingUnit = $query->first();

                if ($existingUnit) {
                    $res['error_code'] = 409;
                    $res['message'] = 'A unit with the same attributes already exists for this product.';
                    return response()->json($res);
                }
         
            $status = Productunit::create($data);

            if ($status) {
                $id = DB::getPdo()->lastInsertId();
                DB::statement("CALL getRadom($id)");
                $res["error_code"] = 200;
                Product::where('product_id', $data["product_id"])->update(["step2" => 1]);
            }
        } else {


            $excludeKeys = [
                'created_by', 'created_at', 'updated_by', 'updated_at',
                'stock', 'product_unit_id', 'product_id','mrp_price','unit_price','is_deleted','product_id'
            ];

            $attributesToCheck = [];
            foreach ($data as $key => $val) {
                if (!in_array($key, $excludeKeys) && $val !== null && $val !== '') {
                    $attributesToCheck[$key] = $val;
                }
            }

            $query = Productunit::where('product_id', $request->input('pid'))
                ->where('is_deleted', 0);

            // Only use the relevant attribute columns for searching matched rows
            foreach ($attributesToCheck as $key => $val) {
                $query->where($key, $val);
            }

            // No reference to copy_unit_id at all

            $existingUnit = $query->first();
            if ( $existingUnit ){

               Log::info('dfgdgg');
               Log::info($unit_id);
               Log::info($existingUnit);
            if ( $existingUnit->product_unit_id!=$unit_id) {
                $res['error_code'] = 409;
                $res['message'] = 'A unit with the same attributes already exists for this product.';
                return response()->json($res);
            }
        }
            $status = Productunit::where('product_unit_id', $unit_id)->update($data);
            if ($status) {
                $res["error_code"] = 200;
                Product::where('product_id', $data["product_id"])->update(["step2" => 1]);
            }
        }
        return response()->json($res);
    }

    public function uploadMultipleImages(Request $request)
    {

        $id = $request->input('id');
        $multiple_images = $request->file('multiple_images');

        $imagePath = public_path() . '/uploads/products';
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }
        $pro = Products::where('id', $id)->first();

        $existingImages = json_decode($pro->multiple_images, true);

        foreach ($multiple_images as $image) {
            $imageName = uniqid() . '.' . $image->extension();
            $image->move($imagePath, $imageName);
            $existingImages[] = $imageName;
        }

        $data['multiple_images'] = json_encode($existingImages);

        $pro->update($data);

        return response()->json(['success' => 'Your Image is uploaded successfully']);
    }

    public function categoryAddProduct($id)
    {
        $cate = Category::where('id', $id)->get();
        // $cat_id = $cat[0]->id;
        $category = Category::where('status', 'Active')->get();
        $sort_count = Products::where('cat_id', $id)->count() + 1;
        // dd($cate);
        return view("admin-products.add-edit-product", compact("category", "cate", "sort_count"));
    }



    public function getProducts(Request $request)
    {

        $category = Category::get();

        $cat_id = $request->input('catId');
        $products = Products::where('cat_id', $cat_id)->orderBy('sort_order', 'ASC');
        if (isset($request->search) && $request->search['value'] != '') {
            $products = $products->where('name', 'LIKE', '%' . $request->search['value'] . '%');
        }
        $products = $products->get();

        $datalist = [];

        foreach ($products as $list) {
            $status = $list['status'];
            $cate = $list['category'];
            $collection = $list['collection'];
            $in_stock = $list['in_stock'];
            $sort_order = $list["sort_order"];
            $status = $list["status"];
            $images = json_encode($list['multiple_images']);
            $mul_image = htmlspecialchars(($list['multiple_images']));

            $height = isset($list['height']) ? $list['height'] : 'null';
            $height_unit = isset($list['height_unit']) ? $list['height_unit'] : 'null';
            $width = isset($list['width']) ? $list['width'] : 'null';
            $width_unit = isset($list['width_unit']) ? htmlspecialchars($list['width_unit']) : 'null';
            $weight = isset($list['weight']) ? $list['weight'] : 'null';
            $weight_unit = isset($list['weight_unit']) ? htmlspecialchars($list['weight_unit']) : 'null';
            $variants = isset($list['variants']) ? htmlspecialchars($list['variants']) : 'null';

            $list->sort_order = '<input type="text" class="custom-border sort_order" name="sort_order" id="sort_order"  value="' . $list["sort_order"] . '">
                                <input type="hidden" class="old_sort" name="old_sort" value="' . $list["sort_order"] . '">';

            $list->image = '<div class="row">

                                <div class="">
                                    <button type="button" class="btn btn-primary upload-btnn" data-bs-toggle="modal" onclick="imageuploads(' . $list['id'] . ',\'' . $mul_image . '\')" data-bs-target="#uploadModal">
                                        <i class="fa-solid fa-upload"></i>
                                    </button>
                                </div>
                            </div>';

            $list->varient = '<div class="row">
                            <div class="" style="">
                                <button type="button" class="btn btn-primary upload-btnn" data-bs-toggle="modal" onclick="updateVarients(' . $list['id'] . ',' . $variants . ',' . $height . ',\'' . $height_unit . '\',' . $width . ',\'' . $width_unit . '\',' . $weight . ',\'' . $weight_unit . '\')" data-bs-target="#variantModal">
                                    <i class="fa-solid fa-list"></i>
                                </button>
                            </div>
                        </div>';

            $list->name = '<input type="text" class="custom-border name" id="name" name="name" value="' . $list['name'] . '">';
            $list->name .= '<input type="hidden" class="id" name="id" value="' . $list['id'] . '">';

            $list->category = '<select class="form-control category category-select" name="category" style="width: fit-content !important;" >
                                    <option>Select Category</option>';

            foreach ($category as $val) {
                $list->category .= '<option value="' . $val->name . '" ' . (isset($list) && $cate == $val->name ? 'selected' : '') . '>' . $val->name . '</option>';
            }

            $list->category .= '</select>';

            $list->quantity = '<input type="text" class="custom-border quantity" name="qty" value="' . $list['qty'] . '">';
            $list->price = '<div class="td-price">
                            <input type="text" class="custom-border price" name="base_price" value="' . $list['base_price'] . '"></div> ';
            $list->discount_price = '<div class="td-price">
                            <input type="text" class="custom-border price" name="discount_price" value="' . $list['discount_price'] . '"></div> ';
            $list->collection = '<select  class="feature  form-control w-100 category-select" name="collection">';
            $list->collection .= '<option value="trending-collection" ' . ($collection == 'trending-collection' ? 'selected' : '') . '>Trending Collection</option>';
            $list->collection .= '<option value="null" ' . ($collection == 'null' ? 'selected' : '') . '>None</option>';
            $list->collection .= '</select>';

            $list->in_stock = '<select style=" width: fit-content !important;" class="feature  form-control w-100 category-select" name="in_stock">';
            $list->in_stock .= '<option value="true" ' . ($in_stock == 'true' ? 'selected' : '') . '>Available</option>';
            $list->in_stock .= '<option value="false" ' . ($in_stock == 'false' ? 'selected' : '') . '>Not Available</option>';
            $list->in_stock .= '</select>';

            $list->status = '<select class="form-control w-100 status category-select" name="status" style="
                width: fit-content !important; ">';

            $list->status .= '<option >Select </option>';

            $list->status .= '<option value="Active" ' . ($status == "Active" ? 'selected' : '') . '>Active</option>';
            $list->status .= '<option value="Deactive" ' . ($status == "Deactive" ? 'selected' : '') . '>Deactive</option>';

            $list->video_url = ' <input type="text" class="video-url custom-border" name="video_url" value="' . $list['video_url'] . '">';

            $list->status .= '</select>';

            // $list->description = '<textarea class="description form-control" name="description">' . ($list['description'] ?? '') . '</textarea>';
            // $list->description .= '<input type="hidden" class="old_sort" name="old_sort" value="' . $sort_order . '">';
            $list->description = ' <div class="">
                                            <button type="button" class="btn btn-primary m-0" data-bs-toggle="modal" onclick="updateDesc(' . $list['id'] . ',\'' . htmlentities($list['description']) . '\')" data-bs-target="#descModal">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                       </div>';

            $list->action = '<div class="d-flex align-items-center justify-content-center">
                                        <a href="' . route('admin-delete-products', ['id' => $list['id']]) . '">
                                        <i class="fas fa-trash" style="color:#bf0e0e;"></i>
                                        </a>
                            </div>';
            /* Commented edit due to dynamic update from the table
              <li>
              <a href="' . route('edit-category-product', ['id' => $list['id']]) . '">
              <i class="ri-pencil-line"></i>
              </a>
              </li> */

            $list->cat_id = $cat_id;

            $datalist[] = $list;
        }
        $products_count = Products::where('cat_id', $cat_id)->count();
        $json_data = ['data' => $datalist, 'total' => $products_count];

        return json_encode($json_data);
    }

    public function updateVariants(Request $request)
    {

        $variants = $request->input('variant');
        $request->merge(['variants' => $variants]);
        $data = $request->except('id', 'variant');

        Products::find($request->input('id'))->update($data);
        return response()->json(['success' => 'Your Data updated successfully']);
    }

    public function updateTable(Request $request)
    {


        $category = $request->input('category');
        $pro_name = $request->input('name');

        // $desc = $request->input('description');

        if ($pro_name == "description") {
            $id = $request->input('id');
            $desc = $request->input('value');
            Products::find($id)->update(['description' => $desc]);
            return response()->json(['success' => 'Your changes is saved successfully']);
        }

        if ($pro_name == "name") {
            $pro_name = $request->input('value');
            $slug = Str::slug($pro_name);
            $val = Products::where('cat_id', $category)->where('slug', $slug)->count();
            if ($val > 0) {
                return response()->json(['error' => 'The Product name already exist in this category']);
            }
            $data['slug'] = Str::slug($pro_name);
        }

        $id = $request->input('id');
        $field_name = $request->input('name');
        $value = $request->input('value');
        $old_sort = $request->input('old_sort');
        if ($old_sort) {
            $count = Products::where('cat_id', $request->input('category'))->count();

            $sort_order = (int) $value;
            $old_sort = (int) $old_sort;
        }

        if ($value == null) {
            if (($request->input('name') != "video_url")) {
                return response()->json(['error' => $field_name . ' field must have a value']);
            }
        }

        $rules = [
            'id' => 'required',
            'name' => 'required',
            //    'value' => 'required',
        ];

        if ($old_sort) {
            $rules['value'] = 'required|integer|min:1|max:' . $count;
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            // return response()->json(['error'=>$validator->errors()]);
            return response()->json(['error' => $validator->errors()->first()]);
        }


        if (isset($sort_order) && isset($old_sort) && $sort_order != $old_sort) {

            Products::where('cat_id', $request->category)->where('sort_order', $sort_order)->update(['sort_order' => $old_sort]);
        }

        $data[$field_name] = $value;

        if ($pro_name == "category") {
            $id = $request->input('id');
            $value = $request->input('value');
            $cat = Category::where('name', $value)->get();
            $pro_count = Products::where('cat_slug', $cat[0]->slug)->count() + 1;
            $data['cat_id'] = $cat[0]->id;
            $data['cat_slug'] = $cat[0]->slug;
            $data['sort_order'] = $pro_count;

            $products = DB::table('products')->where('cat_id', $category)->where('id', $id)->get();
            $pro_count = DB::table('products')->where('cat_id', $category)->count();

            for ($i = $products[0]->sort_order; $i <= $pro_count; $i++) {
                $update = ['sort_order' => $i];
                $products = DB::table('products')->where('cat_id', $category)->where('sort_order', ($i + 1))->update($update);
            }
        }

        $products = Products::find($id)->update($data);

        if ($products) {
            return response()->json(['success' => 'Your changes is saved successfully']);
        } else {
            return response()->json(['error' => 'Failed to Change the Data']);
        }
    }

    public function create()
    {

        $category = Category::where('status', 'Active')->get();
        return view("admin-products.add-edit-product", compact("category"));
    }

    public function removeImageFromStorage($filename)
    {

        $file_location = getcwd() . '/uploads/products' . '/' . $filename;
        $fileToDelete = 'public/uploads/products' . '/' . $filename;
        if (unlink($file_location)) {
            return true;
        } else {
            return false;
        }
    }

    public function manageImages(Request $request)
    {

        $productId = $request->id;
        $imageToRemove = $request->image;
        $product = Products::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        $multipleImages = json_decode($product->multiple_images, true);

        $key = array_search($imageToRemove, $multipleImages);

        if ($key !== false) {
            unset($multipleImages[$key]);

            $updatedImages = json_encode(array_values($multipleImages));
            $product->multiple_images = $updatedImages;
            $product->save();
            $this->removeImageFromStorage($imageToRemove);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Image not found'], 404);
        }
    }

    public function store(Request $request)
    {

        $edit_id = $request->input('is_edit');
        $id = $request->input('id');
        $cat_id = $request->input('cat_id');

        $sort_order = $request->input('sort_order');
        $old_sort = $request->input('old_sort');
        $cat = Category::where('id', $cat_id)->get();
        $cat_slug['cat_slug'] = $cat[0]->slug;
        $request->merge($cat_slug);
        $count = Products::where('cat_id', $cat_id)->count();
        if ($name = $request->input('name')) {
            $slug = Str::slug($name);
            $pro_count = Products::where('cat_id', $cat_id)->where('slug', $slug)->count();
            if ($pro_count > 0) {
                return redirect()->back()->withErrors('This Name already exist in this category');
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|string|max:100',
            'multiple_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'required|integer|min:1|max:' . $count + 1,
            // 'height' => 'required',
            // 'height_unit' => 'required',
            // 'width' => 'required',
            // 'width_unit' => 'required',
            // 'weight' => 'required',
            // 'weight_unit' => 'required',
            'base_price' => 'required',
            'qty' => 'required',
            // 'discount_price' => 'required',
            'in_stock' => 'required',
            'category' => 'required',
            'collection' => 'required',
            'status' => 'required',
        ]);
        // dd($id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        // dd($request->all());
        $imagePath = public_path() . '/uploads/products';

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $data = [];

        if ($sort_order != $count) {
            Products::where('category', $request->category)->where('sort_order', $sort_order)->update(['sort_order' => $count]);
        }

        $oldImages = json_decode($request->input('old_image'), true);
        $multiple_images = $oldImages ?? [];
        $mul_images = $request->file('multiple_images');
        if ($mul_images) {
            foreach ($mul_images as $images) {
                $imageName = uniqid() . '.' . $images->extension();
                $images->move($imagePath, $imageName);
                $multiple_images[] = $imageName;
            }
            $data['multiple_images'] = json_encode($multiple_images);
        }

        $variant = $request->input('variant');
        if ($variant[0]['name'] != null && $variant[0]['value'] != null) {
            $data['variants'] = json_encode($variant);
        }
        $data['slug'] = Str::slug($request->input('name'));
        $data += $request->except('_token', 'old_sort', 'is_edit', 'old_image', 'variant', 'multiple_images');

        if (isset($edit_id) && $edit_id != 0) {

            if (isset($sort_order) && isset($old_sort) && $sort_order != $old_sort) {

                Products::where('category', $request->category)->where('sort_order', $sort_order)->update(['sort_order' => $old_sort]);
            }


            $status = Products::find($edit_id)->update($data);
        } else {
            $status = Products::create($data);
        }

        if ($status) {
            return redirect()->route('products.show', ['product' => $cat_id])->with('success', 'Your Data is successfully Created');
        } else {
            // return response()->json(['error' => $validator->errors()], 422);
            return redirect()->back()->withErrors($validator)->withMessage('Failed to Create Data');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd($id);
        $cat = Category::where('id', $id)->get();
        $products = Products::where('cat_id', $id)->get();
        $total_count = Products::where('cat_id', $id)->count();

        $products_count = Products::where("status", "Active")->where('cat_id', $id)->count();
        $products_out_of_stock = Products::where('cat_id', $id)
            ->where("qty", "<=", 0)
            ->orWhere("in_stock", "false")->where('cat_id', $id)
            ->count();

        return view("admin-products.category-wise-products", compact("cat", "products", "total_count", "products_count", "products_out_of_stock"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editProduct(Request $request)
    {

        $id = $request->input('id');
        $cat_id = $request->input('cat_id');
        $cate = Category::where('id', $cat_id)->get();
        $product = Products::where('id', $id)->get();
        $category = Category::where('status', 'Active')->get();
        $sort_count = Products::where('cat_id', $cat_id)->count();

        return view("admin-products.add-edit-product", compact("category", "product", "cate", "sort_count"));
    }

    public function delete($id)
    {

        $pro = Products::where('id', $id)->get();
        $pro_count = Products::where('cat_id', $pro[0]->cat_id)->count();

        if ((json_decode($pro[0]->multiple_images))) {

            foreach (json_decode($pro[0]->multiple_images) as $image) {
                $file_to_delete = getcwd() . '/uploads/products' . '/' . $image;
                unlink($file_to_delete);
            }
        }

        for ($i = $pro[0]->sort_order; $i <= $pro_count; $i++) {
            $update = ['sort_order' => $i];
            DB::table('products')->where('sort_order', ($i + 1))->update($update);
        }

        $status = Products::where('id', $id)->delete();
        if ($status) {
            return redirect()->back()->With("You're data is successfully deleted");
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProduct(Request $request, $id)
    {
        $edit_id = $request->input('is_edit');
        $id = $request->input('id');
        $cat_id = $request->input('cat_id');

        $sort_order = $request->input('sort_order');
        $old_sort = $request->input('old_sort');
        $cat = Category::where('id', $cat_id)->get();
        $cat_slug['cat_slug'] = $cat[0]->slug;
        $request->merge($cat_slug);
        $count = Products::where('cat_id', $cat_id)->count();
        $product = Products::where('id', $request->input('is_edit'))->get();

        $pro_count = Products::where('cat_id', $cat_id)->where('name', $request->input('name'))->count();
        if ($product[0]->name != $request->input('name') && $pro_count > 0) {
            // dd('Val fail');
            return redirect()->back()->withErrors('The Product name already exist');
        }

        $validator = Validator::make($request->all(), [
            // 'name' => 'required|unique:products,name,'.$edit_id.',id',
            'description' => 'required|string|max:100',
            // 'multiple_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order' => 'required|integer|min:1|max:' . $count + 1,
            // 'height' => 'required',
            // 'height_unit' => 'required',
            // 'width' => 'required',
            // 'width_unit' => 'required',
            // 'weight' => 'required',
            // 'weight_unit' => 'required',
            'base_price' => 'required',
            'qty' => 'required',
            // 'discount_price' => 'required',
            'in_stock' => 'required',
            'category' => 'required',
            'collection' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            dd('Val fail');
            return redirect()->back()->withErrors($validator);
        }
        // dd($request->all());
        $imagePath = public_path() . '/uploads/products';

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $data = [];

        $oldImages = json_decode($request->input('old_image'), true);
        $multiple_images = $oldImages ?? [];
        $mul_images = $request->file('multiple_images');
        if ($mul_images) {
            foreach ($mul_images as $images) {
                $imageName = uniqid() . '.' . $images->extension();
                $images->move($imagePath, $imageName);
                $multiple_images[] = $imageName;
            }
            $data['multiple_images'] = json_encode($multiple_images);
        }

        $variant = $request->input('variant');
        if ($variant[0]['name'] != null && $variant[0]['value'] != null) {
            $data['variants'] = json_encode($variant);
        }
        // dd($cat[0]->id);
        $data += $request->except('_token', 'old_sort', 'is_edit', 'old_image', 'variant', 'multiple_images');
        // dd($data);

        if (isset($sort_order) && isset($old_sort) && $sort_order != $old_sort) {

            Products::where('category', $request->category)->where('sort_order', $sort_order)->update(['sort_order' => $old_sort]);
        }

        $status = Products::find($edit_id)->update($data);

        if ($status) {

            return redirect()->route('products.show', ['product' => $cat_id])->with('success', 'Your Data is successfully Changed');
        } else {

            // return response()->json(['error' => $validator->errors()], 422);
            return redirect()->back()->withErrors($validator)->withMessage('Failed to Update Data');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
