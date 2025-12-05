<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StockType;
use App\Models\StockTypeOption;
use Illuminate\Http\Request;

class AdminStockTypeController extends Controller
{
    public function index()
    {
        $stockTypes = StockType::withCount('options', 'products')->orderBy('sort_order')->get();
        return view('admin.stock-types.index', compact('stockTypes'));
    }

    public function create()
    {
        return view('admin.stock-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_type' => 'required|in:grid,dropdown,color-swatch,none',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['is_active'] = true;

        StockType::create($validated);

        return redirect()->route('admin.stock-types.index')
            ->with('success', 'Stock type created successfully.');
    }

    public function show(StockType $stockType)
    {
        $stockType->load('options');
        return view('admin.stock-types.show', compact('stockType'));
    }

    public function edit(StockType $stockType)
    {
        return view('admin.stock-types.edit', compact('stockType'));
    }

    public function update(Request $request, StockType $stockType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'display_type' => 'required|in:grid,dropdown,color-swatch,none',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $stockType->update($validated);

        return redirect()->route('admin.stock-types.index')
            ->with('success', 'Stock type updated successfully.');
    }

    public function destroy(StockType $stockType)
    {
        // Check if stock type is being used by products
        if ($stockType->products()->count() > 0) {
            return redirect()->route('admin.stock-types.index')
                ->with('error', 'Cannot delete stock type that is being used by products.');
        }

        $stockType->delete();

        return redirect()->route('admin.stock-types.index')
            ->with('success', 'Stock type deleted successfully.');
    }

    // Add option to existing stock type
    public function addOption(Request $request, StockType $stockType)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['stock_type_id'] = $stockType->id;
        $validated['sort_order'] = $validated['sort_order'] ?? $stockType->options()->count();
        $validated['is_active'] = true;

        StockTypeOption::create($validated);

        return redirect()->route('admin.stock-types.show', $stockType)
            ->with('success', 'Option added successfully.');
    }

    // Update option
    public function updateOption(Request $request, StockTypeOption $option)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $option->update($validated);

        return redirect()->route('admin.stock-types.show', $option->stock_type_id)
            ->with('success', 'Option updated successfully.');
    }

    // Delete option
    public function deleteOption(StockTypeOption $option)
    {
        $stockTypeId = $option->stock_type_id;
        
        // Check if option is being used in product stock
        if ($option->productStock()->count() > 0) {
            return redirect()->route('admin.stock-types.show', $stockTypeId)
                ->with('error', 'Cannot delete option that has stock assigned to products.');
        }

        $option->delete();

        return redirect()->route('admin.stock-types.show', $stockTypeId)
            ->with('success', 'Option deleted successfully.');
    }

    // AJAX endpoint to get options for a stock type
    public function getOptions(StockType $stockType)
    {
        return response()->json([
            'options' => $stockType->activeOptions()->get(['id', 'label', 'value']),
            'display_type' => $stockType->display_type,
        ]);
    }
}