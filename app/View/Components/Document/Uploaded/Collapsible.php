<?php

namespace App\View\Components\Document\Uploaded;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Collapsible extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public int $index,
        public string $documentTitle,
        public int $categoryId,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.document.uploaded.collapsible');
    }
}
