<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    // Display all categories ordered by display_order
    public function view()
    {
        return view('Category');
    }

    // Get categories in JSON format with count
    public function index()
    {
    
        $categories = Category::orderBy('display_order')->get();
        $categoryCount = $categories->count(); // Count the number of categories

        return response()->json([
            'categories' => $categories,
            'count' => $categoryCount, // Add count to the response
        ]);
    }

    // Store a new category
    public function store(Request $request)
    {
        // Log::info($request->all());
        
        // Validation rules
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories'), 
            ],
            // 'category_slug' => 'required|string|max:255|unique:categories,category_slug',    
          'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:2048',
            'description' => 'nullable|string',
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
    
           // Get the uploaded image
           $image = $request->file('image');
           $destinationPath = public_path('uploads/category');
           $imageName = time() . '_' . $image->getClientOriginalName();
           $image->move($destinationPath, $imageName);

        // Adjust display order for the new category
        $displayOrder = $request->input('display_order');
        $this->adjustDisplayOrderForNewCategory($displayOrder);
        // $slug = Str::slug($request->input('title'));
        // Create the new category
        $category = Category::create([
            'title' => $request->input('title'),
            'image' => 'uploads/category/' . $imageName, 
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'display_order' => $displayOrder,
        ]);
        return response()->json([
            'success' => true,
            'category' => $category,
        ]);
    }

    // Adjust display order for new category
    private function adjustDisplayOrderForNewCategory($newDisplayOrder)
    {
        Category::where('display_order', '>=', $newDisplayOrder)
            ->increment('display_order');
    }


    public function getCategoryTitles()
{
    $titles = Category::pluck('title'); // returns ["Fridge", "Monitor", "Phone"]
    return response()->json($titles);
}

    // Update an existing category
    public function update(Request $request, $id)
    {
        Log::info($request->all());
        $category = Category::findOrFail($id);
        // Validation rules
        $validator = Validator::make($request->all(), [
            'title' => [
                'required',
                'string',
                'max:255',
                // Ensure the title is unique, but allow the current project to keep its existing title
                Rule::unique('categories')->ignore($id), // Exclude the current project's title from the uniqueness check
            ],
           'image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,avif,svg|max:2048',
            'description' => 'nullable|string',
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

        $newDisplayOrder = $request->input('display_order');
        $oldDisplayOrder = $category->display_order;


        if ($request->hasFile('image')) {
            // Delete the old image
            $oldImagePath = public_path($category->image);
              
            if (file_exists($oldImagePath) && $category->image ) {
                unlink($oldImagePath);
            }

            // Get the new uploaded image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/category'), $imageName);
            $imagepath = 'uploads/category/' . $imageName;
        }
        // If the display order has changed, adjust the order
        if ($newDisplayOrder != $oldDisplayOrder) {
            $this->swapDisplayOrder($oldDisplayOrder, $newDisplayOrder);
        }
        $slug = Str::slug($request->input('title'));
        // Update the category details
        $category->update([
            'title' => $request->input('title'),
            'image' => isset($imagepath) ? $imagepath : $category->image,
            'category_slug' => $slug,
            'description' => $request->input('description'),
            'status' => $request->input('status'),
            'display_order' => $newDisplayOrder,
        ]);

        return response()->json([
            'success' => true,
            'category' => $category,
        ]);
    }

    // Swap display order for categories
    private function swapDisplayOrder($oldDisplayOrder, $newDisplayOrder)
    {
        $categoryToSwap = Category::where('display_order', $newDisplayOrder)->first();

        if ($categoryToSwap) {
            // Swap the display order between the two categories
            $categoryToSwap->update([
                'display_order' => $oldDisplayOrder,
            ]);
        }
    }

    // Delete category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        $imagePath = public_path($category->image);
        if (file_exists($imagePath) && $category->image) {
            unlink($imagePath); // Delete the image
        }

        // Get the display_order of the category to be deleted
        $deletedCategoryDisplayOrder = $category->display_order;

        // Delete the category
        $category->delete();

        // Adjust the display_order for the remaining categories
        Category::where('display_order', '>', $deletedCategoryDisplayOrder)
            ->decrement('display_order');

        return response()->json([
            'success' => true,
        ]);
    }

  public function show($id)
{
    // Fetch the specific category with its products
    $category = Category::with('products')
        ->where('status', 'active')
        ->findOrFail($id);

    // Fetch all active categories for the sidebar
    $categories = Category::withCount('products')
        ->where('status', 'active')
        ->orderBy('display_order', 'asc')
        ->get();

    // Get products for the category
    $products = $category->products()->get();

    $userId = Auth::id();
    $sessionId = session()->getId();

    $wishlistproductunitItems = [];

    if ($userId || $sessionId) {
        $wishlistproductunitItems = \App\Models\Wishlist::where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })
            ->pluck('product_unit_id')
            ->toArray();
    }
    // Pass the category, products, and categories to the view
    return view('products.category_products', compact('category', 'products', 'categories','wishlistproductunitItems'));
}
}
