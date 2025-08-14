<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DynamicComponentsController extends Controller
{
    private function validateComponent(Request $request, $rules): array|null
    {
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) return null;

        // return validated data
        return $validator->validated();
    }

    public function selectionComponent(Request $request)
    {
        $validatedData = $this->validateComponent($request, [
            'count' => 'required|integer',
            'selected-items' => 'required|string',
        ]);

        if (!$validatedData) return 'empty component: not enough data provided';

        return view('components.selection.dialog', [
            'items' => $validatedData['selected-items'],
            'count' => $validatedData['count'],
        ]);
    }

    public function categorySelectComponent(Request $request)
    {
        $validatedData = $this->validateComponent($request, [
            'id' => 'required|integer',
            'name' => 'required|string',
            'current-category-id' => 'required|integer',
        ]);

        if (!$validatedData) return 'empty component: not enough data provided';

        return view('components.category.select', [
            'id' => $validatedData['id'],
            'name' => $validatedData['name'],
            'currentCategoryId' => $validatedData['current-category-id'],
        ]);
    }

    public function uploadedDocumentCollapsibleComponent(Request $request)
    {
        $validatedData = $this->validateComponent($request, [
            'index' => 'required|integer',
            'document-title' => 'required|string',
            'category-id' => 'required|integer',
        ]);

        if (!$validatedData) return 'empty component: not enough data provided';

        return view('components.document.uploaded.collapsible', [
            'index' => $validatedData['index'],
            'documentTitle' => $validatedData['document-title'],
            'categoryId' => $validatedData['category-id'],
        ]);
    }
}
