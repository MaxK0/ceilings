<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Ceiling;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CeilingFactory extends Factory
{
    protected $model = Ceiling::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomNumber(),
            'thickness' => $this->faker->randomFloat(),
            'width' => $this->faker->randomNumber(),
            'description' => $this->faker->text(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'category_id' => Category::factory(),
            'manufacturer_id' => Manufacturer::factory(),
        ];
    }
}
