<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();
        DB::table('products')->delete();

        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Electronics'],
            ['id' => 2, 'name' => 'Clothing'],
            ['id' => 3, 'name' => 'Books'],
            ['id' => 4, 'name' => 'Home & Kitchen'],
        ]);

        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Smartphone',
                'description' => 'Latest model with advanced features',
                'price' => 699.99,
                'stock' => 50,
                'image' => 'smartphone.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Laptop',
                'description' => 'Powerful laptop for work and gaming',
                'price' => 1299.99,
                'stock' => 30,
                'image' => 'laptop.jpg',
                'category_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
