<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RadioGroup extends Component
{
    public $label;
    public $name;
    public $opciones;

    /**
     * Create a new component instance.
     */
    public function __construct($label='radio-group', $name='radio-group', $opciones=[])
    {
        $this->label = $label;
        $this->name = $name;
        $this->opciones = $opciones;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.radio-group');
    }
}
