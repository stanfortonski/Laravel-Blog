<?php

namespace App\View\Components\Inputs;

use Illuminate\View\Component;

class Select extends Component
{
    public $options;
    public $name;
    public $label;
    public $value;

    /**
     * Create a new component instance.
     *
     * @param Array $options
     * @param string $name
     * @param string $label
     * @param mixed|null $selected
     * @return void
     */
    public function __construct(Array &$options, $name, $label, $value = null){
        $this->options = $options;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.inputs.select');
    }
}
