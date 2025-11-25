<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Models\Products;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProducts extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $total_count = Product::count();
        $products_count = DB::table('product')->where('web_status','<>', 1)->count();
        $products_out_of_stock = Products::where("qty", "<=", 0)->orWhere("in_stock", "false")->count();
        return view("admin-products.list-products", compact("products", "total_count", "products_count", "products_out_of_stock"));
    }

    public function subcategoryAddProduct($id)
    {
        $cate = SubCategory::where('id',$id)->get();
        // $subcategory_id = $cat[0]->id;
        $subcategory = SubCategory::where('status', 'Active')->get();
        $sort_count = Products::where('subcategory_id',$id)->count()+1;
        // dd($cate);
        return view("admin-products.add-edit-product", compact("subcategory","cate","sort_count"));

    }

    public function getProducts(Request $request){

        $subcategory = SubCategory::get();

        $subcategory_id = $request->input('catId');
         $products = Products::where('subcategory_id',$subcategory_id)->orderBy('sort_order','ASC');
        if(isset($request->search) && $request->search['value'] != '') {
            $products = $products->where('name', 'LIKE', '%' . $request->search['value'] . '%');
        }
            $products = $products->get();

          $datalist = [];

        foreach($products  as $list)
        {
                            $status = $list['status'];
                            $cate = $list['subcategory'];
                            $collection = $list['collection'];
                            $in_stock = $list['in_stock'];
                            $sort_order = $list["sort_order"];
                            $status = $list["status"];
                            $images = json_encode($list['multiple_images']);
                            $mul_image = htmlspecialchars(($list['multiple_images']));

                            $height = isset($list['height']) ? $list['height'] : 'null';
                            $height_unit = isset($list['height_unit'])?$list['height_unit']:'null' ;
                            $width = isset($list['width'])?$list['width']:'null';
                            $width_unit = isset($list['width_unit'])?htmlspecialchars($list['width_unit']):'null';
                            $weight = isset($list['weight'])?$list['weight']:'null';
                            $weight_unit = isset($list['weight_unit'])? htmlspecialchars($list['weight_unit']):'null';
                            $variants = isset($list['variants'])? htmlspecialchars($list['variants']):'null';


            $list->sort_order = '<input type="text" class="custom-border sort_order" name="sort_order" id="sort_order"  value="'.$list["sort_order"].'">
                                <input type="hidden" class="old_sort" name="old_sort" value="'.$list["sort_order"].'">';

            $list->image = '<div class="row">

                                <div class="">
                                    <button type="button" class="btn btn-primary upload-btnn" data-bs-toggle="modal" onclick="imageuploads(' . $list['id'] .',\'' .  $mul_image . '\')" data-bs-target="#uploadModal">
                                        <i class="fa-solid fa-upload"></i>
                                    </button>
                                </div>
                            </div>';

            $list->varient = '<div class="row">
                            <div class="" style="">
                                <button type="button" class="btn btn-primary upload-btnn" data-bs-toggle="modal" onclick="updateVarients('. $list['id'] .','.  $variants .','.  $height .',\''. $height_unit .'\','. $width .',\''. $width_unit .'\','. $weight .',\''. $weight_unit .'\')" data-bs-target="#variantModal">
                                    <i class="fa-solid fa-list"></i>
                                </button>
                            </div>
                        </div>';

              $list->name =     '<input type="text" class="custom-border name" id="name" name="name" value="'.$list['name'].'">';
              $list->name .= '<input type="hidden" class="id" name="id" value="' .$list['id'] . '">' ;

              $list->subcategory = '<select class="form-control subcategory subcategory-select" name="subcategory" style="width: fit-content !important;" >
                                    <option>Select SubCategory</option>';

                            foreach ($subcategory as $val) {
                                $list->subcategory .= '<option value="' . $val->name . '" ' . (isset($list) && $cate == $val->name ? 'selected' : '') . '>' . $val->name . '</option>';
                                    }

                $list->subcategory .= '</select>';

              $list->quantity = '<input type="text" class="custom-border quantity" name="qty" value="'.$list['qty'].'">';
              $list->price ='<div class="td-price">
                            <input type="text" class="custom-border price" name="base_price" value="'.$list['base_price'].'"></div> ';
              $list->discount_price ='<div class="td-price">
                            <input type="text" class="custom-border price" name="discount_price" value="'.$list['discount_price'].'"></div> ';
              $list->collection = '<select  class="feature  form-control w-100 subcategory-select" name="collection">';
                $list->collection .= '<option value="trending-collection" ' . ($collection == 'trending-collection' ? 'selected' : '') . '>Trending Collection</option>';
                $list->collection .= '<option value="null" ' . ($collection == 'null' ? 'selected' : '') . '>None</option>';
                $list->collection .= '</select>';

                $list->in_stock = '<select style=" width: fit-content !important;" class="feature  form-control w-100 subcategory-select" name="in_stock">';
                $list->in_stock .= '<option value="true" ' . ($in_stock == 'true' ? 'selected' : '') . '>Available</option>';
                $list->in_stock .= '<option value="false" ' . ($in_stock == 'false' ? 'selected' : '') . '>Not Available</option>';
                $list->in_stock .= '</select>';

                $list->status = '<select class="form-control w-100 status subcategory-select" name="status" style="
                width: fit-content !important; ">';

                $list->status .= '<option >Select </option>';

                $list->status .= '<option value="Active" ' . ($status == "Active" ? 'selected' : '') . '>Active</option>';
                $list->status .= '<option value="Deactive" ' . ($status == "Deactive" ? 'selected' : '') . '>Deactive</option>';

                $list->video_url = ' <input type="text" class="video-url custom-border" name="video_url" value="'.$list['video_url'].'">';


                $list->status .= '</select>';

                // $list->description = '<textarea class="description form-control" name="description">' . ($list['description'] ?? '') . '</textarea>';
                // $list->description .= '<input type="hidden" class="old_sort" name="old_sort" value="' . $sort_order . '">';
                $list->description = ' <div class="">
                                            <button type="button" class="btn btn-primary m-0" data-bs-toggle="modal" onclick="updateDesc(' . $list['id'] .',\'' . htmlentities($list['description']) . '\')" data-bs-target="#descModal">
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
                                        <a href="' . route('edit-subcategory-product', ['id' => $list['id']]) . '">
                                            <i class="ri-pencil-line"></i>
                                        </a>
                                    </li>*/

            $list->subcategory_id = $subcategory_id;

            $datalist[] = $list;

        }
        $products_count = Products::where('subcategory_id',$subcategory_id)->count();
        $json_data = ['data'=> $datalist, 'total'=> $products_count ];

        return json_encode($json_data);
    }

    public function uploadMultipleImages(Request $request){

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

        return response()->json(['success'=>'Your Image is uploaded successfully']);
    }
    public function updateVariants(Request $request){

        $variants = $request->input('variant');
        $request->merge(['variants'=>$variants]);
        $data = $request->except('id','variant');

        Products::find($request->input('id'))->update($data);
        return response()->json(['success'=>'Your Data updated successfully']);
    }

    public function updateTable(Request $request){

        $subcategory = $request->input('subcategory');
        $pro_name = $request->input('name');

        // $desc = $request->input('description');

        if($pro_name == "description"){
            $id = $request->input('id');
            $desc = $request->input('value');
            Products::find($id)->update(['description'=>$desc]);
            return response()->json(['success'=>'Your changes is saved successfully']);
        }

        if($pro_name == "name")
        {
           $pro_name =  $request->input('value');
           $slug = Str::slug($pro_name);
            $val = Products::where('subcategory_id',$subcategory)->where('slug',$slug)->count();
           if($val>0){
                return response()->json(['error'=>'The Product name already exist in this subcategory' ]);
           }
            $data['slug'] = Str::slug($pro_name);
        }

           $id = $request->input('id');
           $field_name = $request->input('name');
           $value = $request->input('value');
           $old_sort = $request->input('old_sort');
       if($old_sort) {
           $count = Products::where('subcategory_id',$request->input('subcategory'))->count();

               $sort_order = (int) $value;
               $old_sort = (int)$old_sort;
       }

       if($value==null){
            if(($request->input('name')!="video_url")){
                return response()->json(['error'=> $field_name. ' field must have a value' ]);
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

           Products::where('subcategory_id',$request->subcategory)->where('sort_order', $sort_order)->update(['sort_order'=>$old_sort]);
       }

           $data[$field_name] = $value;

       if($pro_name == "subcategory")
        {
           $id = $request->input('id');
           $value = $request->input('value');
           $cat = SubCategory::where('name',$value)->get();
           $pro_count = Products::where('cat_slug',$cat[0]->slug)->count()+1;
           $data['subcategory_id']=$cat[0]->id;
           $data['cat_slug']=$cat[0]->slug;
           $data['sort_order']=$pro_count;

           $products = DB::table('products')->where('subcategory_id' ,$subcategory)->where('id',$id)->get();
           $pro_count = DB::table('products')->where('subcategory_id' ,$subcategory)->count();

           for($i = $products[0]->sort_order; $i <= $pro_count; $i++ ){
               $update = ['sort_order'=> $i];
               $products = DB::table('products')->where('subcategory_id',$subcategory)->where('sort_order' ,($i+1))->update($update);
           }

        }

          $products = Products::find($id)->update($data);

         if($products){
               return response()->json(['success'=>'Your changes is saved successfully']);

         }else{
               return response()->json(['error'=>'Failed to Change the Data']);
           }


    }


    public function create()
    {

        $subcategory = SubCategory::where('status', 'Active')->get();
        return view("admin-products.add-edit-product", compact("subcategory"));
    }

    public function removeImageFromStorage($filename)
    {

        $file_location = getcwd() . '/uploads/products'.'/'.$filename;
        $fileToDelete = 'public/uploads/products'.'/'.$filename;
            if (unlink($file_location)) {
               return true;
            } else {
                return false;
            }
    }

    public function manageImages(Request $request){

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
        $subcategory_id = $request->input('subcategory_id');

        $sort_order = $request->input('sort_order');
        $old_sort = $request->input('old_sort');
        $cat = SubCategory::where('id',$subcategory_id)->get();
        $cat_slug['cat_slug']=$cat[0]->slug;
        $request->merge($cat_slug);
        $count = Products::where('subcategory_id', $subcategory_id)->count();
        if($name = $request->input('name')){
            $slug= Str::slug($name);
            $pro_count =  Products::where('subcategory_id',$subcategory_id)->where('slug',$slug)->count();
            if($pro_count>0){
                return redirect()->back()->withErrors('This Name already exist in this subcategory');
            }
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required|string|max:100',
            'multiple_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order'=> 'required|integer|min:1|max:'.$count+1,
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
            'subcategory' => 'required',
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
            Products::where('subcategory',$request->subcategory)->where('sort_order', $sort_order)->update(['sort_order'=>$count]);
        }

        $oldImages = json_decode($request->input('old_image'), true);
        $multiple_images = $oldImages ?? [];
        $mul_images = $request->file('multiple_images');
        if($mul_images){
        foreach ($mul_images as $images) {
            $imageName = uniqid() . '.' . $images->extension();
            $images->move($imagePath, $imageName);
            $multiple_images[] = $imageName;
        }
        $data['multiple_images'] =  json_encode($multiple_images);

        }

        $variant =$request->input('variant');
        if($variant[0]['name']!=null && $variant[0]['value']!=null){
            $data['variants'] =  json_encode($variant);
        }
        $data['slug'] = Str::slug($request->input('name'));
        $data += $request->except('_token','old_sort', 'is_edit','old_image','variant','multiple_images');

        if (isset($edit_id) && $edit_id != 0) {

            if (isset($sort_order) && isset($old_sort) && $sort_order != $old_sort) {

                Products::where('subcategory',$request->subcategory)->where('sort_order', $sort_order)->update(['sort_order'=>$old_sort]);
            }


            $status = Products::find($edit_id)->update($data);
        } else {
            $status = Products::create($data);
        }

        if ($status) {
            return redirect()->route('products.show',['product'=>$subcategory_id])->with('success', 'Your Data is successfully Created');
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
        Log::info('ds');
        $cat = SubCategory::where('id', $id)->get();
        Log::info($cat);
        $products = Product::select('product.*', 'sub_categories.title')
        ->join('sub_categories', 'sub_categories.id', '=', 'product.subcategory_id')
        ->where('product.is_deleted', 0)
        ->where('product.subcategory_id', $id)
        ->get();
        
        Log::info($products);
        $total_count = Product::where('is_deleted', 0)->where('subcategory_id', $id)->count();

        $products_count = Product::where('is_deleted', 0)->where("web_status",0)->where('subcategory_id', $id)->count();
        $products_out_of_stock = Products::where('subcategory_id', $id)
                                ->where("qty", "<=", 0)
                                ->orWhere("in_stock", "false")->where('subcategory_id', $id)
                                ->count();

        return view("admin-products.category-wise-products", compact("cat","products", "total_count", "products_count", "products_out_of_stock"));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editProduct(Request $request)
    {

        $id = $request->input('id');
        $subcategory_id = $request->input('subcategory_id');
        $cat = SubCategory::where('id',$subcategory_id)->get();
        $product = Products::where('id', $id)->get();
        $subcategory = SubCategory::where('status', 'Active')->get();
        $sort_count = Products::where('subcategory_id',$subcategory_id)->count();

        return view("admin-products.add-edit-product", compact("subcategory", "product","cat","sort_count"));
    }
    public function delete($id)
    {
        $pro = Products::where('id', $id)->get();
        $pro_count =Products::where('subcategory_id',$pro[0]->subcategory_id)->count();

        if((json_decode($pro[0]->multiple_images))){

            foreach(json_decode($pro[0]->multiple_images) as $image){
                $file_to_delete = getcwd() . '/uploads/products'.'/'.$image;
                unlink($file_to_delete);
            }
        }
        Log::info("Deleted Products: ". $pro);

        for($i = $pro[0]->sort_order; $i <= $pro_count; $i++ ){
            $update = ['sort_order'=> $i];
            DB::table('products')->where('sort_order' ,($i+1))->update($update);
        }

        $status = Products::where('product_id', $id)->delete();
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
        $subcategory_id = $request->input('subcategory_id');

        $sort_order = $request->input('sort_order');
        $old_sort = $request->input('old_sort');
        $cat = SubCategory::where('id',$subcategory_id)->get();
        $cat_slug['cat_slug']=$cat[0]->slug;
        $request->merge($cat_slug);
        $count = Products::where('subcategory_id', $subcategory_id)->count();
        $product = Products::where('id',$request->input('is_edit'))->get();

        $pro_count = Products::where('subcategory_id',$subcategory_id)->where('name',$request->input('name'))->count();
        if($product[0]->name != $request->input('name') && $pro_count>0){
            // dd('Val fail');
            return redirect()->back()->withErrors('The Product name already exist');
        }

        $validator = Validator::make($request->all(), [
            // 'name' => 'required|unique:products,name,'.$edit_id.',id',
            'description' => 'required|string|max:100',
            // 'multiple_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'sort_order'=> 'required|integer|min:1|max:'.$count+1,
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
            'subcategory' => 'required',
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
        if($mul_images){
        foreach ($mul_images as $images) {
            $imageName = uniqid() . '.' . $images->extension();
            $images->move($imagePath, $imageName);
            $multiple_images[] = $imageName;
        }
        $data['multiple_images'] =  json_encode($multiple_images);

        }

        $variant =$request->input('variant');
        if($variant[0]['name']!=null && $variant[0]['value']!=null){
            $data['variants'] =  json_encode($variant);
        }
        // dd($cat[0]->id);
        $data += $request->except('_token','old_sort', 'is_edit','old_image','variant','multiple_images');
        // dd($data);

            if (isset($sort_order) && isset($old_sort) && $sort_order != $old_sort) {

                Products::where('subcategory',$request->subcategory)->where('sort_order', $sort_order)->update(['sort_order'=>$old_sort]);
            }

        $status = Products::find($edit_id)->update($data);

        if ($status) {

            return redirect()->route('products.show',['product'=>$subcategory_id])->with('success', 'Your Data is successfully Changed');
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
