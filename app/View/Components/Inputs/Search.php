<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Search extends Component
{
    public $q;
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($placeholder = 'Wyszukaj', $q = '')
    {
        $this->q = $q;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.inputs.search');
    }
}
