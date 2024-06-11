<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attribute>
 */
class AttributeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attributes = [
            'Color', 'Size', 'Material', 'Brand', 'Weight',
            'Style', 'Pattern', 'Capacity', 'Fit', 'Length',
            'Width', 'Height', 'Voltage', 'Wattage', 'Features',
            'Ingredients', 'Compatibility', 'Warranty', 'Model'
          ];
        return [
                'name' => $this->faker->randomElement($attributes),
             
          
        ];
    }
}
