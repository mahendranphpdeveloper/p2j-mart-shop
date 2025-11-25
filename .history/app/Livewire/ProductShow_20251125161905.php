<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\ProductImage; // Assuming ProductImage model exists
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProductShow extends Component
{
    use WithFileUploads;

    public $slug;
    public $product;
    public $relatedProducts;
    public $quantity = 1;
    public $customText = '';
    public $customImage = null;
    public $showPreview = false;
    public $mainImage = '';  // Public property for reactive image URL
    public $attributeOptions = []; // Full original options per attribute slug
    public $availableOptionIds = []; // Currently available option IDs per attribute slug
    public $selectedAttributes = []; // Track selected option IDs per attribute (e.g., ['color' => 1, 'material' => 2])
    public $currentUnit = null; // Current selected unit based on attributes
    public $availableUnits = []; // All units for the product
    public $currentImages = []; // Current images based on selected unit

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->product = Product::with([
            'units.size',
            'units.color',
            'images',
            'metaTitle',
            'metaDescription',
            'keypoints',
            'subcategory'
        ])->where('slug', $slug)->firstOrFail();

        $this->relatedProducts = Product::where('subcategory_id', $this->product->subcategory_id)
            ->where('product_id', '!=', $this->product->product_id)
            ->take(4)
            ->get();

        // Load all units
        $this->availableUnits = $this->product->units()->where('is_deleted', 0)->get();

        // Load full original attribute options
        $this->loadFullAttributeOptions();

        // Initialize with no selections
        $this->selectedAttributes = [];

        // Set initial current unit and images (for display when no selections)
        if ($this->availableUnits->isNotEmpty()) {
            $this->currentUnit = $this->availableUnits->first();
            $this->loadCurrentImages();
        }

        // Initial available option IDs (all, since no selections)
        $this->refreshAvailableOptionIds();

        Log::info(print_r($this->product, true));
        Log::info($this->relatedProducts);
    }

    // Load full available attribute options based on subcategory selected_attributes (all distinct)
    public function loadFullAttributeOptions()
    {
        $this->attributeOptions = [];
        if (!$this->product->subcategory || empty($this->product->subcategory->selected_attributes)) {
            return;
        }

        // selected_attributes is expected as json in subcategory table
        $selectedAttributesRaw = $this->product->subcategory->selected_attributes ?? null;
        if (is_string($selectedAttributesRaw)) {
            $selectedAttributes = json_decode($selectedAttributesRaw, true) ?? [];
        } else {
            $selectedAttributes = (array) $selectedAttributesRaw;
        }

        foreach ($selectedAttributes as $attrSlug) {
            // Skip if no units
            if ($this->availableUnits->isEmpty()) {
                $this->attributeOptions[$attrSlug] = collect();
                continue;
            }

            // Get distinct m_{slug}_id from available units
            $availableIds = $this->availableUnits->pluck('m_' . $attrSlug . '_id')->filter()->unique()->values()->toArray();

            if (empty($availableIds)) {
                $this->attributeOptions[$attrSlug] = collect();
                continue;
            }

            // Build select fields
            $selectFields = [
                'm_' . $attrSlug . '_id as id',
                $attrSlug . '_name as name',
                'slug'
            ];

            // For color, add extra color_code field
            if ($attrSlug === 'color') {
                $selectFields[] = 'color_code';
            }

            // Query options from m_{slug} table: active, in available IDs, ordered
            $options = DB::table('m_' . $attrSlug)
                ->select($selectFields)
                ->whereIn('m_' . $attrSlug . '_id', $availableIds)
                ->where('web_status', 0) // 0 = active
                ->orderBy('web_order')
                ->get();

            $this->attributeOptions[$attrSlug] = $options;
        }
    }

    // Refresh currently available option IDs for each attribute based on other selections
    public function refreshAvailableOptionIds()
    {
        $this->availableOptionIds = [];
        $selected = $this->selectedAttributes;

        $attrSlugs = array_keys($this->attributeOptions);
        foreach ($attrSlugs as $slug) {
            $otherSelected = $selected;
            unset($otherSelected[$slug]); // Ignore this attribute's selection when computing its available options

            $matchingUnits = $this->availableUnits->filter(function ($unit) use ($otherSelected) {
                foreach ($otherSelected as $s => $id) {
                    $f = 'm_' . $s . '_id';
                    if (($unit->$f ?? null) != $id) {
                        return false;
                    }
                }
                return true;
            });

            $avIds = $matchingUnits->pluck('m_' . $slug . '_id')->filter()->unique()->values()->toArray();
            $this->availableOptionIds[$slug] = $avIds;
        }
    }

    // Handle attribute selection change
    public function updateAttribute($slug, $optionId)
    {
        $this->selectedAttributes[$slug] = $optionId;
        $this->filterUnits($slug);
    }

    // Filter and set current unit based on selected attributes, then load matching images
    // Handles fallback for selecting unavailable (shaded) options by prioritizing the last changed attribute
    public function filterUnits($lastChangedSlug = null)
    {
        if (empty($this->selectedAttributes)) {
            $this->currentUnit = $this->availableUnits->first();
            $this->loadCurrentImages();
            return;
        }

        $filteredUnits = $this->availableUnits->filter(function ($unit) {
            foreach ($this->selectedAttributes as $slug => $id) {
                $field = 'm_' . $slug . '_id';
                if (($unit->$field ?? null) != $id) {
                    return false;
                }
            }
            return true;
        });

        if ($filteredUnits->isNotEmpty()) {
            $this->currentUnit = $filteredUnits->first();
        } else {
            // Fallback for incompatible selection: prioritize the last changed attribute
            if ($lastChangedSlug && isset($this->selectedAttributes[$lastChangedSlug])) {
                $newId = $this->selectedAttributes[$lastChangedSlug];
                $field = 'm_' . $lastChangedSlug . '_id';

                $matchingNew = $this->availableUnits->first(function ($unit) use ($field, $newId) {
                    return ($unit->$field ?? null) == $newId;
                });

                if ($matchingNew) {
                    $this->currentUnit = $matchingNew;
                    // Update OTHER selected attributes to match this unit (keep the last changed)
                    $previousSelections = $this->selectedAttributes;
                    $attrSlugs = array_keys($this->attributeOptions);
                    foreach ($attrSlugs as $attrSlug) {
                        if ($attrSlug !== $lastChangedSlug) {
                            $idField = 'm_' . $attrSlug . '_id';
                            $this->selectedAttributes[$attrSlug] = $matchingNew->$idField ?? null;
                        }
                    }
                    // Dispatch event if selections changed
                    $selectionsChanged = $previousSelections !== $this->selectedAttributes;
                    if ($selectionsChanged) {
                        $this->dispatch('attributes-auto-matched', [
                            'unitId' => $matchingNew->product_unit_id,
                            'changedAttr' => $lastChangedSlug
                        ]);
                    }
                } else {
                    // Impossible, but fallback
                    $this->currentUnit = $this->availableUnits->first();
                }
            } else {
                // General fallback
                $this->currentUnit = $this->availableUnits->first();
                // Auto-update all selected attributes to fallback unit
                if ($this->currentUnit) {
                    $previousSelections = $this->selectedAttributes;
                    $attrSlugs = array_keys($this->attributeOptions);
                    foreach ($attrSlugs as $attrSlug) {
                        $idField = 'm_' . $attrSlug . '_id';
                        $this->selectedAttributes[$attrSlug] = $this->currentUnit->$idField ?? null;
                    }
                    $selectionsChanged = $previousSelections !== $this->selectedAttributes;
                    if ($selectionsChanged) {
                        $this->dispatch('attributes-auto-matched', ['unitId' => $this->currentUnit->product_unit_id]);
                    }
                }
            }
        }

        $this->loadCurrentImages();

        // Refresh available options after possible changes
        $this->refreshAvailableOptionIds();
    }

    // New: Load images matching the current unit (assuming ProductImage has product_unit_id)
    public function loadCurrentImages()
    {
        if (!$this->currentUnit) {
            $this->currentImages = collect();
            $this->mainImage = '';
            return;
        }

        // Assuming ProductImage model with relation or direct query
        // Option 1: If hasMany relation on Unit: $this->currentImages = $this->currentUnit->images;
        // Option 2: Direct query if no relation
        $this->currentImages = ProductImage::where('product_unit_id', $this->currentUnit->product_unit_id)
            ->get();

        // If no unit-specific images, fallback to product-level images
        if ($this->currentImages->isEmpty()) {
            $this->currentImages = $this->product->images;
        }

        // Set initial mainImage from first image
        $img = $this->currentImages->first();
        if ($img) {
            $mainImages = [];
            foreach (['web_image_1', 'web_image_2', 'web_image_3', 'web_image_4', 'web_image_5'] as $imgField) {
                if (!empty($img->$imgField)) {
                    $mainImages[] = asset('uploads/products/' . $img->$imgField);
                }
            }
            $this->mainImage = $mainImages[0] ?? '';
        } else {
            $this->mainImage = '';
        }
    }

    public function setMainImage($imageUrl)
    {
        $this->mainImage = $imageUrl;  // Update property (triggers re-render)
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function toggleWishlist()
    {
        $this->dispatch('wishlist-toggled', ['productId' => $this->product->product_id]);
    }

    public function addToCart()
    {
        $cartData = [
            'productId' => $this->product->product_id,
            'name' => $this->product->product_name,
            'price' => $this->getCurrentUnitPrice(),
            'quantity' => $this->quantity,
            'selectedAttributes' => $this->selectedAttributes,
            'unitId' => $this->currentUnit?->product_unit_id ?? null
        ];

        $this->dispatch('add-to-cart', $cartData);
    }

    // Get price from current unit
    public function getCurrentUnitPrice()
    {
        return $this->currentUnit?->unit_price ?? 0;
    }

    public function buyNow()
    {
        $checkoutData = [
            'product_name' => $this->product->product_name,
            'quantity' => $this->quantity,
            'custom_text' => $this->customText,
            'custom_image' => $this->customImage ? $this->customImage->temporaryUrl() : null,
            'selectedAttributes' => $this->selectedAttributes,
            'unitId' => $this->currentUnit?->product_unit_id ?? null
        ];
  Log::info
        $this->dispatch('buy-now', $checkoutData);
    }

    public function previewCustomization()
    {
        $this->validate([
            'customText' => 'nullable|string|max:255',
            'customImage' => 'nullable|image|max:5120',
        ]);

        if ($this->customImage) {
            $this->customImage = $this->customImage->store('custom-images', 'public');
        }

        $this->showPreview = true;
    }

    public function confirmCustomization()
    {
        $this->showPreview = false;
        $this->buyNow();
    }

    public function openPopup()
    {
        $this->dispatch('open-rating-popup');
    }

    public function zoomImage()
    {
        $this->dispatch('zoom-image', ['image' => $this->mainImage]);
    }

    public function render()
    {
        return view('livewire.product-show', [
            'unit' => $this->currentUnit,
            'attributeOptions' => $this->attributeOptions,
            'availableOptionIds' => $this->availableOptionIds,
            'selectedAttributes' => $this->selectedAttributes,
            'currentImages' => $this->currentImages // Pass to view
        ]);
    }
}