<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StockType;
use App\Models\StockTypeOption;

class StockTypeSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Clothing Sizes
        $clothingSizes = StockType::create([
            'name' => 'Clothing Sizes',
            'display_type' => 'grid',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        foreach ($sizes as $index => $size) {
            StockTypeOption::create([
                'stock_type_id' => $clothingSizes->id,
                'label' => $size,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }

        // 2. Shoe Sizes
        $shoeSizes = StockType::create([
            'name' => 'Shoe Sizes (EU)',
            'display_type' => 'grid',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        for ($size = 35; $size <= 45; $size++) {
            StockTypeOption::create([
                'stock_type_id' => $shoeSizes->id,
                'label' => 'EU ' . $size,
                'value' => (string) $size,
                'sort_order' => $size - 35,
                'is_active' => true,
            ]);
        }

        // 3. One Size (No variants)
        $oneSize = StockType::create([
            'name' => 'One Size',
            'display_type' => 'none',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        StockTypeOption::create([
            'stock_type_id' => $oneSize->id,
            'label' => 'One Size',
            'sort_order' => 0,
            'is_active' => true,
        ]);

        // 4. Dumbbell Weights (Example for your use case)
        $weights = StockType::create([
            'name' => 'Dumbbell Weights',
            'display_type' => 'grid',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        $weightOptions = ['1kg', '2kg', '3kg', '5kg', '10kg', '15kg', '20kg'];
        foreach ($weightOptions as $index => $weight) {
            StockTypeOption::create([
                'stock_type_id' => $weights->id,
                'label' => $weight,
                'sort_order' => $index,
                'is_active' => true,
            ]);
        }
    }
}