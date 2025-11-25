<?php



namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $parentcategory = SubCategory::where('subcategory_slug', $request->input('subcategory_slug'))->firstOrFail();
        $products = Product::where('subcategory_id', $parentcategory->id)
            ->orderBy('display_order', 'asc')
            ->get();

        $productsCount = $products->count();
        return view('products.index', compact('products', 'parentcategory', 'productsCount'));
    }

    public function create(Request $request)
    {
        $parentcategory = SubCategory::find($request->input('parentcategory'));
        $productsCount = Product::where('subcategory_id', $parentcategory->id)->count();
        $units = Units::where('product_id', 1)->get(); // Optional placeholder for UI
        return view('products.create', compact('parentcategory', 'productsCount', 'units'));
    }

    public function store(Request $request)
    {
        // ✅ Validate product and unit data
        $validated = $request->validate([
            // Product fields
            'name' => 'required|unique:products,name',
            'brand' => 'nullable',
            'quantity' => 'required|integer',
            'primary_image' => 'nullable|image',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'warranty' => 'nullable',
            'return_policy' => 'nullable',
            'delivery_mode' => 'nullable',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer',

            // Hidden fields from form
            'category_id' => 'required|integer',
            'category_slug' => 'required|string',
            'subcategory_id' => 'nullable|integer',
            'subcategory_slug' => 'nullable|string',

            // Unit fields
            'color' => 'required|string',
            'size' => 'required|string',
            'material' => 'required|string',
            'weight' => 'required|string',
            'unit_count' => 'required|integer',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Handle image upload
            if ($request->hasFile('primary_image')) {
                $imagePath = $request->file('primary_image')->store('products', 'public');
                $validated['primary_image'] = $imagePath;
            }

            // ✅ Create slug
            $validated['product_slug'] = Str::slug($validated['name']);

            // ✅ Create Product
            $product = Product::create([
                'name' => $validated['name'],
                'brand' => $validated['brand'],
                'quantity' => $validated['quantity'],
                'primary_image' => $validated['primary_image'] ?? null,
                'new_price' => $validated['new_price'],
                'old_price' => $validated['old_price'],
                'discount' => $validated['discount'],
                'warranty' => $validated['warranty'],
                'return_policy' => $validated['return_policy'],
                'delivery_mode' => $validated['delivery_mode'],
                'status' => $validated['status'],
                'display_order' => $validated['display_order'],
                'category_id' => $validated['category_id'],
                'category_slug' => $validated['category_slug'],
                'subcategory_id' => $validated['subcategory_id'],
                'subcategory_slug' => $validated['subcategory_slug'],
                'product_slug' => $validated['product_slug'],
            ]);

            // ✅ Store in `manage_units` table
            Units::create([
                'product_id' => $product->id,
                'color' => $validated['color'],
                'size' => $validated['size'],
                'material' => $validated['material'],
                'weight' => $validated['weight'],
                'unit_count' => $validated['unit_count'],
            ]);

            DB::commit();

            return redirect()->route('products.index')->with('success', 'Product and unit created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to create product. ' . $e->getMessage()]);
        }
    }
}
