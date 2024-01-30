<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextArea extends Component
{
    public $title;
    public $name;
    public $placeholder;
    public $value;
    public $class;
    public function __construct($title, $name, $placeholder, $value, $class = "")
    {
        $this->title = $title;
        $this->name = $name;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->class = $class;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.text-area');
    }
}
