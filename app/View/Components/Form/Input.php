<?php

namespace App\View\Components\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Input extends Component
{
    public $title;
    public $name;
    public $type;
    public $placeholder;
    public $value;
    public $class;
    public $readonly;
    public function __construct($title, $name, $type = "text", $placeholder, $value, $class = "", $readonly = false)
    {
        $this->title = $title;
        $this->name = $name;
        $this->type = $type;
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->class = $class;
        $this->readonly = $readonly;
    }

    public function render(): View|Closure|string
    {
        return view('components.form.input');
    }
}
