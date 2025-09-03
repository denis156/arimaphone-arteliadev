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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->string('buyer_name');
            $table->string('buyer_email')->nullable();
            $table->string('buyer_phone', 20);
            $table->foreignId('seller_id')->constrained('users')->onDelete('restrict');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict');
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 12, 2);
            $table->decimal('total_amount', 12, 2);
            $table->enum('payment_method', ['cod', 'online']);
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending');
            $table->string('midtrans_transaction_id')->nullable();
            $table->string('midtrans_order_id')->nullable();
            $table->string('midtrans_payment_type')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_phone', 20)->nullable();
            $table->text('shipping_notes')->nullable();
            $table->enum('order_status', ['pending', 'confirmed', 'shipped', 'delivered', 'completed', 'cancelled'])->default('pending');
            $table->string('whatsapp_contact')->nullable();
            $table->timestamp('ordered_at');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('order_number');
            $table->index(['order_status', 'created_at']);
            $table->index(['payment_status', 'payment_method']);
            $table->index(['seller_id', 'order_status']);
            $table->index(['product_id', 'order_status']);
            $table->index('midtrans_transaction_id');
            $table->index('ordered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
