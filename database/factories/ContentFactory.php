<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Content::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = trim(substr(str_replace('.', '', $this->faker->paragraph(1, true)), 0, 255));

        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(5, true),
            'url' => (string) Str::of($title)->slug('-')
        ];
    }
}
