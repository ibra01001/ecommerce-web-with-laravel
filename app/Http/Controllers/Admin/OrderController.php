<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $orders = Order::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search by order ID
                    $q->where('id', 'like', "%{$search}%")
                      // Search by first name
                      ->orWhere('first_name', 'like', "%{$search}%")
                      // Search by last name
                      ->orWhere('last_name', 'like', "%{$search}%")
                      // Search by phone
                      ->orWhere('phone', 'like', "%{$search}%")
                      // Search by email
                      ->orWhere('email', 'like', "%{$search}%")
                      // Search by wilaya
                      ->orWhere('wilaya', 'like', "%{$search}%")
                      // Search by full name (first + last)
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%{$search}%"])
                      ->orWhereRaw("CONCAT(last_name, ' ', first_name) LIKE ?", ["%{$search}%"]);
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends(['search' => $search]); // Keep search term in pagination links
        
        return view('admin.orders.orders', compact('orders', 'search'));
    }

    public function show(Order $order)
    {
        $order->load('orderItems');
        return view('admin.orders.show', compact('order'));
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /**
     * Update the status of an order
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,canceled'
        ]);

        $oldStatus = $order->status;
        $order->status = $request->status;
        $order->save();

        // Optional: If order is canceled, restore stock
        if ($request->status === 'pending' && $oldStatus !== 'pending') {
            $this->restoreStock($order);
        }

        return redirect()->back()
            ->with('success', "Order #{$order->id} status updated to {$request->status}.");
    }

    /**
     * Restore product stock when order is canceled
     */
    private function restoreStock(Order $order)
    {
        foreach ($order->orderItems as $item) {
            $product = $item->product;
            if ($product) {
                $sizeField = 'taille_' . strtoupper($item->taille_type);
                if (property_exists($product, $sizeField)) {
                    $product->$sizeField += $item->quantity;
                    $product->save();
                }
            }
        }
    }
}