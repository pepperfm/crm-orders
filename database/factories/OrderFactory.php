<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Enums\OrderStatusEnum;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $product = Product::query()->inRandomOrder()->first();

        return [
            'status' => collect(OrderStatusEnum::cases())->random(),
            'comment' => $this->faker->word(),
            'sum' => $product->price,

            'product_id' => $product->getKey(),
            'user_id' => User::factory(),
        ];
    }
}
