<?php

namespace App\View\Components\Document\Info;

use App\Models\Category;
use App\Models\Document;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Collapsible extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public Document $document,
        public Category $category,
    )
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.document.info.collapsible');
    }
}
