<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CategoryListItem extends Component
{
    public $category;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->category = $category;
        $this->content = $category->content()->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.category-list-item');
    }
}
