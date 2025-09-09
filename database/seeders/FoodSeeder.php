<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use App\Models\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foods')->insert([
            [
                'name' => 'Pizza',
                'description' => 'Delicious cheese pizza',
                'price' => 12.99,
                'image_url' => 'https://via.placeholder.com/300',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Burger',
                'description' => 'Juicy beef burger',
                'price' => 8.99,
                'image_url' => 'https://via.placeholder.com/300',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pasta',
                'description' => 'Creamy Alfredo pasta',
                'price' => 10.50,
                'image_url' => 'https://via.placeholder.com/300',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
