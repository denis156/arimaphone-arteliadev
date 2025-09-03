<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil admin user sebagai seller
        $seller = User::where('is_admin', true)->first();

        if (!$seller) {
            $this->command->error('Admin user not found. Please run AdminUserSeeder first.');
            return;
        }

        // Ambil semua kategori
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->error('Categories not found. Please run CategoriesSeeder first.');
            return;
        }

        // Data produk iPhone realistis
        $products = [
            // iPhone 15 Series
            [
                'category_name' => 'iPhone 15',
                'category_series' => 'Pro Max',
                'storage_capacity' => '256GB',
                'color' => 'Titanium Natural',
                'price' => 19999000,
                'condition_rating' => 'Like New',
                'battery_health' => 100,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 15 Pro Max 256GB Titanium Natural kondisi seperti baru, garansi resmi iBox masih berlaku.',
                'is_featured' => true,
                'views_count' => 245
            ],
            [
                'category_name' => 'iPhone 15',
                'category_series' => 'Pro Max',
                'storage_capacity' => '512GB',
                'color' => 'Titanium Blue',
                'price' => 22999000,
                'condition_rating' => 'Excellent',
                'battery_health' => 98,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 15 Pro Max 512GB Blue Titanium, kondisi excellent, lengkap dengan box dan aksesoris.',
                'is_featured' => true,
                'views_count' => 189
            ],
            [
                'category_name' => 'iPhone 15',
                'category_series' => 'Pro',
                'storage_capacity' => '128GB',
                'color' => 'Titanium Black',
                'price' => 16999000,
                'condition_rating' => 'Excellent',
                'battery_health' => 99,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 15 Pro 128GB Black Titanium dalam kondisi sangat baik, no minus.',
                'is_featured' => false,
                'views_count' => 167
            ],
            [
                'category_name' => 'iPhone 15',
                'category_series' => 'Standard',
                'storage_capacity' => '128GB',
                'color' => 'Pink',
                'price' => 13499000,
                'condition_rating' => 'Good',
                'battery_health' => 95,
                'box_type' => 'Original',
                'phone_type' => 'Inter',
                'description' => 'iPhone 15 128GB Pink, kondisi bagus dengan sedikit wear normal pada casing.',
                'is_featured' => false,
                'views_count' => 134
            ],

            // iPhone 14 Series
            [
                'category_name' => 'iPhone 14',
                'category_series' => 'Pro Max',
                'storage_capacity' => '256GB',
                'color' => 'Deep Purple',
                'price' => 17999000,
                'condition_rating' => 'Like New',
                'battery_health' => 97,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 14 Pro Max 256GB Deep Purple, kondisi mint, garansi resmi iBox.',
                'is_featured' => true,
                'views_count' => 298
            ],
            [
                'category_name' => 'iPhone 14',
                'category_series' => 'Pro',
                'storage_capacity' => '512GB',
                'color' => 'Gold',
                'price' => 18999000,
                'condition_rating' => 'Excellent',
                'battery_health' => 96,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 14 Pro 512GB Gold dalam kondisi excellent, battery health masih sangat baik.',
                'is_featured' => false,
                'views_count' => 223
            ],
            [
                'category_name' => 'iPhone 14',
                'category_series' => 'Standard',
                'storage_capacity' => '128GB',
                'color' => 'Blue',
                'price' => 11999000,
                'condition_rating' => 'Good',
                'battery_health' => 94,
                'box_type' => 'Original',
                'phone_type' => 'Inter',
                'description' => 'iPhone 14 128GB Blue, kondisi bagus normal wear, fungsi 100% lancar.',
                'is_featured' => false,
                'views_count' => 178
            ],

            // iPhone 13 Series
            [
                'category_name' => 'iPhone 13',
                'category_series' => 'Pro Max',
                'storage_capacity' => '256GB',
                'color' => 'Sierra Blue',
                'price' => 15999000,
                'condition_rating' => 'Excellent',
                'battery_health' => 93,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 13 Pro Max 256GB Sierra Blue, kondisi excellent dengan battery health masih bagus.',
                'is_featured' => true,
                'views_count' => 312
            ],
            [
                'category_name' => 'iPhone 13',
                'category_series' => 'Pro',
                'storage_capacity' => '128GB',
                'color' => 'Graphite',
                'price' => 13999000,
                'condition_rating' => 'Good',
                'battery_health' => 91,
                'box_type' => 'OEM',
                'phone_type' => 'Inter',
                'description' => 'iPhone 13 Pro 128GB Graphite, kondisi bagus dengan box OEM, fungsi normal.',
                'is_featured' => false,
                'views_count' => 156
            ],
            [
                'category_name' => 'iPhone 13',
                'category_series' => 'Standard',
                'storage_capacity' => '256GB',
                'color' => 'Pink',
                'price' => 11499000,
                'condition_rating' => 'Good',
                'battery_health' => 89,
                'box_type' => 'Original',
                'phone_type' => 'Inter',
                'description' => 'iPhone 13 256GB Pink, kondisi baik dengan normal wear, battery masih oke.',
                'is_featured' => false,
                'views_count' => 198
            ],

            // iPhone 12 Series
            [
                'category_name' => 'iPhone 12',
                'category_series' => 'Pro Max',
                'storage_capacity' => '128GB',
                'color' => 'Pacific Blue',
                'price' => 12999000,
                'condition_rating' => 'Good',
                'battery_health' => 87,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 12 Pro Max 128GB Pacific Blue, kondisi bagus dengan beberapa micro scratches.',
                'is_featured' => false,
                'views_count' => 267
            ],
            [
                'category_name' => 'iPhone 12',
                'category_series' => 'Pro',
                'storage_capacity' => '256GB',
                'color' => 'Gold',
                'price' => 11999000,
                'condition_rating' => 'Fair',
                'battery_health' => 84,
                'box_type' => 'OEM',
                'phone_type' => 'Inter',
                'description' => 'iPhone 12 Pro 256GB Gold, kondisi fair dengan beberapa wear marks, battery perlu service.',
                'is_featured' => false,
                'views_count' => 143
            ],
            [
                'category_name' => 'iPhone 12',
                'category_series' => 'Standard',
                'storage_capacity' => '64GB',
                'color' => 'Red',
                'price' => 8999000,
                'condition_rating' => 'Good',
                'battery_health' => 86,
                'box_type' => 'OEM',
                'phone_type' => 'Inter',
                'description' => 'iPhone 12 64GB Product Red, kondisi bagus dengan box OEM, cocok untuk daily use.',
                'is_featured' => false,
                'views_count' => 201
            ],

            // iPhone 11 Series
            [
                'category_name' => 'iPhone 11',
                'category_series' => 'Pro Max',
                'storage_capacity' => '256GB',
                'color' => 'Midnight Green',
                'price' => 10999000,
                'condition_rating' => 'Good',
                'battery_health' => 83,
                'box_type' => 'Original',
                'phone_type' => 'iBox',
                'description' => 'iPhone 11 Pro Max 256GB Midnight Green, kondisi bagus dengan battery health masih acceptable.',
                'is_featured' => false,
                'views_count' => 289
            ],
            [
                'category_name' => 'iPhone 11',
                'category_series' => 'Standard',
                'storage_capacity' => '128GB',
                'color' => 'Black',
                'price' => 7999000,
                'condition_rating' => 'Fair',
                'battery_health' => 81,
                'box_type' => 'OEM',
                'phone_type' => 'Inter',
                'description' => 'iPhone 11 128GB Black, kondisi fair dengan normal wear, battery masih bisa dipakai.',
                'is_featured' => false,
                'views_count' => 167
            ],

            // iPhone XS Series
            [
                'category_name' => 'iPhone XS',
                'category_series' => 'Max',
                'storage_capacity' => '256GB',
                'color' => 'Space Gray',
                'price' => 8499000,
                'condition_rating' => 'Fair',
                'battery_health' => 79,
                'box_type' => 'OEM',
                'phone_type' => 'Inter',
                'description' => 'iPhone XS Max 256GB Space Gray, kondisi fair cocok untuk backup phone.',
                'is_featured' => false,
                'views_count' => 134
            ],

            // iPhone XR
            [
                'category_name' => 'iPhone XR',
                'category_series' => 'Standard',
                'storage_capacity' => '128GB',
                'color' => 'Blue',
                'price' => 6999000,
                'condition_rating' => 'Good',
                'battery_health' => 82,
                'box_type' => 'OEM',
                'phone_type' => 'Inter',
                'description' => 'iPhone XR 128GB Blue, kondisi bagus dengan battery yang masih layak pakai.',
                'is_featured' => false,
                'views_count' => 198
            ],

            // iPhone X
            [
                'category_name' => 'iPhone X',
                'category_series' => 'Standard',
                'storage_capacity' => '64GB',
                'color' => 'Silver',
                'price' => 5999000,
                'condition_rating' => 'Fair',
                'battery_health' => 76,
                'box_type' => 'OEM',
                'phone_type' => 'Inter',
                'description' => 'iPhone X 64GB Silver, kondisi fair dengan beberapa wear, cocok untuk koleksi.',
                'is_featured' => false,
                'views_count' => 156
            ]
        ];

        foreach ($products as $productData) {
            // Cari kategori berdasarkan name dan series
            $category = $categories->where('name', $productData['category_name'])
                                 ->where('series', $productData['category_series'])
                                 ->first();

            if (!$category) {
                $this->command->warn("Category {$productData['category_name']} {$productData['category_series']} not found, skipping...");
                continue;
            }

            // Generate title
            $title = "{$productData['category_name']} {$productData['category_series']} {$productData['storage_capacity']} {$productData['color']} - {$productData['condition_rating']}";

            // Generate slug
            $slug = Str::slug($title) . '-' . Str::random(8);

            // Generate IMEI (random 15 digits)
            $imei = '35' . str_pad((string)rand(1000000000000, 9999999999999), 13, '0', STR_PAD_LEFT);

            // Randomize some fields
            $acceptCod = rand(0, 1) === 1;
            $acceptOnlinePayment = rand(0, 1) === 1;
            $isNegotiable = rand(0, 1) === 1;
            $hasBeenRepaired = rand(0, 10) > 7; // 30% chance

            // Generate repair history if has been repaired
            $repairHistory = null;
            if ($hasBeenRepaired) {
                $repairs = ['Ganti battery', 'Service charging port', 'Ganti screen', 'Service speaker'];
                $repairHistory = $repairs[array_rand($repairs)] . ' di authorized service center.';
            }

            // Generate physical condition description
            $physicalConditions = [
                'Like New' => 'Kondisi sangat baik tanpa cacat berarti, seperti baru.',
                'Excellent' => 'Kondisi excellent dengan micro scratches minimal yang tidak mengganggu.',
                'Good' => 'Kondisi bagus dengan normal wear di bagian frame dan back panel.',
                'Fair' => 'Kondisi fair dengan beberapa scratches dan wear marks yang terlihat.',
                'Poor' => 'Kondisi kurang baik dengan scratches dan dents yang cukup terlihat.'
            ];

            Product::create([
                'seller_id' => $seller->id,
                'category_id' => $category->id,
                'title' => $title,
                'description' => $productData['description'],
                'storage_capacity' => $productData['storage_capacity'],
                'color' => $productData['color'],
                'imei' => $imei,
                'condition_rating' => $productData['condition_rating'],
                'battery_health' => $productData['battery_health'],
                'box_type' => $productData['box_type'],
                'phone_type' => $productData['phone_type'],
                'has_been_repaired' => $hasBeenRepaired,
                'repair_history' => $repairHistory,
                'physical_condition' => $physicalConditions[$productData['condition_rating']],
                'functional_issues' => null, // Assume no functional issues for seed data
                'price' => $productData['price'],
                'is_negotiable' => $isNegotiable,
                'stock_quantity' => 1,
                'status' => 'available',
                'accept_cod' => $acceptCod,
                'accept_online_payment' => $acceptOnlinePayment,
                'slug' => $slug,
                'views_count' => $productData['views_count'],
                'is_featured' => $productData['is_featured'],
            ]);
        }
    }
}
