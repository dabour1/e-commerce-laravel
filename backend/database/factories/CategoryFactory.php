<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         
            
        $categories = [
            'Electronics', 'Books', 'Clothing', 'Furniture', 'Toys',
            'Home Appliances', 'Sports Equipment', 'Office Supplies', 'Musical Instruments', 'Jewelry',
            'Arts & Crafts', 'Beauty Products', 'Pet Supplies', 'Garden Tools', 'Party Supplies',
            'Automobiles', 'Luggage', 'Video Games', 'Movies & Music'
          ];
    
            return [
                'name' => $this->faker->randomElement($categories),
            ];
             
         
    }
}
