<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Units;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\UnitSize;
use App\Models\Category;
use App\Models\ProductImage; 
use Illuminate\Support\Facades\Storage;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Models\ProductCustomization;
use App\Services\ShippingService;
use App\Models\Cart;
    

class ProductController extends Controller
{



    public function index(Request $request)
    {

        $parentcategory = SubCategory::where('subcategory_slug', $request->input('subcategory_slug'))->firstOrFail();

        $products = Product::where('subcategory_id', $parentcategory->id)
            ->orderBy('display_order', 'asc')
            ->get();
        $selectedAttributes = is_string($parentcategory->selected_attributes)
            ? json_decode($parentcategory->selected_attributes, true)
            : $parentcategory->selected_attributes; // If already an array, use as is

        $attributeColumns = [];

        if (!empty($selectedAttributes)) {
            foreach ($selectedAttributes as $attributeTableName) {
                Log::info($attributeTableName);
                $tableName = strtolower(str_replace(' ', '_', $attributeTableName));
                if (Schema::hasTable($tableName)){
                    $columns = Schema::getColumnListing($tableName);
                    $attributeColumns[$tableName] = $columns;
                }
            }
        }

        $productsCount = $products->count();
        return view('products.index', compact('products', 'parentcategory', 'productsCount', 'attributeColumns'));
    }

    public function create(Request $request)
    {
        

        $parentcategory = SubCategory::find($request->input('parentcategory'));
        $productsCount = Product::where('subcategory_id', $parentcategory->id)->get()->count();

        $selectedAttributes = is_string($parentcategory->selected_attributes)
            ? json_decode($parentcategory->selected_attributes, true)
            : $parentcategory->selected_attributes;

        $defaultColumns = ['id','product_id','created_at', 'updated_at']; // Default columns to exclude
        $attributeColumns = [];

        if (!empty($selectedAttributes) && is_array($selectedAttributes)) {
            foreach ($selectedAttributes as $attributeTableName) {
                $tableName = strtolower(str_replace(' ', '_', $attributeTableName));

                if (Schema::hasTable($tableName)) {
                    $columns = Schema::getColumnListing($tableName);
                    $filteredColumns = array_diff($columns, $defaultColumns);

                    $attributeColumns[$tableName] = array_values($filteredColumns); // Reset array keys
                }
            }
        }
        $units=Units::where('product_id',1)->get();        // Log::info($attributeColumns);
        return view('products.create', compact('parentcategory', 'productsCount', 'attributeColumns','units'));
    }

    public function basic_details(Request $request)
    {
        Log::info($request->all());

        $validatedData = $request->validate([
            'category_slug' => 'required',
            'category_id' => 'required',
            'subcategory_slug' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required|unique:products',
            'brand' => 'nullable',
            'warranty' => 'nullable',
            'product_info' => 'nullable',
            'return_policy' => 'nullable',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer',
        ]);

        $displayOrder = $request->input('display_order');
        $this->adjustDisplayOrderForNewsubcategory($displayOrder, $request->input('subcategory_slug'));
    
        $product = Product::create($validatedData);
  
        return redirect()->back()->with([
            'success' => 'Product created successfully.',
            'product_id' => $product->id,
        ]);
    }
    public function store(Request $request)
    {
      

        $validatedData = $request->validate([
            'category_slug' => 'required',
            'category_id' => 'required',
            'subcategory_slug' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required|unique:products',
            'brand' => 'nullable',
            'quantity' => 'required|integer',
            'primary_image' => 'nullable|image',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'discount' => 'required|numeric',
            'warranty' => 'nullable',
            'return_policy' => 'nullable',
            'delivery_mode' => 'nullable',
            'attributes_type' => 'nullable',
            'attributes_id' => 'nullable',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer',
        ]);

        // Adjust display order for the new subcategory
        $displayOrder = $request->input('display_order');
        $this->adjustDisplayOrderForNewsubcategory($displayOrder, $request->input('subcategory_slug'));
        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Rename with timestamp for uniqueness
            $destinationPath = public_path('uploads/products/' . $validatedData['subcategory_slug'] . '/');
            $file->move($destinationPath, $fileName);
            $validatedData['primary_image'] = 'uploads/products/' . $validatedData['subcategory_slug'] . '/' . $fileName;
        }
        $product = Product::create($validatedData);
        if ($request->has('attributes')) {
          
            foreach ($request->input('attributes') as $attributeType => $attributeValues) {
                $data = ['product_id' => $product->id, 'created_at' => now(), 'updated_at' => now()];
                foreach ($attributeValues as $attributeValue => $quantity) {
                    $columnName =  $attributeValue; 
                    $data[$columnName] = $quantity ?? 0; 
                }
                DB::table($attributeType)->insert($data);
            }
        }
        return redirect()->back()->with('success', 'Product created successfully.');
    }

// Full product view with related products
// Full product view with related products
public function show($id)
{
    $product = Product::with([
        'units.size',
        'units.color',
        'images',
        'metaTitle',
        'metaDescription',
        'keypoints',
        'subcategory'  // Ensure the subcategory relation is loaded
    ])->where('slug', $slug)->firstOrFail();

    // Ensure the correct column names are being used
    $relatedProducts = Product::where('subcategory_id', $product->subcategory_id)  // Ensure the column name is correct
        ->where('product_id', '!=', $product->product_id)  // Ensure you're using the correct column for primary key
        ->take(4)
        ->get();
        // Log::info(print_r($product,true));
        // Log::info($relatedProducts);

    return view('products.show', compact('product', 'relatedProducts'));
}

// Show only single product without related products
public function showOnly($slug)
{
    $product = Product::with([
        'units.size',
        'units.color',
        'images',
        'metaTitle',
        'metaDescription',
        'keypoints'
    ])->where('slug', $slug)->firstOrFail();

    // Fetch related products based on category or subcategory
    $relatedProducts = Product::with(['images', 'units'])
      ->where('product_id', '!=', $product->product_id)

        ->where('sub_category_id', $product->sub_category_id) // adjust this if using category
        ->latest()
        ->take(8)
        ->get();
  Log::info(print_r($product,true));
    return view('products.show', compact('product', 'relatedProducts'));
}



    public function edit(Product $product) 
    {
        $productsCount = Product::where('subcategory_id', $product->subcategory_id)->count();
    
        $parentcategory = SubCategory::find($product->subcategory_id);
        $selectedAttributes = is_string($parentcategory->selected_attributes)
            ? json_decode($parentcategory->selected_attributes, true)
            : $parentcategory->selected_attributes;
        
        $defaultColumns = ['id', 'product_id', 'created_at', 'updated_at']; 
        $attributeColumns = [];
        $storedAttributes = [];
    
        if (!empty($selectedAttributes) && is_array($selectedAttributes)) {
            foreach ($selectedAttributes as $attributeTableName) {
                $tableName = strtolower(str_replace(' ', '_', $attributeTableName));
                if (Schema::hasTable($tableName)) {
                    // Get column list
                    $columns = Schema::getColumnListing($tableName);
                    $filteredColumns = array_diff($columns, $defaultColumns);
                    $attributeColumns[$tableName] = array_values($filteredColumns); // Reset array keys
            
                    $storedAttributes[$tableName] = DB::table($tableName)
                        ->where('product_id', $product->id)
                        ->first(); 
                }
            }
        }
        // Log::info($attributeColumns);
        // Log::info($storedAttributes);
    
        return view('products.edit', compact('product', 'productsCount', 'attributeColumns', 'storedAttributes'));
    }
    

    public function update(Request $request, Product $product)
    {
        
        $validatedData = $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'brand' => 'nullable',
            'category_slug' => 'required',
            'category_id' => 'required',
            'subcategory_slug' => 'nullable',
            'subcategory_id' => 'nullable',
            'quantity' => 'required|integer',
            'primary_image' => 'nullable|image',
            'new_price' => 'required|numeric',
            'old_price' => 'nullable|numeric',
            'discount' => 'required|numeric',
            'warranty' => 'nullable',
            'return_policy' => 'nullable',
            'delivery_mode' => 'nullable',
            'attributes_type' => 'nullable',
            'attributes_id' => 'nullable',
            'status' => 'required|in:active,inactive',
            'display_order' => 'nullable|integer',
        ]);
        if ($request->hasFile('primary_image')) {

            $oldImagePath = public_path($product->primary_image);

            if (file_exists($oldImagePath) && $$product->primary_image) {
                unlink($oldImagePath);
            }
            $file = $request->file('primary_image');
            $fileName = time() . '_' . $file->getClientOriginalName(); // Rename with timestamp for uniqueness
            $destinationPath = public_path('uploads/products/' . $validatedData['subcategory_slug'] . '/');
            $file->move($destinationPath, $fileName);
            $validatedData['primary_image'] = 'uploads/products/' . $validatedData['subcategory_slug'] . '/' . $fileName;
        }
        $newDisplayOrder = $request->input('display_order');
        $oldDisplayOrder = $product->display_order;
        if ($newDisplayOrder != $oldDisplayOrder) {
            $this->swapDisplayOrder($oldDisplayOrder, $newDisplayOrder, $product->subcategory_slug);
        }
        $product->update($validatedData);
        if ($request->has('attributes')) {
            foreach ($request->input('attributes') as $attributeType => $attributeValues) {
                $data = ['product_id' => $product->id, 'created_at' => now(), 'updated_at' => now()];
                
                foreach ($attributeValues as $attributeValue => $quantity) {
                    $columnName =  $attributeValue; 
                    $data[$columnName] = $quantity ?? 0; 
                }
          
                DB::table($attributeType)->updateOrInsert(
                    ['product_id' => $product->id],  // Where condition
                    $data
                );
            }
        }
        // Log::info($request->input('attributes') );
        return redirect()->back()->with('success', 'Product updated successfully.');
    }


    private function swapDisplayOrder($oldDisplayOrder, $newDisplayOrder, $subcategory_slug)
    {

        $productsToSwap = Product::where('subcategory_slug', $subcategory_slug)->where('display_order', $newDisplayOrder)->first();
        if ($productsToSwap) {
            $productsToSwap->update([
                'display_order' => $oldDisplayOrder,
            ]);
        }
    }


    private function adjustDisplayOrderForNewsubcategory($newDisplayOrder, $subcategory_slug)
    {
        Product::where('subcategory_slug', $subcategory_slug)->where('display_order', '>=', $newDisplayOrder)
            ->increment('display_order');
    }


    public function destroy(Product $product)
    {
        $imagePath = public_path($product->primary_image);
        if (file_exists($imagePath) && $product->primary_image) {
            unlink($imagePath);
        }
        $product->delete();
        return redirect()->back()->with('success', 'Product deleted successfully.');
    }

    public function showBySubcategory($id)
{
    $subcategory = Subcategory::with('products')->findOrFail($id);

    return view('subcategory.show', compact('subcategory'));
}

public function getBySubcategory(Request $request, $id)
{
    $subcategory = SubCategory::findOrFail($id);
    $sizeFilter = $request->input('size');

    // Define basic sizes (XS, S, M, L, XL, 2XL, 3XL)
    $basicSizes = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL'];

    // Get all sizes from the m_size table but limit to basic sizes
    $sizes = UnitSize::whereIn('size_name', $basicSizes)
        ->where('is_deleted', 0)
        ->where('web_status', 0)
        ->get();

    // Sizes currently used in this subcategory
    $usedSizeIds = Product::where('subcategory_id', $id)
        ->where('is_deleted', 0)
        ->where('web_status', 0)
        ->with(['units' => function ($q) {
            $q->where('is_deleted', 0);
        }])
        ->get()
        ->pluck('units')
        ->flatten()
        ->pluck('m_size_id')
        ->unique()
        ->filter()
        ->toArray();

    $usedSizes = Unitsize::whereIn('m_size_id', $usedSizeIds)
        ->pluck('size_name')
        ->toArray();

    // Fetch products (with size filter if applied)
    $products = Product::with(['units.size', 'images'])
        ->where('subcategory_id', $id)
        ->where('is_deleted', 0)
        ->where('web_status', 0)
        ->when($sizeFilter, function ($query) use ($sizeFilter) {
            $query->whereHas('units.size', function ($q) use ($sizeFilter) {
                $q->where('size_name', $sizeFilter);
            });
        })
        ->get();

    return view('products.subcategory_products', compact('subcategory', 'products', 'sizes', 'usedSizes'));
}


public function showCustomizedProducts()
{
    // Fetch only products with customize = 1
    $products = Product::where('customize', 1)
                ->with(['images', 'units'])
                ->get();

    $sizes = Unitsize::all(); // For size options if needed

    return view('view.customized', compact('products', 'sizes'));
}

public function showProductDetail($id)
{
    $sizes = Unitsize::all();
    return view('products.subcategory_products', compact('sizes'));
}

public function showSubcategoryProducts($subcategoryId)
{
    $subcategory = Subcategory::findOrFail($subcategoryId);

    $products = Product::where('subcategory_id', $subcategoryId)
                ->with(['images', 'units'])
                ->get();

    $sizes = Unitsize::all();
    return view('products.subcategory_products', compact('subcategory', 'products', 'sizes'));
}

public function yourFunctionName()
{
    $categories = Category::where('status', 'active')
                    ->orderBy('display_order', 'asc')
                    ->get();

    return view('products.subcategory_products', compact('categories'));
}

public function gift() 
{
    $giftCategory = Category::where('title', 'Gift Items')->first();

    if (!$giftCategory) {
        return view('view.index', ['giftProducts' => collect()]);
    }

    $giftProducts = Product::with('images')
        ->whereHas('subcategory', function ($q) use ($giftCategory) {
            $q->where('category_id', $giftCategory->id);
        })
        ->where('status', 'active')
        ->latest()
        ->take(10)
        ->get();

    // Log the gift products data to the Laravel log file
    \Log::info($giftProducts);

    return view('view.index', compact('giftProducts'));
}

public function storeProductImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048', // Adjust rules as needed
    ]);

    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imagePath = $image->store('uploads/products', 'public'); // Storing the image

        // Save image data to the database
        ProductImage::create([
            'product_id' => $request->product_id,
            'image_path' => $imagePath,
        ]);
    }

    return response()->json(['success' => true, 'message' => 'Image uploaded successfully']);
}
public function deleteProductImage(Request $request)
{
    $image = ProductImage::find($request->imageunit);
    if ($image) {
        Storage::disk('public')->delete($image->image_path); // Delete file from the server
        $image->delete(); // Delete record from the database
    }

    return response()->json(['success' => true]);
}


public function fetchGiftItemsBySubcategory($subcategory_slug)
{
    $subcategory = SubCategory::where('subcategory_slug', $subcategory_slug)->firstOrFail();

    $products = Product::where('sub_category', $subcategory->id)->get();

    foreach ($products as $product) {
        $product->images = ProductImage::where('product_id', $product->id)->first();
    }

    return view('view.index', compact('products', 'subcategory'));
}
public function fetchProductDetails($slug)
{
    $product = Product::with([
        'images',
        'units.size',
        'units.color',
        'metaTitle',
        'metaDescription',
        'keypoints'
    ])->where('slug', $slug)->first();

    $unit = $product->units->first();

    return view('products.show', compact('product', 'unit'))->render();
}

public function initiateCheckout(Request $request)
{
    \Log::info('InitiateCheckout started', ['request_data' => $request->all()]);

    try {
        $validated = $request->validate([
            'product_name' => 'required|string|exists:product,product_name',
            'quantity' => 'required|integer|min:1',
            'custom_text' => 'nullable|string',
            'custom_image' => 'nullable|image|max:5120', // 5MB
        ]);
        \Log::debug('Validation passed', $validated);

        $product = Product::where('product_name', $validated['product_name'])->first();
        if (!$product) {
            \Log::error('Product not found', ['product_name' => $validated['product_name']]);
            return redirect()->back()->with('error', 'Product not found');
        }

        $sessionId = uniqid('buynow_', true);
        $sessionData = [
            'product_name' => $product->product_name,
            'product_id' => $product->product_id,
            'quantity' => $validated['quantity'],
            'created_at' => now(),
            'expires_at' => now()->addMinutes(30)
        ];
        $request->session()->put('buy_now_product.' . $sessionId, $sessionData);

        // Handle customization
       // Handle customization
$customImagePath = null;
if ($request->hasFile('custom_image')) {
    try {
        // Store in the public disk (which uses storage/app/public)
        $customImagePath = $request->file('custom_image')
            ->store('custom_images/' . date('Y/m/d'), 'public');
        
        \Log::info('Custom image stored', ['path' => $customImagePath]);
    } catch (\Exception $e) {
        \Log::error('Image upload failed', [
            'error' => $e->getMessage(),
            'product_id' => $product->product_id
        ]);
        return redirect()->back()
            ->with('error', 'Failed to upload custom image. Please try again.');
    }
}

        $customization = ProductCustomization::create([
            'product_id' => $product->product_id,
            'user_id' => auth()->check() ? auth()->id() : null,
            'custom_text' => $validated['custom_text'] ?? null,
            'custom_image' => $customImagePath,
            'session_id' => $sessionId,
        ]);
        \Log::info('Customization stored', ['customization' => $customization->toArray()]);

        if (auth()->check()) {
            return redirect()->route('products.checkout', ['session_id' => $sessionId]);
        }

        $request->session()->put('buy_now_session_id', $sessionId);
        return redirect()->route('login.user');

    } catch (\Exception $e) {
        \Log::error('InitiateCheckout failed', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);
        return redirect()->back()->with('error', 'Failed to initiate checkout. Please try again.');
    }
}

public function uploadCustomImage(Request $request)
{
    $request->validate([
        'custom_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120'
    ]);

    try {
        $path = $request->file('custom_image')->store('customizations', 'public');
        
        return response()->json([
            'success' => true,
            'path' => $path
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage()
        ], 500);
    }
}


protected $shippingService;

public function __construct(ShippingService $shippingService)
{
    $this->shippingService = $shippingService;
}

public function showCheckout(Request $request, $sessionId)
{
    Log::info('showCheckout initiated', [
        'session_id' => $sessionId,
        'user_id' => optional(auth('web')->user())->id
    ]);

    $auth = auth('web');

    $addressId = $request->input('address_id') ?? session('selected_address_id');
    Log::info('Resolved Address ID', ['address_id' => $addressId]);

    $address = $addressId ? Address::find($addressId) : null;
    Log::info('Selected address', ['address' => $address]);

    $sessionKey = 'buy_now_product.' . $sessionId;
    $productData = $request->session()->get($sessionKey);
    Log::info('Buy Now product data from session', ['session_key' => $sessionKey, 'productData' => $productData]);

    $cartItems = Auth::check() ? Cart::with('product')->where('user_id', Auth::id())->get() : collect();
    Log::info('Cart items', ['count' => $cartItems->count()]);

    if (!$productData && $cartItems->isEmpty()) {
        Log::warning('No items selected for checkout');
        return redirect()->route('home')->with('error', 'No items selected for checkout');
    }

    $shippingCost = 0;

    if ($addressId) {
        if ($productData) {
            Log::info('Calculating shipping cost for Buy Now product');
            $shippingCost = $this->shippingService->calculateShippingCost(
                $productData['product_id'],
                $productData['quantity'],
                $addressId
            );
        } else {
            Log::info('Calculating shipping cost for cart items');
            $shippingCost = $this->shippingService->calculateCartShippingCost(
                $cartItems,
                $addressId
            );
        }
        Log::info('Shipping cost calculated', ['shippingCost' => $shippingCost]);
    }

    if ($productData) {
        $product = Product::find($productData['product_id']);
        Log::info('Buy Now product fetched', ['product' => $product]);

        return view('products.checkout', [
            'checkoutType' => 'buy_now',
            'product' => $product,
            'quantity' => $productData['quantity'],
            'sessionId' => $sessionId,
            'user' => $auth->user(),
            'addresses' => $auth->check() ? Address::where('user_id', $auth->id())->get() : collect(),
            'cartItems' => collect(),
            'shippingCost' => $shippingCost,
            'address_id' => $addressId,
            'selectedAddress' => $address
        ]);
    } else {
        $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
        Log::info('Cart subtotal calculated', ['subtotal' => $subtotal]);

        return view('products.checkout', [
            'checkoutType' => 'cart',
            'product' => null,
            'quantity' => null,
            'sessionId' => $sessionId,
            'user' => $auth->user(),
            'addresses' => $auth->check() ? Address::where('user_id', $auth->id())->get() : collect(),
            'cartItems' => $cartItems,
            'shippingCost' => $shippingCost,
            'subtotal' => $subtotal,
            'address_id' => $addressId,
            'selectedAddress' => $address
        ]);
    }
}


public function saveCustomization(Request $request, Product $product)
{
    Log::info('Starting saveCustomization method.');

    try {
        Log::info('Validating request...');
        $request->validate([
            'custom_text' => 'nullable|string|max:500',
            'custom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120'
        ]);
        Log::info('Validation passed.');

        $customizationData = [
            'product_id' => $product->product_id,
            'custom_text' => $request->input('custom_text'),
            'session_id' => session()->getId()
        ];
        Log::info('Base customization data:', $customizationData);

        if (auth()->check()) {
            $customizationData['user_id'] = auth()->id();
            Log::info('User is authenticated. User ID: ' . auth()->id());
        } else {
            Log::info('User not authenticated.');
        }

        if ($request->hasFile('custom_image')) {
            Log::info('Custom image uploaded. Processing...');
            $imagePath = $request->file('custom_image')->store('customizations', 'public');
            $customizationData['custom_image'] = $imagePath;
            Log::info('Image stored at: ' . $imagePath);
        } else {
            Log::info('No image uploaded.');
        }

        Log::info('Saving customization with data:', $customizationData);

        $customization = ProductCustomization::updateOrCreate(
            [
                'product_id' => $product->product_id,
                'session_id' => session()->getId()
            ],
            $customizationData
        );

        Log::info('Customization saved successfully. ID: ' . $customization->id);

        return response()->json([
            'success' => true,
            'customization_id' => $customization->id,
            'message' => 'Customization saved successfully'
        ]);

    } catch (\Exception $e) {
        Log::error('Error in saveCustomization: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'An error occurred while saving customization.'
        ], 500);
    }
}

}
