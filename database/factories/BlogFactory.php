<?php

namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->numberBetween(1, 100),
            'title' => fake()->title,
            'text' => fake()->paragraph,
            'views' => 0,
            'publish_date' => fake()->dateTime,
        ];
    }


    /**
     * @param $authorId
     * @return Factory
     */
    public function setAuthorId($authorId = null): Factory
    {
        return $this->state(function (array $attributes) use ($authorId){
            if (!$authorId){
                $authorId = User::factory()->setRole('editor')->create()->id;
            }
            return [
                'author_id' => $authorId,
            ];
        });
    }
}
