<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateDocumentRequest;
use App\Http\Requests\SelectionOptionsRequest;
use App\Http\Requests\ModifyDocumentRequest;
use App\Models\Category;
use App\Models\Document;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class DocumentController extends Controller
{

    /*
     * Single document view
     *
     * @param Request $request
     * @param string $id
     *
     * @return View
     *
     * */
    public function documentView(Request $request, string $id): View
    {
        if (!($document = Document::find($id)))
            throw new Exception('Document doesn\'t exist');

        return view('documents.index', $this->getDocumentViewData($request, $document));
    }

    /*
     * Document creation view
     *
     * @param Request $request
     *
     * @return View
     *
     * */
    public function createView(Request $request): View
    {
        return view('documents.new', $this->getCreateDocumentViewData($request));
    }

    /*
     * A view with a list of actions you can perform on selected documents
     *
     * @param Request $request
     *
     * @return View
     *
     * */
    public function selectionOptionsView(Request $request): View
    {
        return view('documents.selection-options', $this->getSelectionOptionsViewData($request));
    }

    /*
     * Returns single document view's data
     *
     * @param Request $request
     * @param Document $document
     *
     * @return array
     *
     * */
    private function getDocumentViewData(Request $request, Document $document): array
    {
        $data['document'] = $document;
        $data['category'] = Category::find($document->category_id);
        $data['search_name'] = $request->input('search_name');

        return $data;
    }

    /*
     * Returns document creation view's data
     *
     * @param Request $request
     *
     * @return array
     *
     * */
    private function getCreateDocumentViewData(Request $request): array
    {
        $validated = $request->validate(['current_category_id' => 'integer']);

        $data['categories'] = Category::all();

        if ($data['categories']->count() == 0)
            throw new Exception('Cant create a document. No categories found.');

        if ($current_category_id = $request->integer('current_category_id'))
        {
            if ($current_category = Category::find($current_category_id))
            {
                $data['current_category'] = $current_category;
            }
        }

        // If data['current_category'] is null then it will assign the first category to it
        // Null coalescing assignement operator
        $data['current_category'] ??= Category::first();

        return $data;
    }

    /*
     * Returns "selected documents options" view's data
     *
     * @param Request $request
     *
     * @return array
     *
     * */
    private function getSelectionOptionsViewData(Request $request): array
    {
        $data['documents'] = $this->getDocumentsFromSelectedItems($request);
        $data['categories'] = Category::all();
        $data['selected_items'] = $request->input('selected_items');

        return $data;
    }

    /*
     * Validates request and returns selected documents
     *
     * @param Request $request
     *
     * @return array
     *
     * */
    private function getDocumentsFromSelectedItems(Request $request): Collection
    {
        // Will it stop the execution of the parent function that's calling this one
        $validated = $request->validate(['selected_items' => 'string|required']);
        return $this->getDocumentsFromSelectedItemsString($request);
    }

    /*
     * Parses 'selected_items' request parameter, retrieves documents, and returns them
     *
     * @param Request $request
     *
     * @return Collection
     *
     * */
    private function getDocumentsFromSelectedItemsString(Request $request): Collection
    {
        // NOTE: Testable
        $selected_items = $request->input('selected_items');
        $document_ids = $this->getDocumentIdsFromString($selected_items);
        $documents = Document::whereIn('id', $document_ids)->get();

        if (count($document_ids) != $documents->count())
            throw new Exception('Bad document IDs were given');

        return $documents;
    }

    /*
     * Turns selected items string into an array of integers
     *
     * @param Request $request
     *
     * @return array
     *
     * */
    private function getDocumentIdsFromString($string): array
    {
        // "1,2,3,4,5" => [1, 2, 3, 4, 5]
        return array_map(fn ($value) => (int) $value, explode(',', $string));
    }

    /*
     * Shortcut for local (storage/app/private) disk
     *
     * @return FileSystem
     *
     * */
    private function localStorage(): FileSystem
    {
        return Storage::disk('local');
    }

    /*
     * Shortcut for public (storage/app/public) disk
     *
     * @return FileSystem
     *
     * */
    private function publicStorage(): FileSystem
    {
        return Storage::disk('public');
    }

    /*
     * Creates a new zip file out of a collection of documents
     *
     * */
    private function createZipFromDocuments(Collection $documents): void
    {
        $zip = new ZipArchive();
        $zip_name = 'documents.zip';
        $zip_path = $this->localStorage()->path($zip_name);

        // If zip file exists already, delete it
        if ($this->localStorage()->exists($zip_name))
        {
            $this->localStorage()->delete($zip_name);
        }

        // Open zip file, append files, close zip file
        if ($zip->open($zip_path, ZipArchive::CREATE))
        {
            foreach ($documents as $document)
            {
                $full_path = $this->publicStorage()->path($document->file_path);
                $zip->addFile($full_path, $document->title);
            }

            $zip->close();
        }

        // Session field that will trigger zip file download using <meta> tag
        session(['download-zip' => 'true']);
    }

    /*
     * Applies selected actions to a selected list of documents
     *
     * @param SelectionOptionsRequest $request
     *
     * @return RedirectResponse
     *
     * */
    public function applyOptionsToSelection(SelectionOptionsRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $new_category = $validated['new-category'];
        $category_id = $validated['category'] ?? '';
        $download_zip = $validated['download-zip'] ?? '';
        $delete_all = $validated['delete-all'] ?? '';

        $documents = $this->getDocumentsFromSelectedItemsString($request);

        // Export to zip file checkbox checked
        if ($download_zip == 'on')
        {
            $this->createZipFromDocuments($documents);
        }

        // New category checkbox checked
        if ($new_category == 'on')
        {
            $documents->each(fn (Document $doc) => $doc->updateCategory($category_id));
        }
        // Delete documents checkbox checked
        // Deleting documents at the end so we can create a zip file before
        else if ($delete_all == 'on')
        {
            $documents->delete();
        }

        return Redirect::to('categories');
    }

    /*
     * Downloads "documents.zip" file
     *
     * @return RedirectResponse
     *
     * */
    public function downloadZip(): RedirectResponse
    {
        if (session()->get('download-zip') == 'true')
        {
            session()->forget('download-zip');
            return response()->download($this->localStorage()->path('documents.zip'));
        }

        return Redirect::back();
    }

    /*
     * Creates documents from the validated data
     *
     * @param array $validated - request's validated fields
     *
     * */
    private function createDocuments(array $validated): void
    {
        $documents = $validated['documents'];
        $titles = $validated['titles'];
        $category_ids = $validated['categories'];

        if (count($documents) != count($titles) ||
            count($titles) != count($category_ids))
            throw new Exception('Arrays must be equal');

        for ($i = 0; $i < count($documents); $i++)
        {
            $category_id = $category_ids[$i];
            $title = $titles[$i];
            $file_path = \App\Facades\Document::save($documents[$i]);

            Document::create([
                'file_path' => $file_path,
                'title' => $title,
                'category_id' => $category_id,
            ]);
        }
    }

    /*
     * Creates new documents
     *
     * @param CreateDocumentRequest $request
     *
     * @return RedirectResponse
     *
     * */
    public function create(CreateDocumentRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $this->createDocuments($validated);
        $current_category_id = $validated['current-category-id'];

        return Redirect::to(route('category', ['id' => $current_category_id]));
    }

    /*
     * Modifies an existing document
     *
     * @param ModifyDocumentRequest $request
     * @param string $id
     *
     * @return RedirectResponse
     *
     * */
    public function modify(ModifyDocumentRequest $request, string $id)
    {
        $validated = $request->validated();

        if (!($document = Document::find($id)))
            throw new Exception('Document doesn\'t exist');

        $document->updateFile($validated['new-document'] ?? null);
        $document->updateTitle($validated['new-title'] ?? null);
        $document->updateCategory($validated['new-category'] ?? null);

        return Redirect::back();
    }

    /*
     * Deletes an existing document
     *
     * @param Request $request
     * @param string $id
     *
     * @return RedirectResponse
     *
     * */
    public function delete(Request $request, string $id)
    {
        if (!($document = Document::find($id)))
            throw new Exception('Document doesn\'t exist');

        $category_id = $document->category_id;
        $document->delete();

        return Redirect::to(route('category', ['id' => $category_id]));
    }

    /*
     * Downloads an existing document
     *
     * @param Request $request
     * @param string $id
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     *
     * */
    public function download(Request $request, string $id): BinaryFileResponse
    {
        if (!($document = Document::find($id)))
            throw new Exception('Document doesn\'t exist');

        $document_path = $this->publicStorage()->path($document->file_path);
        $document_title = $document->title;

        return response()->download($document_path, $document_title);
    }
}
