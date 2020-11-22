<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuthorNote extends Component
{
    public $author;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($author)
    {
        $this->author = $author;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.author-note');
    }
}
