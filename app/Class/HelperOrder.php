<?php

declare(strict_types=1);

namespace App\Class;

use App\Models\Order;
use Illuminate\Support\Str;

class HelperOrder
{
    /**
     * Generate nomor pesanan unik
     */
    public static function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'ARN-' . date('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Format status pesanan ke bahasa Indonesia
     */
    public static function formatOrderStatus(string $status): string
    {
        $statuses = [
            'pending' => 'Menunggu Konfirmasi',
            'confirmed' => 'Dikonfirmasi',
            'shipped' => 'Dikirim',
            'delivered' => 'Diterima',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * Mendapatkan warna badge untuk status pesanan
     */
    public static function getOrderStatusBadgeColor(string $status): string
    {
        $colors = [
            'pending' => 'warning',
            'confirmed' => 'info',
            'shipped' => 'primary',
            'delivered' => 'success',
            'completed' => 'success',
            'cancelled' => 'danger'
        ];

        return $colors[$status] ?? 'secondary';
    }

    /**
     * Format status pembayaran ke bahasa Indonesia
     */
    public static function formatPaymentStatus(string $status): string
    {
        $statuses = [
            'pending' => 'Menunggu Pembayaran',
            'paid' => 'Sudah Dibayar',
            'failed' => 'Pembayaran Gagal',
            'refunded' => 'Dikembalikan'
        ];

        return $statuses[$status] ?? $status;
    }

    /**
     * Mendapatkan warna badge untuk status pembayaran
     */
    public static function getPaymentStatusBadgeColor(string $status): string
    {
        $colors = [
            'pending' => 'warning',
            'paid' => 'success',
            'failed' => 'danger',
            'refunded' => 'info'
        ];

        return $colors[$status] ?? 'secondary';
    }

    /**
     * Format metode pembayaran
     */
    public static function formatPaymentMethod(string $method): string
    {
        $methods = [
            'cod' => 'Cash on Delivery (COD)',
            'online' => 'Pembayaran Online'
        ];

        return $methods[$method] ?? $method;
    }

    /**
     * Format harga ke format Rupiah
     */
    public static function formatPrice($price): string
    {
        return 'Rp ' . number_format($price, 0, ',', '.');
    }

    /**
     * Konfirmasi pesanan
     */
    public static function confirmOrder($order): bool
    {
        try {
            $order->update([
                'order_status' => 'confirmed',
                'confirmed_at' => now()
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Kirim pesanan
     */
    public static function shipOrder($order): bool
    {
        try {
            $order->update([
                'order_status' => 'shipped',
                'shipped_at' => now()
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Tandai pesanan sebagai diterima
     */
    public static function deliverOrder($order): bool
    {
        try {
            $order->update([
                'order_status' => 'delivered',
                'delivered_at' => now()
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Selesaikan pesanan
     */
    public static function completeOrder($order): bool
    {
        try {
            $order->update([
                'order_status' => 'completed',
                'completed_at' => now()
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Batalkan pesanan
     */
    public static function cancelOrder($order): bool
    {
        try {
            $order->update([
                'order_status' => 'cancelled'
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Tandai pembayaran sebagai lunas
     */
    public static function markAsPaid($order): bool
    {
        try {
            $order->update([
                'payment_status' => 'paid'
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Tandai pembayaran sebagai gagal
     */
    public static function markPaymentFailed($order): bool
    {
        try {
            $order->update([
                'payment_status' => 'failed'
            ]);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Mengecek apakah pesanan bisa dikonfirmasi
     */
    public static function canBeConfirmed($order): bool
    {
        return $order->order_status === 'pending';
    }

    /**
     * Mengecek apakah pesanan bisa dikirim
     */
    public static function canBeShipped($order): bool
    {
        return $order->order_status === 'confirmed' &&
               ($order->payment_method === 'cod' || $order->payment_status === 'paid');
    }

    /**
     * Mengecek apakah pesanan bisa ditandai diterima
     */
    public static function canBeDelivered($order): bool
    {
        return $order->order_status === 'shipped';
    }

    /**
     * Mengecek apakah pesanan bisa diselesaikan
     */
    public static function canBeCompleted($order): bool
    {
        return $order->order_status === 'delivered';
    }

    /**
     * Mengecek apakah pesanan bisa dibatalkan
     */
    public static function canBeCancelled($order): bool
    {
        return in_array($order->order_status, ['pending', 'confirmed']);
    }

    /**
     * Mendapatkan timeline status pesanan
     */
    public static function getOrderTimeline($order): array
    {
        $timeline = [
            [
                'status' => 'pending',
                'label' => 'Pesanan Dibuat',
                'date' => $order->ordered_at,
                'completed' => true
            ]
        ];

        if ($order->confirmed_at) {
            $timeline[] = [
                'status' => 'confirmed',
                'label' => 'Pesanan Dikonfirmasi',
                'date' => $order->confirmed_at,
                'completed' => true
            ];
        }

        if ($order->shipped_at) {
            $timeline[] = [
                'status' => 'shipped',
                'label' => 'Pesanan Dikirim',
                'date' => $order->shipped_at,
                'completed' => true
            ];
        }

        if ($order->delivered_at) {
            $timeline[] = [
                'status' => 'delivered',
                'label' => 'Pesanan Diterima',
                'date' => $order->delivered_at,
                'completed' => true
            ];
        }

        if ($order->completed_at) {
            $timeline[] = [
                'status' => 'completed',
                'label' => 'Pesanan Selesai',
                'date' => $order->completed_at,
                'completed' => true
            ];
        }

        return $timeline;
    }

    /**
     * Generate pesan WhatsApp untuk pesanan
     */
    public static function generateWhatsAppMessage($order): string
    {
        $message = "🛒 *Pesanan Baru - {$order->order_number}*\n\n";
        $message .= "👤 Pembeli: {$order->buyer_name}\n";
        $message .= "📱 Phone: {$order->buyer_phone}\n";
        if ($order->buyer_email) {
            $message .= "📧 Email: {$order->buyer_email}\n";
        }
        $message .= "\n📦 *Detail Produk:*\n";
        $message .= "• {$order->product->title}\n";
        $message .= "• Qty: {$order->quantity}\n";
        $message .= "• Harga: " . self::formatPrice($order->unit_price) . "\n";
        $message .= "• Total: " . self::formatPrice($order->total_amount) . "\n";
        $message .= "\n💳 Metode Bayar: " . self::formatPaymentMethod($order->payment_method) . "\n";

        if ($order->shipping_address) {
            $message .= "\n📍 Alamat Pengiriman:\n{$order->shipping_address}\n";
        }

        if ($order->shipping_notes) {
            $message .= "\n📝 Catatan: {$order->shipping_notes}\n";
        }

        return urlencode($message);
    }

    /**
     * Mendapatkan statistik pesanan
     */
    public static function getOrderStatistics(): array
    {
        return [
            'total_orders' => Order::count(),
            'pending_orders' => Order::pending()->count(),
            'confirmed_orders' => Order::confirmed()->count(),
            'shipped_orders' => Order::shipped()->count(),
            'delivered_orders' => Order::delivered()->count(),
            'completed_orders' => Order::completed()->count(),
            'cancelled_orders' => Order::cancelled()->count(),
            'total_revenue' => Order::completed()->sum('total_amount'),
            'pending_revenue' => Order::whereIn('order_status', ['pending', 'confirmed', 'shipped', 'delivered'])->sum('total_amount'),
        ];
    }

    /**
     * Mendapatkan pesanan terbaru
     */
    public static function getRecentOrders(int $limit = 10)
    {
        return Order::with(['product', 'seller'])
                   ->latest()
                   ->limit($limit)
                   ->get();
    }

    /**
     * Cari pesanan berdasarkan keyword
     */
    public static function searchOrders(string $keyword)
    {
        return Order::with(['product', 'seller'])
                   ->where(function($query) use ($keyword) {
                       $query->where('order_number', 'like', "%{$keyword}%")
                             ->orWhere('buyer_name', 'like', "%{$keyword}%")
                             ->orWhere('buyer_phone', 'like', "%{$keyword}%")
                             ->orWhere('buyer_email', 'like', "%{$keyword}%");
                   })
                   ->latest()
                   ->get();
    }

    /**
     * Generate laporan penjualan
     */
    public static function generateSalesReport($startDate, $endDate): array
    {
        $orders = Order::completed()
                      ->whereBetween('completed_at', [$startDate, $endDate])
                      ->with(['product', 'seller'])
                      ->get();

        return [
            'total_orders' => $orders->count(),
            'total_revenue' => $orders->sum('total_amount'),
            'average_order_value' => $orders->count() > 0 ? $orders->avg('total_amount') : 0,
            'orders' => $orders,
            'period' => [
                'start' => $startDate,
                'end' => $endDate
            ]
        ];
    }

    /**
     * Format alamat pengiriman
     */
    public static function formatShippingAddress(?string $address): string
    {
        if (!$address) return 'Tidak ada alamat';

        return str_replace(["\n", "\r"], ', ', trim($address));
    }

    /**
     * Format estimasi pengiriman
     */
    public static function getEstimatedDelivery($order): string
    {
        if ($order->payment_method === 'cod') {
            return '1-3 hari kerja setelah konfirmasi';
        } else {
            return '1-3 hari kerja setelah pembayaran';
        }
    }
}
