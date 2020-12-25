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
        foreach ($categories as $category){
            $content = $category->content()->first();
            if (!empty($content))
                $options[$category->id] = $content->title;
        }

        parent::__construct($options, 'categories', 'Categories', $value);
    }
}
