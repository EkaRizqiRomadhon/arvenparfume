<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus dulu produk lama (yang hanya 1 per brand)
        Product::truncate();

        $products = [
            // ─── YSL (brand_id: 1, slug: yves-saint-laurent) ─────────────
            'yves-saint-laurent' => [
                [
                    'name'        => 'YSL Y Eau de Parfum',
                    'description' => 'Parfum maskulin modern dengan aroma segar dan clean. Perpaduan apel, sage, dan cedar yang elegan.',
                    'price'       => 1800000,
                    'stock'       => 10,
                    'image'       => 'img/ysl_y_edp.jpg',
                ],
                [
                    'name'        => 'YSL Y Le Parfum',
                    'description' => 'Versi intense dari Y EDP — lebih gelap, lebih dalam, lebih sensual.',
                    'price'       => 2848000,
                    'stock'       => 8,
                    'image'       => 'img/ysl_y_leparfum.jpg',
                ],
                [
                    'name'        => "YSL La Nuit de L'Homme",
                    'description' => 'Parfum malam yang sensual dan hangat. Cocok untuk acara formal dan kencan.',
                    'price'       => 2500000,
                    'stock'       => 7,
                    'image'       => 'img/ysl_lanuit.jpg',
                ],
                [
                    'name'        => "YSL L'Homme",
                    'description' => 'Fresh woody yang classy dan elegant. Signature maskulin sejati.',
                    'price'       => 1700000,
                    'stock'       => 12,
                    'image'       => 'img/ysl_lhomme.jpg',
                ],
                [
                    'name'        => 'YSL Kouros',
                    'description' => 'Klasik maskulin dengan karakter kuat dan berani. Ikon parfum YSL.',
                    'price'       => 1233000,
                    'stock'       => 5,
                    'image'       => 'img/ysl_kouros.png',
                ],
                [
                    'name'        => 'YSL Black Opium',
                    'description' => 'Manis, bold, dan addictive. Perpaduan kopi, vanila, dan bunga putih.',
                    'price'       => 1644000,
                    'stock'       => 9,
                    'image'       => 'img/ysl_BlackOpium.jpg',
                ],
            ],

            // ─── DIOR (brand_id: 2, slug: dior) ──────────────────────────
            'dior' => [
                [
                    'name'        => 'Dior Sauvage EDP',
                    'description' => 'Hadir lebih kuat dan creamy dari EDT-nya. Perpaduan ambroxan dan vanilla yang intens.',
                    'price'       => 2100000,
                    'stock'       => 15,
                    'image'       => 'img/dior_sauvage_edp.jpg',
                ],
                [
                    'name'        => 'Dior Sauvage EDT',
                    'description' => 'Parfum fresh spicy yang ikonik. Elegan dan cocok untuk sehari-hari.',
                    'price'       => 1900000,
                    'stock'       => 14,
                    'image'       => 'img/dior_sauvage_edt.jpg',
                ],
                [
                    'name'        => 'Dior Homme',
                    'description' => 'Sofistikasi maskulin dengan iris, lavender, dan vetiver yang halus.',
                    'price'       => 2300000,
                    'stock'       => 6,
                    'image'       => 'img/dior_homme.jpg',
                ],
                [
                    'name'        => 'Dior Homme Intense',
                    'description' => 'Versi lebih rich dan bold dari Dior Homme. Cocok untuk malam hari.',
                    'price'       => 2500000,
                    'stock'       => 8,
                    'image'       => 'img/dior_homme_intense.jpg',
                ],
                [
                    'name'        => 'Dior Homme Sport',
                    'description' => 'Segar, energetik, dan sporty. Pilihan terbaik untuk aktivitas harian.',
                    'price'       => 1750000,
                    'stock'       => 10,
                    'image'       => 'img/dior_homme_sport.jpg',
                ],
                [
                    'name'        => 'Dior Fahrenheit',
                    'description' => 'Parfum petrol-floral yang legendary. Unik, maskulin, dan tidak tertandingi.',
                    'price'       => 1980000,
                    'stock'       => 7,
                    'image'       => 'img/dior_fahrenheit.jpg',
                ],
            ],

            // ─── CHANEL (brand_id: 3, slug: chanel) ──────────────────────
            'chanel' => [
                [
                    'name'        => 'Bleu de Chanel EDP',
                    'description' => 'Versi lebih rich dari EDT. Kayu, dupa, dan sandalwood yang mewah.',
                    'price'       => 2700000,
                    'stock'       => 11,
                    'image'       => 'img/bleu_chanel_edp.png',
                ],
                [
                    'name'        => 'Bleu de Chanel EDT',
                    'description' => 'Parfum maskulin segar terbaik dari Chanel. Citrus dan kayu yang seimbang.',
                    'price'       => 2350000,
                    'stock'       => 9,
                    'image'       => 'img/bleu_chanel_edt.jpg',
                ],
                [
                    'name'        => 'Chanel Allure Homme Sport',
                    'description' => 'Segar, bersih, dan sporty. Perpaduan citrus, sea notes, dan musim yang modern.',
                    'price'       => 2100000,
                    'stock'       => 10,
                    'image'       => 'img/allure_homme_sport.png',
                ],
                [
                    'name'        => 'Chanel Coco Mademoiselle',
                    'description' => 'Parfum feminin ikonik dengan rose, jasmine, dan patchouli. Klasik abadi.',
                    'price'       => 3200000,
                    'stock'       => 7,
                    'image'       => 'img/chanel_coco.png',
                ],
                [
                    'name'        => 'Chanel Egoiste Platinum',
                    'description' => 'Maskulin elegan dengan sage, coriander, dan cedar. Prestise tertinggi.',
                    'price'       => 1950000,
                    'stock'       => 5,
                    'image'       => 'img/egoiste_platinum.png',
                ],
            ],

            // ─── HMNS (brand_id: 4, slug: hmns) ──────────────────────────
            'hmns' => [
                [
                    'name'        => 'HMNS Alpha',
                    'description' => 'Aroma maskulin dominan dengan base woody dan musty yang kuat.',
                    'price'       => 290000,
                    'stock'       => 20,
                    'image'       => 'img/hmns_alpha.png',
                ],
                [
                    'name'        => 'HMNS Farhamptom',
                    'description' => 'Segar aristokratik ala kebun Inggris. Lavender, tea, dan vetiver.',
                    'price'       => 310000,
                    'stock'       => 18,
                    'image'       => 'img/hmns_farhampthon.png',
                ],
                [
                    'name'        => 'HMNS Orgasm',
                    'description' => 'Sensual dan mengundang. Perpaduan buah dan musk yang menawan.',
                    'price'       => 275000,
                    'stock'       => 15,
                    'image'       => 'img/hmns_orgasm.jpg',
                ],
            ],

            // ─── MYKONOS (brand_id: 5, slug: mykonos) ────────────────────
            'mykonos' => [
                [
                    'name'        => 'Mykonos Glitch',
                    'description' => 'Fresh fruity yang playful. Citrus, peach, dan amber yang menyegarkan.',
                    'price'       => 189000,
                    'stock'       => 25,
                    'image'       => 'img/mykonos_glitch.png',
                ],
                [
                    'name'        => 'Mykonos Aphrodite',
                    'description' => 'Floral elegan terinspirasi dewi kecantikan Yunani. Rose, lily, dan musim.',
                    'price'       => 199000,
                    'stock'       => 20,
                    'image'       => 'img/mykonos_aphrodite.png',
                ],
                [
                    'name'        => 'Mykonos Enchanted',
                    'description' => 'Mistis dan memikat. Lavender, vanilla, dan sandalwood yang menenangkan.',
                    'price'       => 215000,
                    'stock'       => 18,
                    'image'       => 'img/mykonos_enchanted.png',
                ],
                [
                    'name'        => 'Mykonos Luminos',
                    'description' => 'Cerah dan bersinar. Aroma bergamot, musim putih, dan cedar yang ringan.',
                    'price'       => 179000,
                    'stock'       => 22,
                    'image'       => 'img/mykonos_luminos.png',
                ],
                [
                    'name'        => 'Mykonos Monaco Royal',
                    'description' => 'Mewah dan megah. Terinspirasi kehidupan di pantai Monaco yang glamour.',
                    'price'       => 245000,
                    'stock'       => 15,
                    'image'       => 'img/mykonos_monaco royal.jpg',
                ],
            ],

            // ─── SAFF & CO (brand_id: 6, slug: saff-co) ──────────────────
            'saff-co' => [
                [
                    'name'        => 'Saff & Co Cascavel',
                    'description' => 'Warm spicy dengan saffron dan oud. Nuansa Timur Tengah yang mewah.',
                    'price'       => 349000,
                    'stock'       => 12,
                    'image'       => 'img/saffcascavel.jpg',
                ],
                [
                    'name'        => 'Saff & Co Coco',
                    'description' => 'Manis tropis dengan coconut, vanilla, dan musk yang creamy.',
                    'price'       => 299000,
                    'stock'       => 16,
                    'image'       => 'img/saffcoco.png',
                ],
                [
                    'name'        => 'Saff & Co Loui',
                    'description' => 'Elegan dan refined. Bergamot, rose, dan patchouli yang sophisticated.',
                    'price'       => 329000,
                    'stock'       => 14,
                    'image'       => 'img/saffloui.png',
                ],
                [
                    'name'        => 'Saff & Co SOTB',
                    'description' => 'Song of the Bird — fresh floral hijau terinspirasi alam pegunungan.',
                    'price'       => 319000,
                    'stock'       => 10,
                    'image'       => 'img/saffsotb.jpg',
                ],
            ],
        ];

        foreach ($products as $slug => $items) {
            $brand = Brand::where('slug', $slug)->first();
            if (!$brand) {
                $this->command->warn("Brand tidak ditemukan: {$slug}");
                continue;
            }

            foreach ($items as $item) {
                Product::create([
                    'brand_id'    => $brand->id,
                    'name'        => $item['name'],
                    'slug'        => Str::slug($item['name']),
                    'description' => $item['description'],
                    'price'       => $item['price'],
                    'stock'       => $item['stock'],
                    'image'       => $item['image'],
                    'is_active'   => true,
                ]);
            }

            $this->command->info("✅ {$brand->name}: " . count($items) . " produk");
        }

        $this->command->info('🎉 Total: ' . Product::count() . ' produk berhasil di-seed!');
    }
}
