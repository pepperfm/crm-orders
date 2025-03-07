<?php

declare(strict_types=1);

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'is_admin' => true,
        ]);

        Category::query()->insert([
            ['name' => 'Лёгкий'],
            ['name' => 'Хрупкий'],
            ['name' => 'Тяжёлый'],
        ]);

        Product::factory()->count(100)->create();
        Order::factory()->count(200)->create();
    }
}
