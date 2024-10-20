<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menClothesCategoryId = DB::table('categories')->where('name', 'Men Clothes')->first()->id;
        $laptopsCategoryId = DB::table('categories')->where('name', 'Laptops')->first()->id;
        $sellerId = DB::table('sellers')->where('name', 'Sharan')->first()->id;

        DB::table('products')->insert([
            [
                'name' => 'Jeans',
                'description' => 'Un pantalón Denim',
                'price' => 39.99,
                'quantity' => 2,
                'image_url' => 'jeans.webp',
                'seller_id'=> $sellerId,
                'category_id' => $menClothesCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'name' => 'Mac',
                'description' => 'Mac Air M3 en azul noche',
                'price' => 899.99,
                'quantity' => 4,
                'image_url'=> 'mac.jpg',
                'seller_id'=> $sellerId,
                'category_id' => $laptopsCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]
        );
    }
}
