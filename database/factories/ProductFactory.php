<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'sku' => $this->faker->unique()->bothify('???-#####'),
            'price' => $this->faker->numberBetween(200, 5000),
            'discounted_price' => $this->faker->numberBetween(200, 5000),
            'stock' => $this->faker->numberBetween(0, 1000),
            'description' => $this->faker->text,
            'product_information' => [
                'nutritional_values' => $this->generateNutritionalValues(),
                'ingredients' => $this->faker->sentence,
                'allergens' => $this->faker->sentence,
                'country_of_origin' => $this->faker->country,
            ],
            // 'category_id' => Category::factory(),
            // 'brand_id' => Brand::factory(),
        ];
    }

    private function generateNutritionalValues()
    {
        return [
            'energy' => $this->faker->numberBetween(50, 500) . ' kcal',
            'fat' => $this->faker->numberBetween(1, 30) . ' g',
            'saturates' => $this->faker->numberBetween(0, 10) . ' g',
            'carbohydrate' => $this->faker->numberBetween(5, 50) . ' g',
            'sugars' => $this->faker->numberBetween(1, 40) . ' g',
            'fibre' => $this->faker->numberBetween(1, 10) . ' g',
            'protein' => $this->faker->numberBetween(1, 20) . ' g',
            'salt' => $this->faker->numberBetween(0, 10) . ' g',
        ];
    }
}
