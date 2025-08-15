<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Utils\Pagination;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /*
     * A view with a list of categories
     *
     * @return View
     *
     * */
    public function categoriesView(Request $request): View
    {
        $data = $this->filterAndPaginateCategories($request);
        return view('categories.index', ['data' => $data]);
    }

    /*
     * Specific category's view with its list of documents
     *
     * @return View
     *
     * */
    public function categoryView(Request $request, string $id): View
    {
        if (!($category = Category::find($id)))
            throw new Exception('Category doesn\'t exist');

        $data = $this->filterAndPaginateDocuments($request, [
            'category_id' => $category->id,
        ]);

        return view('categories.category', [
            'data' => $data,
            'category' => $category,
        ]);
    }

    /*
     * Document creation view
     *
     * @return View
     *
     * */
    public function createView(): View
    {
        return view('categories.new');
    }

    /*
     * Filters and paginates documents
     *
     * @param Request $request
     * @param array $parameters - document filtering params
     *
     * @return array
     *
     * */
    private function filterAndPaginateDocuments(Request $request, array $parameters): array
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
     * Filters and paginates categories
     *
     * @param Request $request
     *
     * @return array
     *
     * */
    private function filterAndPaginateCategories(Request $request): array
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
     * Paginates items and returns them as pagination data
     *
     * @param Request $request
     * @param Collection $items - Items to paginate
     *
     * @return array
     *
     * */
    private function paginateItems(Request $request, Collection $items): array
    {
        $pagination = new Pagination($request, $items);
        return $pagination->getData();
    }

    /*
     * Creates a new category
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * */
    public function create(Request $request): RedirectResponse
    {
        $this->createAndValidateCategory($request);
        return Redirect::to('categories');
    }

    /*
     * Creates a new category if the request's data is successfully validated, otherwise it throws an error
     *
     * @param Request $request
     *
     * */
    private function createAndValidateCategory(Request $request): void
    {
        // After small investigation: when Request object tries to validate fields via a Validator created in $request->validate() macro, once the validation fails, it will throw a ValidationException that will then be handled by \Illuminate\Foundation\Exceptions\Handler and it will transform this exception into a redirect to the previous URL.

        $validator = Validator::make($request->all(), ['name' => 'required|string']);

        if ($validator->fails())
            throw new Exception('Failed to create category. Validation failed.');

        Category::create(['name' => $request->input('name')]);
    }

    /*
     * Deletes a category
     *
     * @param Request $request
     *
     * */
    public function delete(Request $request, string $id): RedirectResponse
    {
        $this->deleteCategory($id);
        return Redirect::to('categories');
    }

    /*
     * Deletes a category with the specified ID if it exists, otherwise it throws an error
     *
     * @param string $id - Category id
     *
     * */
    private function deleteCategory(string $id): void
    {
        $category = Category::where('id', $id);

        $category->exists()
            ? $category->delete()
            : throw new Exception('Failed to delete category. Category doesn\'t exist.');
    }
}
