<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;

class CatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Yves Saint Laurent',
                'description' => 'Parfum mewah dengan karakter elegan dan sophisticated',
                'image' => 'brand/ysl.png',
            ],
            [
                'name' => 'Dior',
                'description' => 'Keanggunan klasik Prancis dalam setiap aroma',
                'image' => 'brand/Dior_Logo.webp',
            ],
            [
                'name' => 'Chanel',
                'description' => 'Ikonik, timeless, dan penuh dengan kemewahan',
                'image' => 'brand/chanel.png',
            ],
            [
                'name' => 'HMNS',
                'description' => 'Aroma modern yang fresh dan sophisticated',
                'image' => 'brand/HMNS.png',
            ],
            [
                'name' => 'Mykonos',
                'description' => 'Kesegaran Mediterania dalam setiap semprotan',
                'image' => 'brand/mykonos.jpeg',
            ],
            [
                'name' => 'Saff & Co',
                'description' => 'Koleksi parfum eksklusif dengan sentuhan oriental',
                'image' => 'brand/SAFF N CO.png',
            ],
        ];

        foreach ($brands as $brandData) {
            $brand = Brand::firstOrCreate(
                ['slug' => Str::slug($brandData['name'])],
                [
                    'name' => $brandData['name'],
                    'description' => $brandData['description'],
                    'image' => $brandData['image'],
                ]
            );

            // Dummy product for each brand
            Product::firstOrCreate(
                ['slug' => Str::slug($brand->name . ' Signature Perfume')],
                [
                    'brand_id' => $brand->id,
                    'name' => $brand->name . ' Signature Perfume',
                    'description' => 'Aroma khas dari ' . $brand->name,
                    'price' => rand(150000, 2500000),
                    'stock' => rand(10, 50),
                    'image' => $brandData['image'],
                    'is_active' => true,
                ]
            );
        }
    }
}
