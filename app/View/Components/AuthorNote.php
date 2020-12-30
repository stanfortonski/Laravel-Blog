<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AuthorNote extends Component
{
    public $author;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($author)
    {
        $this->author = $author;
        $this->content = $author->content()->first();
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
