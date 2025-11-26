<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {

            // Add ONLY missing columns
            if (!Schema::hasColumn('orders', 'subtotal')) {
                $table->integer('subtotal')->default(0);
            }

            if (!Schema::hasColumn('orders', 'total')) {
                $table->integer('total')->default(0);
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['subtotal', 'total']);
        });
    }
};
