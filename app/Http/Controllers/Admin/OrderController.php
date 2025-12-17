<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $orders = Order::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('id', 'like', "%{$search}%")
                      ->orWhere('first_name', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('wilaya', 'like', "%{$search}%")
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"]);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['search' => $search]);
        
        return view('admin.orders.orders', compact('orders', 'search'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product');
        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        // If order was confirmed, restore stock first
        if ($order->status === 'confirmed') {
            $this->restoreStock($order);
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Update the status of an order and manage stock
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,canceled'
        ]);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // Only reduce stock when moving from pending -> confirmed
        if ($oldStatus === 'pending' && $newStatus === 'confirmed') {
            $result = $this->deductStock($order);
            if (!$result['success']) {
                return redirect()->back()->with('error', $result['message']);
            }
        }

        // Restore stock if order is canceled or reverted to pending
        if ($oldStatus === 'confirmed' && ($newStatus === 'canceled' || $newStatus === 'pending')) {
            $this->restoreStock($order);
        }

        $order->status = $newStatus;
        $order->save();

        return redirect()->back()
            ->with('success', "Order #{$order->id} status updated to {$newStatus}.");
    }

    /**
     * Deduct stock safely for an order
     */
    private function deductStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if (!$product) {
                return ['success' => false, 'message' => "Product #{$item->product_id} not found."];
            }

            // Check if product uses dynamic stock (size)
            if ($item->stock_option_id) {
                $stock = ProductStock::where('product_id', $product->id)
                    ->where('stock_type_option_id', $item->stock_option_id)
                    ->first();

                if (!$stock) {
                    return ['success' => false, 'message' => "Stock option not found for {$item->name}."];
                }

                if ($stock->quantity < $item->quantity) {
                    return ['success' => false, 'message' => "Not enough stock for {$item->name} ({$stock->quantity} left)."];
                }

                $stock->quantity -= $item->quantity;
                $stock->save();
            } else {
                // Legacy or simple total_stock product
                if ($product->total_stock < $item->quantity) {
                    return ['success' => false, 'message' => "Not enough stock for {$item->name} ({$product->total_stock} left)."];
                }

                $product->total_stock -= $item->quantity;
                $product->save();
            }
        }

        return ['success' => true];
    }

    /**
     * Restore product stock when order is canceled or reverted
     */
    private function restoreStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if (!$product) continue;

            if ($item->stock_option_id) {
                $stock = ProductStock::where('product_id', $product->id)
                    ->where('stock_type_option_id', $item->stock_option_id)
                    ->first();

                if ($stock) {
                    $stock->quantity += $item->quantity;
                    $stock->save();
                }
            } else {
                $product->total_stock += $item->quantity;
                $product->save();
            }
        }
    }
}
