<?php

namespace Database\Factories;

use App\Models\Content;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'title' => trim(substr(str_replace('.', '', $this->faker->paragraph(1, true)), 0, 255)),
            'content' => $this->faker->paragraphs(5, true)
        ];
    }
}
