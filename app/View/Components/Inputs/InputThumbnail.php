<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class InputThumbnail extends Component
{
    public $label;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($label)
    {
        $this->label = $label;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.inputs.input-thumbnail');
    }
}
