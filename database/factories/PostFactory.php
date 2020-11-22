<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->words(rand(1, 4), true),
            'content' => $this->faker->paragraphs(5, true),
            'is_visible' => rand(0, 1),
            'thumbnail_path' => null,
            'publish_at' => null,
            'author_id' => User::all()->random()->id
        ];
    }
}
