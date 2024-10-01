<?php

namespace Database\Factories;

use App\Models\Website;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    protected $model = \App\Models\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'website_id' => Website::factory(),  // Create a new website for each post
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'is_sent' => false,  // Default is false, as posts haven't been sent initially
        ];
    }
}
