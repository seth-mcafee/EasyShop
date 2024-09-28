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
                'image_url' => 'https://valentino-cdn.thron.com/delivery/public/image/valentino/67757d33-4e7b-477b-b79a-a0de1a77e0c9/ihqstx/std/500x0/BLUE-WASHED-DENIM-JEANS?quality=80&size=35&format=auto',
                'seller_id'=> $sellerId,
                'category_id' => $menClothesCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ], [
                'name' => 'Mac',
                'description' => 'Mac Air M3 en azul noche',
                'price' => 899.99,
                'quantity' => 4,
                'image_url'=> 'https://store.storeimages.cdn-apple.com/4668/as-images.apple.com/is/mba13-silver-select-202402?wid=1200&hei=630&fmt=jpeg&qlt=95&.v=1708367688030',
                'seller_id'=> $sellerId,
                'category_id' => $laptopsCategoryId,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]
        );
    }
}
