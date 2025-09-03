<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'order_number',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'seller_id',
        'product_id',
        'quantity',
        'unit_price',
        'total_amount',
        'payment_method',
        'payment_status',
        'midtrans_transaction_id',
        'midtrans_order_id',
        'midtrans_payment_type',
        'shipping_address',
        'shipping_phone',
        'shipping_notes',
        'order_status',
        'whatsapp_contact',
        'ordered_at',
        'confirmed_at',
        'shipped_at',
        'delivered_at',
        'completed_at',
    ];

    /**
     * Mendapatkan atribut yang harus di-cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'total_amount' => 'decimal:2',
            'ordered_at' => 'datetime',
            'confirmed_at' => 'datetime',
            'shipped_at' => 'datetime',
            'delivered_at' => 'datetime',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Relasi ke penjual (user)
     */
    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'seller_id');
    }

    /**
     * Relasi ke produk
     */
    public function product()
    {
        return $this->belongsTo('App\Models\Product', 'product_id');
    }

    /**
     * Scope untuk pesanan pending
     */
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    /**
     * Scope untuk pesanan dikonfirmasi
     */
    public function scopeConfirmed($query)
    {
        return $query->where('order_status', 'confirmed');
    }

    /**
     * Scope untuk pesanan dikirim
     */
    public function scopeShipped($query)
    {
        return $query->where('order_status', 'shipped');
    }

    /**
     * Scope untuk pesanan diterima
     */
    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }

    /**
     * Scope untuk pesanan selesai
     */
    public function scopeCompleted($query)
    {
        return $query->where('order_status', 'completed');
    }

    /**
     * Scope untuk pesanan dibatalkan
     */
    public function scopeCancelled($query)
    {
        return $query->where('order_status', 'cancelled');
    }

    /**
     * Scope untuk pembayaran COD
     */
    public function scopeCod($query)
    {
        return $query->where('payment_method', 'cod');
    }

    /**
     * Scope untuk pembayaran online
     */
    public function scopeOnlinePayment($query)
    {
        return $query->where('payment_method', 'online');
    }

    /**
     * Scope untuk pembayaran terbayar
     */
    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Scope untuk pembayaran pending
     */
    public function scopePaymentPending($query)
    {
        return $query->where('payment_status', 'pending');
    }

    /**
     * Scope untuk pembayaran gagal
     */
    public function scopePaymentFailed($query)
    {
        return $query->where('payment_status', 'failed');
    }

    /**
     * Scope untuk berdasarkan nomor pesanan
     */
    public function scopeByOrderNumber($query, $orderNumber)
    {
        return $query->where('order_number', $orderNumber);
    }

    /**
     * Scope untuk berdasarkan penjual
     */
    public function scopeBySeller($query, $sellerId)
    {
        return $query->where('seller_id', $sellerId);
    }

    /**
     * Scope untuk berdasarkan produk
     */
    public function scopeByProduct($query, $productId)
    {
        return $query->where('product_id', $productId);
    }

    /**
     * Scope untuk urutkan berdasarkan tanggal pesanan terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('ordered_at', 'desc');
    }

    /**
     * Scope untuk filter berdasarkan rentang tanggal
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('ordered_at', [$startDate, $endDate]);
    }
}
