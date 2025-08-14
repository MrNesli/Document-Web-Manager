<?php

namespace App\View\Components\Buttons;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;

class Create extends Component
{

    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $action = '',
        public string $method = 'GET',
    )
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.buttons.create');
    }
}
