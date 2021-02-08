<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NoImage extends Component
{
    public $content;
    public $width;
    public $height;
    public $background;
    public $color;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($content, $width = 144, $height = 144, $background = null, $color = null)
    {
        $this->content = $content;
        $this->width = $width;
        $this->height = $height;
        $this->background = $background;
        $this->color = $color;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.no-image');
    }
}
