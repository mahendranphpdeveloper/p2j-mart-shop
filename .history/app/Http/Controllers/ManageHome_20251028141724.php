<?php

namespace App\Http\Controllers;

use App\Models\Contactus;
use App\Models\HeaderFooter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ManageHome extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
         $admin = Auth::guard('admin')->user();
  

        $sliders = Slider::orderBy('updated_at', 'desc')
            ->orderBy('sort_order')
            ->take(4)
            ->get();
    
        $banners = DB::table('slider_banner')->orderBy('id', 'desc')->limit(1)->get();
        $card = DB::table('3_cards')->first();
        $categories = Category::where('status', 1)->orderBy('display_order', 'asc')->get();
    
      $productsByCategory = [];

$latestCategories = Category::where('status', 1)
    ->orderBy('updated_at', 'desc') // Get latest updated
    ->take(8) // Limit to 8
    ->get();

$firstThreeCategories = $latestCategories->take(3); // First 3 categories
$nextTwoCategories = $latestCategories->skip(3)->take(2); // Next 2 categories
$remainingCategories = $latestCategories->skip(5); // Remaining 3 categories

foreach ($firstThreeCategories as $category) {
    $subcategoryIds = DB::table('sub_categories')
        ->where('category_id', $category->id)
        ->pluck('id');

    $productsByCategory['first_three'][$category->title] = Product::with(['productImage', 'productUnit'])
        ->whereIn('subcategory_id', $subcategoryIds)
        ->where('is_deleted', 0)
        ->latest('updated_at')
        ->get();
}

foreach ($nextTwoCategories as $category) {
    $subcategoryIds = DB::table('sub_categories')
        ->where('category_id', $category->id)
        ->pluck('id');

    $productsByCategory['next_two'][$category->title] = Product::with(['productImage', 'productUnit'])
        ->whereIn('subcategory_id', $subcategoryIds)
        ->where('is_deleted', 0)
        ->latest('updated_at')
        ->get();
}

foreach ($remainingCategories as $category) {
    $subcategoryIds = DB::table('sub_categories')
        ->where('category_id', $category->id)
        ->pluck('id');

    $productsByCategory['remaining'][$category->title] = Product::with(['productImage', 'productUnit'])
        ->whereIn('subcategory_id', $subcategoryIds)
        ->where('is_deleted', 0)
        ->latest('updated_at')
        ->get();
}

$trendingProducts = Product::with('productImage')
    ->where('collection', 1)
    ->where('is_deleted', 0)
    ->latest('updated_at')
    ->take(12)
    ->get();

$featuredProducts = Product::with('productImage')
    ->where('collection', 2)
    ->where('is_deleted', 0)
    ->latest('updated_at')
    ->take(12)
    ->get();

$exclusiveProducts = Product::with('productImage')
    ->where('collection', 3)
    ->where('is_deleted', 0)
    ->latest('updated_at')
    ->take(12)
    ->get();


return view('view.index', compact(
    'sliders', 'banners', 'card', 'categories', 'productsByCategory',
    'trendingProducts', 'featuredProducts', 'exclusiveProducts'
));

}

    

    // Banner management page (if needed for admin panel)
    public function banner()
    {
        $data = DB::table('slider_banner')->get();
        return view('manage-home.slider-banner', compact('data'));
    }

    public function saveBanner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpg,png,jpeg,webp',
            'content' => 'required|string|max:100',
            'title' => 'nullable|string|max:100',
            'image2' => 'required|image|mimes:jpg,png,jpeg,webp',
            'content2' => 'required|string|max:100',
            'title2' => 'nullable|string|max:100',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    
        $imagePath = public_path('/uploads/banner');
        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }
    
        $data = [];
    
        // Upload first image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->extension();
            $image->move($imagePath, $imageName);
            $data['image'] = $imageName;
        }
    
        // Upload second image
        if ($request->hasFile('image2')) {
            $image2 = $request->file('image2');
            $imageName2 = uniqid() . '.' . $image2->extension();
            $image2->move($imagePath, $imageName2);
            $data['image2'] = $imageName2;
        }
    
        $data['content'] = $request->input('content');
        $data['title'] = $request->input('title');
        $data['content2'] = $request->input('content2');
        $data['title2'] = $request->input('title2');
        $data['created_at'] = now();
    
        $status = DB::table('slider_banner')->insert($data);
    
        if ($status) {
            return redirect()->back()->with('message', 'Banner with two images saved successfully.');
        } else {
            return redirect()->back()->withErrors('Failed to save the banner.');
        }
    }
    


    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $edit_id = $request->input('is_edit');
        $sort_order = $request->input('sort_order');
        $count = Slider::count();
        // return response()->json($request->all());
        $validator = Validator::make($request->all(), [
            // 'image'=> 'required',
            'title' => 'required',
            'content' => 'required',
            // 'sort_order' => 'required|integer|min:1|max:'.$count+1,
            // 'description'=> 'required|string|max:100',
        ]);

        if (!$edit_id) {
            $validator->sometimes('sort_order', 'required|integer|min:1|max:'.$count+1, function ($input) {
                return !$input->is_edit;
            });
            $validator->sometimes('image', 'required|image', function ($input) {
                return !$input->is_edit;
            });
        }
        if($edit_id)
        {
            $validator->sometimes('sort_order', 'required|integer|min:1|max:'.$count, function ($input) {
                return !$input->edit_id;
            });
        }

        if ($validator->fails()) {
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json([ $validator->errors()]);
        }
        $imagePath = public_path() . '/uploads/slider';

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $data = [];

        if ((!$edit_id) && $sort_order != $count) {
            Slider::where('sort_order', $sort_order)->update(['sort_order'=>$count]);
        }
        $data['sort_order'] = $sort_order;

        if ($uploadedImage = $request->file('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->extension();
            $image->move($imagePath, $imageName);
            $data['image'] = $imageName;
        }

        $data['title'] = $request->input('title');
        $data['content'] = $request->input('content');
        $data['status'] = $request->input('status');
        // $data['description'] = $request->input('description');

        if (isset($edit_id) && $edit_id != 0) {
            $old_sort = $request->input('old_sort');
            if ( $sort_order != $old_sort) {
                Slider::where('sort_order', $sort_order)->update(['sort_order'=>$old_sort]);
            }
            $data['sort_order'] = $sort_order;

            $status = Slider::find($edit_id)->update($data);
        } else {
            $status = Slider::create($data);
        }

        if ($status) {
            return response()->json(['success' => 'Slider added successfully']);
            // return redirect()->back()->with('success', 'Your Data is successfully Created');
        } else {
            return response()->json(['error' => $validator->errors()], 422);
            // return redirect()->back()->with('error', 'Failed to Create Data');
        }

    }

    public function getSlider(Request $request)
    {
        $slider = Slider::get();
        foreach ($slider as &$item) {
            $item['image'] = '<div class="avatar-wrapper"><div class="avatar avatar me-2 rounded-2 bg-label-secondary">
            <img src="' . asset('uploads/slider/' . $item['image']) . '" alt="' . $item['image'] . '" class="rounded-2"></div></div>';
            $item['action'] = '<div class="d-flex justify-content-around">
            <a href="javascript:void(0)" data-id="' . $item['id'] . '" class="edit pe-3 btn btn-info" id="edit">Edit</a>
            <a href="javascript:void(0)" data-id="' . $item['id'] . '" class="delete pe-3 btn btn-danger text-white" id="delete">Delete</a>
            </div>';
        }
        $get_count = Slider::count();

        return response()->json(['data' => $slider,'count'=>$get_count]);
    }

    public function deleteSlider(Request $request)
    {
        $id = $request->input('id');
        $slider = Slider::where('id', $id)->get();
        $count =Slider::count();

        $file_to_delete = getcwd() . '/uploads/slider'.'/'.$slider[0]->image;
                file_exists($file_to_delete)?unlink($file_to_delete):'';

        for($i = $slider[0]->sort_order; $i <= $count; $i++ ){
            $update = ['sort_order'=> $i];
             $status = Slider::where('sort_order' ,($i+1))->update($update);
        }

        $status = Slider::where('id', $id)->delete();
        if ($status) {
            return redirect()->route('admin-home.index');
        }
    }

    public function show(string $id)
    {
        return response()->json([Slider::find($id)]);
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {

        $title = $request->input('id');
        $title = $request->input('title');
        $content = $request->input('content');
        $uploadedImage = $request->file('image');
        // $description = $request->input('description');
        $status = $request->input('status');

        $validator = Validator::make($request->all(), [
            // 'image'=> 'required',
            'title' => 'required',
            'content' => 'required',
            // 'description'=> 'required|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json($validator);
            // return redirect()->back()->withErrors($validator)->withInput();
        }
        $imagePath = public_path() . '/uploads/slider';

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $data = [];
        if ($uploadedImage) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->extension();
            $image->move($imagePath, $imageName);
            $data['image'] = $imageName;
        }

        $data['title'] = $title;
        $data['content'] = $content;
        $data['status'] = $status;
        // $data['description'] = $description;

        $status = Slider::create($data);

        if ($status) {
            return response()->json(['success' => 'Slider added successfully']);
            // return redirect()->back()->with('success', 'Your Data is successfully Created');
        } else {
            return redirect()->back()->with('error', 'Failed to Create Data');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function header()
    {

        $data = HeaderFooter::all();
        return view('manage-home.header', compact('data'));
    }

    public function saveHeader(Request $request)
    {

        $validator = Validator::make($request->all(), [
            // 'image' => 'image',
            // 'title_1' => 'required',
            // 'title_2' => 'required',
            // 'footer_content' => 'required',
            // 'helpline_name' => 'required',
            // 'helpline_no' => 'required',
            // 'facebook_link' => 'required',
            // 'twitter_link' => 'required',
            // 'linkedin_link' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $imagePath = public_path() . '/uploads/logo';

        if (!file_exists($imagePath)) {
            mkdir($imagePath, 0755, true);
        }

        $data = [];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = uniqid() . '.' . $image->extension();
            $image->move($imagePath, $imageName);
            $data['image'] = $imageName;
            // $request->merge(['images' => $imageName]);
            if($old_image = $request->input('old_image'))
                {
                    $delete_file = getcwd() . '/uploads/logo'.'/'.$old_image;
                    file_exists($delete_file)?unlink($delete_file):'';
                }
        }
        $data += $request->except('_token');
        // dd($data);

        $status = HeaderFooter::UpdateOrCreate(['id' => 1], $data);

        if ($status) {
            return redirect()->back()->with('message', 'Your Data is successfully Saved');
        } else {
            return redirect()->back()->withErrors($validator)->withMessage('Failed to Save Data');
        }

    }

    

    public function contactUs()
    {

        $data = Contactus::all();
        return view('manage-home.contactus', compact('data'));
    }

    public function saveContactUS(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'address_title' => 'required',
            'address_content' => 'required',
            'contact_us_title' => 'required',
            'mobile_no' => 'required',
            'email_title' => 'required',
            'email' => 'required',
            'map_link' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if($map = $request->input('map_link')){
            $map = str_replace('width="600"','width="100%"',$map);
            $request->merge(['map_link'=>$map]);
        }
        $data = $request->except('_token');

        $status = Contactus::UpdateOrCreate(['id' => 1], $data);

        if ($status) {
            return redirect()->back()->with('message', 'Your Data is successfully Created');
        } else {
            return redirect()->back()->withErrors($validator)->withMessage('Failed to Create Data');
        }

    }
    
  public function getUnitList(Request $request)
{
    return response()->json([
        'data' => [
            [
                'size_name' => 'Small',
                'unit_price' => 100,
                'mrp_price' => 120,
                'material_name' => 'Cotton',
                'design_name' => 'Striped',
                'color_name' => 'Red',
                'color_code' => '#ff0000',
                'product_unit_id' => 1,
                'm_size_id' => 1,
                'm_material_id' => 1,
                'm_design_id' => 1,
                'm_color_id' => 1,
                'stock' => 50,
            ]
        ]
    ]);
}


  

}