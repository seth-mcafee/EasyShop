<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Men Clothes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Women Clothes',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'name' => 'Laptops',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Plants',
                'created_at' => now(),
                'updated_at' => now(),
            ]

        ]);
    }
}
