<?php
namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\SubCategory;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class subcategoryController extends Controller
{
  
    public function view($category_slug)
    {
        $attributes = Attribute::orderBy('display_order', 'asc')->get();
        return view('subCategory',compact('category_slug','attributes'));
    }

    // Get subcategories in JSON format with count
    public function index($category_slug)
    {
    Log::info($category_slug);
        $subcategories = SubCategory::orderBy('display_order')->where('category_slug',$category_slug)->get();
        $subcategoryCount = $subcategories->count(); 
        
        return response()->json([
            'subcategories' => $subcategories,
            'count' => $subcategoryCount, // Add count to the response
        ]);
    }

    // Store a new subcategory
    public function store(Request $request)
    {
     
          // Validation rules
          $validator = Validator::make($request->all(), [
              'title' => [
                  'required',
                  'string',
                  'max:255',
                  Rule::unique('sub_categories'), 
                ],
                'category_slug' => 'nullable|string',
               'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:2048',
                'description' => 'nullable|string',
                'selected_attributes' => 'nullable|array',
                'display_order' => 'required|integer|min:1',
                'status' => 'required|in:active,inactive',
            ]);
            
         
            Log::info($validator->errors());
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ]);
        }
        // Adjust display order for the new subcategory
        $displayOrder = $request->input('display_order');
        $this->adjustDisplayOrderForNewsubcategory($displayOrder,$request->input('category_slug'));
        $image = $request->file('image');
        $destinationPath = public_path('uploads/subcategory');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move($destinationPath, $imageName);
        $category_id = Category::where('category_slug', $request->input('category_slug'))->pluck('id')->first();
        $subcategory = SubCategory::create([
            'title' => $request->input('title'),
            'image' => 'uploads/subcategory/' . $imageName, 
            'category_id' => $category_id,
            'category_slug' => $request->input('category_slug'),
            'description' => $request->input('description'),
            'selected_attributes' => $request->input('selected_attributes'),
            'status' => $request->input('status'),
            'display_order' => $displayOrder,
        ]);
        return response()->json([
            'success' => true,
            'subcategory' => $subcategory,
        ]);
    }

    private function adjustDisplayOrderForNewsubcategory($newDisplayOrder,$category_slug)
    {
        SubCategory::where('category_slug',$category_slug)->where('display_order', '>=', $newDisplayOrder)
            ->increment('display_order');
    }

    public function update(Request $request, $id)
    {
           // Log::info($category_slug);
    
        $subcategory = SubCategory::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:255',
                 Rule::unique('sub_categories')->ignore($id), 
            ],  
            'description' => 'nullable|string',
            // 'selected_attributes' => 'nullable|array',
         'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:2048',
            'display_order' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors(),
            ]);
        }

        // Log::info($request->all());

        
        if ($request->hasFile('image')) {
            // Delete the old image
            $oldImagePath = public_path($subcategory->image);
            if (file_exists($oldImagePath) && $subcategory->image ) {
                unlink($oldImagePath);
            }
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/subcategory'), $imageName);
            $imagepath = 'uploads/subcategory/' . $imageName;
        }
        $newDisplayOrder = $request->input('display_order');
        $oldDisplayOrder = $subcategory->display_order;
        if ($newDisplayOrder != $oldDisplayOrder) {
            $this->swapDisplayOrder($oldDisplayOrder, $newDisplayOrder, $subcategory->category_slug);
        }
        $slug = Str::slug($request->input('title'));
        // Update the subcategory details
        $subcategory->update([
            'title' => $request->input('title'),
            'image' => $imagepath ?? $subcategory->image,
            'subcategory_slug' => $slug,
            'description' => $request->input('description'),
            'selected_attributes' => $request->input('selected_attributes'),
            'status' => $request->input('status'),
            'display_order' => $newDisplayOrder,
        ]);

        return response()->json([
            'success' => true,
            'subcategory' => $subcategory,
        ]);
    }

    // Swap display order for subcategories
    private function swapDisplayOrder($oldDisplayOrder, $newDisplayOrder ,$category_slug)
    {
        $subcategoryToSwap = SubCategory::where('category_slug', $category_slug)->where('display_order', $newDisplayOrder)->first();

        if ($subcategoryToSwap) {
            // Swap the display order between the two subcategories
            $subcategoryToSwap->update([
                'display_order' => $oldDisplayOrder,
            ]);
        }
    }

    // Delete subcategory
    public function destroy($id)
    {
        $subcategory = SubCategory::findOrFail($id);
        $imagePath = public_path($subcategory->image);
        if (file_exists($imagePath) && $subcategory->image) {
            unlink($imagePath); 
        }
        // Get the display_order of the subcategory to be deleted
        $deletedsubcategoryDisplayOrder = $subcategory->display_order;
        // Delete the subcategory
        $subcategory->delete();
        // Adjust the display_order for the remaining subcategories
        SubCategory::where('display_order', '>', $deletedsubcategoryDisplayOrder)
            ->decrement('display_order');
        return response()->json([
            'success' => true,
        ]);
    }

    public function show($id)
    {
        $subcategory = Subcategory::with('products')->findOrFail($id);
    
        return view('subcategory.show', compact('subcategory'));
    }
    
}
