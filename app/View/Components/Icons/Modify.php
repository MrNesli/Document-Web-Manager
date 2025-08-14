<?php

namespace App\View\Components\Icons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Modify extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $width = '22',
        public string $height = '22',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.icons.modify');
    }
}
