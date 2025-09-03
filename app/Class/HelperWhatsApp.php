<?php

declare(strict_types=1);

namespace App\Class;

use App\Models\Product;
use App\Class\HelperProduct;

class HelperWhatsApp
{
    /**
     * Nomor WhatsApp default untuk kontak
     */
    const DEFAULT_WHATSAPP_NUMBER = '6281524089375';

    /**
     * Redirect ke WhatsApp dengan pesan produk
     */
    public static function redirectToProductWhatsApp($productId)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return null;
        }

        $message = HelperProduct::generateWhatsAppMessage($product);
        $whatsappUrl = "https://wa.me/" . self::DEFAULT_WHATSAPP_NUMBER . "?text=" . $message;
        
        return redirect()->to($whatsappUrl);
    }

    /**
     * Redirect ke WhatsApp dengan pesan custom
     */
    public static function redirectToCustomWhatsApp(string $message, ?string $phoneNumber = null)
    {
        $phone = $phoneNumber ?? self::DEFAULT_WHATSAPP_NUMBER;
        $whatsappUrl = "https://wa.me/{$phone}?text=" . urlencode($message);
        
        return redirect()->to($whatsappUrl);
    }

    /**
     * Generate URL WhatsApp untuk pesan produk (tanpa redirect)
     */
    public static function generateProductWhatsAppUrl($productId, ?string $phoneNumber = null): ?string
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return null;
        }

        $phone = $phoneNumber ?? self::DEFAULT_WHATSAPP_NUMBER;
        $message = HelperProduct::generateWhatsAppMessage($product);
        
        return "https://wa.me/{$phone}?text=" . $message;
    }

    /**
     * Generate URL WhatsApp untuk pesan custom (tanpa redirect)
     */
    public static function generateCustomWhatsAppUrl(string $message, ?string $phoneNumber = null): string
    {
        $phone = $phoneNumber ?? self::DEFAULT_WHATSAPP_NUMBER;
        return "https://wa.me/{$phone}?text=" . urlencode($message);
    }

    /**
     * Generate pesan untuk konsultasi umum
     */
    public static function generateConsultationMessage(): string
    {
        return "Halo! Saya tertarik untuk berkonsultasi tentang produk iPhone yang tersedia. Mohon informasi lebih lanjut. Terima kasih!";
    }

    /**
     * Redirect ke WhatsApp untuk konsultasi umum
     */
    public static function redirectToConsultation(?string $phoneNumber = null)
    {
        $message = self::generateConsultationMessage();
        return self::redirectToCustomWhatsApp($message, $phoneNumber);
    }

    /**
     * Format nomor WhatsApp (menghilangkan karakter non-numeric dan menambah 62 jika perlu)
     */
    public static function formatPhoneNumber(string $phoneNumber): string
    {
        // Hapus semua karakter non-numeric
        $clean = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Jika dimulai dengan 0, ganti dengan 62
        if (substr($clean, 0, 1) === '0') {
            $clean = '62' . substr($clean, 1);
        }
        
        // Jika tidak dimulai dengan 62, tambahkan 62
        if (substr($clean, 0, 2) !== '62') {
            $clean = '62' . $clean;
        }
        
        return $clean;
    }

    /**
     * Set nomor WhatsApp default (bisa dipanggil dari config atau setting)
     * Note: Ini hanya contoh, seharusnya disimpan di config atau database
     */
    public static function setDefaultWhatsAppNumber(string $phoneNumber): void
    {
        // Untuk implementasi real, bisa menggunakan config atau site_settings
        // Contoh: config(['app.whatsapp_number' => self::formatPhoneNumber($phoneNumber)]);
        
        // Placeholder implementation - seharusnya disimpan ke config atau database
        // self::$defaultNumber = self::formatPhoneNumber($phoneNumber);
    }

    /**
     * Get nomor WhatsApp dari site settings (jika ada)
     */
    public static function getWhatsAppNumber(): string
    {
        // Bisa diintegrasikan dengan SiteSetting model
        // $setting = \App\Models\SiteSetting::where('key', 'whatsapp_number')->first();
        // return $setting ? self::formatPhoneNumber($setting->value) : self::DEFAULT_WHATSAPP_NUMBER;
        
        return self::DEFAULT_WHATSAPP_NUMBER;
    }
}