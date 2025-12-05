<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        Product::insert([
            [
                'name' => 'Galon Aqua 19L',
                'description' => 'Air mineral segar dari pegunungan',
                'price' => 8000.00,
                'stock' => 10,
            ],
            [
                'name' => 'Galon Le Minerale 19L',
                'description' => 'Rasa segar dengan kandungan mineral alami',
                'price' => 12000.00,
                'stock' => 8,
            ],
            [
                'name' => 'Galon Club 19L',
                'description' => 'Air minum berkualitas dengan harga terjangkau',
                'price' => 6000.00,
                'stock' => 12,
            ],
        ]);
    }
}
