<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'usage_count',
        'per_user_limit',
        'starts_at',
        'expires_at',
        'applies_to_all',
        'category_ids',
        'product_ids',
        'is_active',
    ];

    protected $casts = [
        'category_ids' => 'array',
        'product_ids' => 'array',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'applies_to_all' => 'boolean',
        'value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
    ];

    // Relationship with users who used this discount
    // WITHOUT timestamps in pivot table
    public function users()
    {
        return $this->belongsToMany(User::class, 'discount_user')
            ->withPivot('order_id', 'discount_amount', 'used_at', 'session_id')
            ->withoutTimestamps(); // This is the key fix
    }

    // Get categories this discount applies to
    public function categories()
    {
        return Category::whereIn('id', $this->category_ids ?? [])->get();
    }

    // Get products this discount applies to
    public function products()
    {
        return Product::whereIn('id', $this->product_ids ?? [])->get();
    }

    // Check if discount is currently valid
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    // Check if user can use this discount
    public function canBeUsedByUser($userId)
    {
        if (!$this->per_user_limit) {
            return true;
        }

        $usageCount = $this->users()
            ->where('user_id', $userId)
            ->count();

        return $usageCount < $this->per_user_limit;
    }

    // Check if discount applies to a specific product
    public function appliesToProduct($productId)
    {
        if ($this->applies_to_all) {
            return true;
        }

        // Check if product is directly included
        if (in_array($productId, $this->product_ids ?? [])) {
            return true;
        }

        // Check if product's category is included
        $product = Product::find($productId);
        if ($product && in_array($product->category_id, $this->category_ids ?? [])) {
            return true;
        }

        return false;
    }

    // Calculate discount amount for a given subtotal
    public function calculateDiscount($subtotal, $cart = [])
    {
        // Check minimum purchase requirement
        if ($this->min_purchase && $subtotal < $this->min_purchase) {
            return 0;
        }

        // Calculate applicable subtotal (only products this discount applies to)
        $applicableSubtotal = $subtotal;
        
        if (!$this->applies_to_all && !empty($cart)) {
            $applicableSubtotal = 0;
            foreach ($cart as $item) {
                if ($this->appliesToProduct($item['product_id'])) {
                    $applicableSubtotal += $item['price'] * $item['quantity'];
                }
            }
        }

        if ($applicableSubtotal == 0) {
            return 0;
        }

        // Calculate discount based on type
        $discountAmount = 0;
        
        if ($this->type === 'percentage') {
            $discountAmount = ($applicableSubtotal * $this->value) / 100;
        } else {
            $discountAmount = $this->value;
        }

        // Apply max discount cap if set
        if ($this->max_discount && $discountAmount > $this->max_discount) {
            $discountAmount = $this->max_discount;
        }

        // Discount cannot exceed the applicable subtotal
        if ($discountAmount > $applicableSubtotal) {
            $discountAmount = $applicableSubtotal;
        }

        return round($discountAmount, 2);
    }

    // Record discount usage
    public function recordUsage($userId, $orderId, $discountAmount, $sessionId = null)
    {
        $this->users()->attach($userId, [
            'order_id' => $orderId,
            'discount_amount' => $discountAmount,
            'used_at' => Carbon::now(),
            'session_id' => $sessionId,
        ]);

        $this->increment('usage_count');
    }

    // Get discount status badge HTML
    public function getStatusBadge()
    {
        if (!$this->is_active) {
            return '<span class="px-2 py-1 text-xs rounded bg-gray-500 text-white">Inactive</span>';
        }

        $now = Carbon::now();

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return '<span class="px-2 py-1 text-xs rounded bg-blue-500 text-white">Scheduled</span>';
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return '<span class="px-2 py-1 text-xs rounded bg-red-500 text-white">Expired</span>';
        }

        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) {
            return '<span class="px-2 py-1 text-xs rounded bg-orange-500 text-white">Limit Reached</span>';
        }

        return '<span class="px-2 py-1 text-xs rounded bg-green-500 text-white">Active</span>';
    }

    // Scope for active discounts
    public function scopeActive($query)
    {
        $now = Carbon::now();
        
        return $query->where('is_active', true)
            ->where(function ($q) use ($now) {
                $q->whereNull('starts_at')
                    ->orWhere('starts_at', '<=', $now);
            })
            ->where(function ($q) use ($now) {
                $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', $now);
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereRaw('usage_count < usage_limit');
            });
    }
}