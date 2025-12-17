<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Usage_traking extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'max_discount',
        'min_purchase',
        'usage_limit',
        'per_user_limit',
        'times_used',
        'starts_at',
        'expires_at',
        'is_active',
        'applies_to_all',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'applies_to_all' => 'boolean',
    ];

    // Relationships
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'discount_categories');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_products');
    }

    // Check if discount is currently valid
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        // Check if started
        if ($this->starts_at && Carbon::parse($this->starts_at)->isFuture()) {
            return false;
        }

        // Check if expired
        if ($this->expires_at && Carbon::parse($this->expires_at)->isPast()) {
            return false;
        }

        // Check total usage limit
        if ($this->usage_limit && $this->times_used >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    // Check if user can use this discount
    public function canBeUsedBy($userId)
    {
        // If no per-user limit, allow usage
        if (!$this->per_user_limit) {
            return true;
        }

        // For authenticated users, check their order history
        if ($userId) {
            $userUsageCount = Order::where('user_id', $userId)
                ->where('coupon_code', $this->code)
                ->count();

            return $userUsageCount < $this->per_user_limit;
        }

        // For guest users, check session
        $usedCodes = session('used_discount_codes', []);
        $guestUsageCount = $usedCodes[$this->code] ?? 0;

        return $guestUsageCount < $this->per_user_limit;
    }

    // Check if discount applies to cart items
    public function appliesTo($cart)
    {
        // If applies to all products, return true
        if ($this->applies_to_all) {
            return true;
        }

        // Get discount's categories and products
        $discountCategoryIds = $this->categories()->pluck('categories.id')->toArray();
        $discountProductIds = $this->products()->pluck('products.id')->toArray();

        // If no specific items are set, it applies to all
        if (empty($discountCategoryIds) && empty($discountProductIds)) {
            return true;
        }

        // Check if any cart item matches
        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            
            if (!$product) {
                continue;
            }

            // Check if product is in discount's products
            if (in_array($product->id, $discountProductIds)) {
                return true;
            }

            // Check if product's category is in discount's categories
            if (in_array($product->category_id, $discountCategoryIds)) {
                return true;
            }
        }

        return false;
    }

    // Calculate discount amount
    public function calculateDiscount($subtotal)
    {
        // Check minimum purchase
        if ($this->min_purchase && $subtotal < $this->min_purchase) {
            return 0;
        }

        $discountAmount = 0;

        if ($this->type === 'percentage') {
            $discountAmount = ($subtotal * $this->value) / 100;
            
            // Apply max discount cap
            if ($this->max_discount && $discountAmount > $this->max_discount) {
                $discountAmount = $this->max_discount;
            }
        } else {
            // Fixed amount
            $discountAmount = $this->value;
        }

        // Don't let discount exceed subtotal
        if ($discountAmount > $subtotal) {
            $discountAmount = $subtotal;
        }

        return round($discountAmount, 2);
    }

    // Scope: Active discounts
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope: Valid discounts (active, not expired, under usage limit)
    public function scopeValid($query)
    {
        return $query->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('starts_at')
                  ->orWhere('starts_at', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('expires_at')
                  ->orWhere('expires_at', '>=', now());
            })
            ->where(function($q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('times_used < usage_limit');
            });
    }
}