<?php

namespace Database\Factories;

use App\Helpers\Helper;
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
        $title = trim(substr($this->faker->paragraph(1, true), 0, 255));
        $url = Helper::properUrl($title);

        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(5, true),
            'url' => $url
        ];
    }
}
