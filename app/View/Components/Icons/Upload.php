<?php

namespace App\View\Components\Icons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Upload extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $width = '19',
        public string $height = '19',
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.icons.upload');
    }
}
