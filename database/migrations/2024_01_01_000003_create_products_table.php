<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('restrict');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('storage_capacity', 20);
            $table->string('color', 50);
            $table->string('imei', 20)->nullable();
            $table->enum('condition_rating', ['Like New', 'Excellent', 'Good', 'Fair', 'Poor']);
            $table->integer('battery_health')->nullable();
            $table->enum('box_type', ['OEM', 'Original', 'None']);
            $table->enum('phone_type', ['Inter', 'iBox', 'others']);
            $table->boolean('has_been_repaired')->default(false);
            $table->text('repair_history')->nullable();
            $table->text('physical_condition')->nullable();
            $table->text('functional_issues')->nullable();
            $table->decimal('price', 12, 2);
            $table->boolean('is_negotiable')->default(true);
            $table->integer('stock_quantity')->default(1);
            $table->enum('status', ['available', 'sold', 'reserved', 'draft'])->default('available');
            $table->boolean('accept_cod')->default(true);
            $table->boolean('accept_online_payment')->default(true);
            $table->string('slug')->unique()->nullable();
            $table->integer('views_count')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();

            // Indexes
            $table->index(['status', 'created_at']);
            $table->index(['price', 'status']);
            $table->index(['seller_id', 'status']);
            $table->index(['category_id', 'status']);
            $table->index('slug');
            $table->index('is_featured');
            $table->index(['condition_rating', 'status']);
            $table->index('views_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
