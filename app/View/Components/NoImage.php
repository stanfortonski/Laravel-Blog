<?php

namespace App\View\Components;

use Illuminate\View\Component;

class NoImage extends Component
{
    public $obj;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($obj)
    {
        $this->obj = $obj;
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
