<?php

namespace App\View\Components\Document;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Card extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $fileSrc,
        public string $fileType,
        public string $id,
        public string $title,
        public array $params,
    )
    {

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.document.card');
    }
}
