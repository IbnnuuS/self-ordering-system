<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class CategoryMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Food categories & menus
        $foodCategory = Category::create(['name' => 'Makanan', 'type' => 'food']);

        $foods = [
            ['name' => 'Nasi Goreng Spesial', 'description' => 'Nasi goreng dengan telur, ayam, dan sayuran', 'price' => 25000],
            ['name' => 'Mie Goreng', 'description' => 'Mie goreng dengan topping lengkap', 'price' => 22000],
            ['name' => 'Ayam Bakar', 'description' => 'Ayam bakar bumbu kecap dengan lalapan', 'price' => 35000],
            ['name' => 'Ayam Goreng', 'description' => 'Ayam goreng crispy dengan nasi', 'price' => 30000],
            ['name' => 'Soto Ayam', 'description' => 'Soto ayam kuah bening dengan nasi', 'price' => 20000],
            ['name' => 'Bakso', 'description' => 'Bakso sapi dengan mie dan kuah kaldu', 'price' => 18000],
            ['name' => 'Gado-Gado', 'description' => 'Sayuran segar dengan bumbu kacang', 'price' => 15000],
            ['name' => 'Nasi Uduk', 'description' => 'Nasi uduk dengan lauk pilihan', 'price' => 20000],
            ['name' => 'Pecel Lele', 'description' => 'Lele goreng dengan sambal dan lalapan', 'price' => 22000],
            ['name' => 'Rendang', 'description' => 'Rendang daging sapi dengan nasi putih', 'price' => 40000],
            ['name' => 'Sate Ayam', 'description' => '10 tusuk sate ayam dengan bumbu kacang', 'price' => 28000],
            ['name' => 'Capcay', 'description' => 'Tumis sayuran dengan saus tiram', 'price' => 20000],
            ['name' => 'Nasi Kuning', 'description' => 'Nasi kuning dengan lauk lengkap', 'price' => 22000],
            ['name' => 'Mie Rebus', 'description' => 'Mie rebus kuah kaldu dengan topping', 'price' => 18000],
            ['name' => 'Nasi Campur', 'description' => 'Nasi dengan berbagai lauk pilihan', 'price' => 25000],
            ['name' => 'Ikan Bakar', 'description' => 'Ikan bakar bumbu rempah dengan nasi', 'price' => 38000],
            ['name' => 'Tongseng', 'description' => 'Tongseng daging kambing dengan nasi', 'price' => 35000],
            ['name' => 'Pempek', 'description' => 'Pempek palembang dengan cuko', 'price' => 20000],
            ['name' => 'Ketoprak', 'description' => 'Ketoprak dengan bumbu kacang dan kerupuk', 'price' => 15000],
            ['name' => 'Bubur Ayam', 'description' => 'Bubur ayam dengan topping lengkap', 'price' => 18000],
        ];

        foreach ($foods as $food) {
            Menu::create(array_merge($food, ['category_id' => $foodCategory->id]));
        }

        // Drink categories & menus
        $drinkCategory = Category::create(['name' => 'Minuman', 'type' => 'drink']);

        $drinks = [
            ['name' => 'Es Teh Manis', 'description' => 'Teh manis dingin segar', 'price' => 5000],
            ['name' => 'Es Jeruk', 'description' => 'Jeruk peras segar dengan es', 'price' => 8000],
            ['name' => 'Jus Alpukat', 'description' => 'Jus alpukat segar dengan susu', 'price' => 15000],
            ['name' => 'Jus Mangga', 'description' => 'Jus mangga segar', 'price' => 12000],
            ['name' => 'Es Kopi Susu', 'description' => 'Kopi susu dingin kekinian', 'price' => 18000],
            ['name' => 'Kopi Hitam', 'description' => 'Kopi hitam panas atau dingin', 'price' => 10000],
            ['name' => 'Teh Tarik', 'description' => 'Teh tarik creamy panas', 'price' => 12000],
            ['name' => 'Es Cincau', 'description' => 'Es cincau hitam dengan santan', 'price' => 8000],
            ['name' => 'Jus Semangka', 'description' => 'Jus semangka segar tanpa biji', 'price' => 10000],
            ['name' => 'Es Campur', 'description' => 'Es campur dengan berbagai topping', 'price' => 15000],
            ['name' => 'Milkshake Coklat', 'description' => 'Milkshake coklat creamy', 'price' => 20000],
            ['name' => 'Milkshake Vanilla', 'description' => 'Milkshake vanilla lembut', 'price' => 20000],
            ['name' => 'Es Lemon Tea', 'description' => 'Teh lemon dingin menyegarkan', 'price' => 10000],
            ['name' => 'Air Mineral', 'description' => 'Air mineral botol 600ml', 'price' => 5000],
            ['name' => 'Soda Gembira', 'description' => 'Soda dengan sirup dan susu', 'price' => 12000],
            ['name' => 'Jus Jambu', 'description' => 'Jus jambu biji merah segar', 'price' => 10000],
            ['name' => 'Es Dawet', 'description' => 'Es dawet dengan santan dan gula merah', 'price' => 8000],
            ['name' => 'Kopi Latte', 'description' => 'Espresso dengan steamed milk', 'price' => 22000],
            ['name' => 'Matcha Latte', 'description' => 'Matcha premium dengan susu', 'price' => 22000],
            ['name' => 'Thai Tea', 'description' => 'Thai tea original dengan susu', 'price' => 15000],
        ];

        foreach ($drinks as $drink) {
            Menu::create(array_merge($drink, ['category_id' => $drinkCategory->id]));
        }
    }
}
