<?php

namespace App\View\Components\Inputs;

use App\Models\Category;

class SelectCategories extends Select
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($value = null)
    {
        $categories = Category::all();

        $options = [];
        foreach ($categories as $category)
            $options[$category->id] = $category->title;

        parent::__construct($options, 'categories', 'Categories', $value);
    }
}
