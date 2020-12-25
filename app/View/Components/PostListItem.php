<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PostListItem extends Component
{
    public $post;
    public $content;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
        $this->content = $post->content->first();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.post-list-item');
    }
}
