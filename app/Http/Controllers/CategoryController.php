<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Utils\Pagination;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categoriesView(Request $request)
    {
        $data = $this->filterAndPaginateCategories($request);
        return view('categories.index', ['data' => $data]);
    }

    public function categoryView(Request $request, string $id)
    {
        if (!($category = Category::find($id))) return 'Category doesnt exist';

        $data = $this->filterAndPaginateDocuments($request, [
            'category_id' => $category->id,
        ]);

        return view('categories.category', [
            'data' => $data,
            'category' => $category,
        ]);
    }

    public function createView(): View
    {
        return view('categories.new');
    }

    /*
     * Filters and paginates category items
     *
     * @param Request $request
     *
     * */
    private function filterAndPaginateDocuments(Request $request, array $parameters)
    {
        // TODO: Once filtering functions start to grow, consider creating a separate abstract class like ItemFilter and then DocumentFilter, CategoryFilter, etc.

        $data = [];

        if ($data['search_name'] = $request->input('search_name'))
        {
            if ($category_id = $parameters['category_id'])
                $documents = Document::where('title', 'like', '%' . $data['search_name'] . '%')->where('category_id', $category_id)->get();
            else
                $documents = Document::where('title', 'like', '%' . $data['search_name'] . '%')->get();
        }
        else
        {
            if ($category_id = $parameters['category_id'])
                $documents = Document::where('category_id', $category_id)->get();
            else
                $documents = Document::all();
        }

        $paginationData = $this->paginateItems($request, $documents);
        $data = array_merge($data, $paginationData);

        return $data;
    }

    /*
     * Filters and paginates category items
     *
     * @param Request $request
     *
     * */
    private function filterAndPaginateCategories(Request $request)
    {
        $data = [];

        if ($data['search_name'] = $request->input('search_name'))
            $categories = Category::where('name', 'like', '%' . $data['search_name'] . '%')->get();
        else
            $categories = Category::all();

        $paginationData = $this->paginateItems($request, $categories);
        $data = array_merge($data, $paginationData);

        return $data;
    }

    /*
     * Paginates items and returns them with pagination data
     *
     * @param Request $request
     * @param Collection $items - Items to paginate
     *
     * */
    private function paginateItems(Request $request, Collection $items)
    {
        $pagination = new Pagination($request, $items);
        return $pagination->getData();
    }

    public function create(Request $request)
    {
        if (!$this->createAndValidateCategory($request))
        {
            return 'Failed to create category';
        }

        return Redirect::to('categories');
    }

    /*
     * Validates request data and creates a new category
     *
     * @param Request $request
     *
     * */
    private function createAndValidateCategory(Request $request)
    {
        // After small investigation: when Request object tries to validate fields via a Validator created in $request->validate() macro, once the validation fails, it will throw a ValidationException that will then be handled by \Illuminate\Foundation\Exceptions\Handler and it will transform this exception into a redirect to the previous URL.

        $validator = Validator::make($request->all(), ['name' => 'required|string']);

        if ($validator->fails()) return false;

        Category::create(['name' => $request->input('name')]);
        return true;
    }

    public function delete(Request $request, string $id)
    {
        if (!$this->deleteCategory($id))
        {
            return 'Failed to delete category';
        }

        return Redirect::to('categories');
    }

    /*
     * Deletes category with the specified ID if it exists
     *
     * @param string $id - Category id
     *
     * */
    private function deleteCategory(string $id)
    {
        $category = Category::where('id', $id);
        if ($category->exists())
        {
            $category->delete();
            return true;
        }

        Log::debug('Failed to delete category: Category doesnt exist');
        return false;
    }
}
