<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Document;
use Exception;
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
use ZipArchive;

class DocumentController extends Controller
{

    public function documentView(Request $request, string $id): View | string
    {
        if (!($document = Document::find($id))) return 'Document not found';

        return view('documents.index', $this->getDocumentViewData($request, $document));
    }

    private function getDocumentViewData(Request $request, Document $document)
    {
        $data['document'] = $document;
        $data['category'] = Category::find($document->category_id);
        $data['search_name'] = $request->input('search_name');

        return $data;
    }

    private function getCreateDocumentViewData(Request $request)
    {
        $validated = $request->validate(['current_category_id' => 'integer']);

        $data['categories'] = Category::all();

        if ($current_category_id = $request->integer('current_category_id'))
        {
            if ($current_category = Category::find($current_category_id))
            {
                $data['current_category'] = $current_category;
            }
        }

        return $data;
    }

    public function createView(Request $request): View | string
    {
        return view('documents.new', $this->getCreateDocumentViewData($request));
    }

    private function getDocumentsFromSelectedItems(Request $request)
    {
        // Will it stop the execution of the parent function that's calling this one
        $validated = $request->validate(['selected_items' => 'string|required']);
        return $this->getDocumentsFromSelectedItemsString($request);
    }

    private function getDocumentsFromSelectedItemsString(Request $request): Collection | null
    {
        $selected_items = $request->input('selected_items');
        $document_ids = $this->getDocumentIdsFromString($selected_items);
        $documents = Document::whereIn('id', $document_ids)->get();

        if (count($document_ids) != $documents->count())
            throw new Exception('Bad document IDs were given');

        return $documents;
    }

    private function getDocumentIdsFromString($string)
    {
        // "1,2,3,4,5" => [1, 2, 3, 4, 5]
        return array_map(fn ($value) => (int) $value, explode(',', $string));
    }

    public function selectionOptions(Request $request)
    {
        $documents = $this->getDocumentsFromSelectedItems($request);
        $categories = Category::all();
        $selected_items = $request->input('selected_items');

        return view('documents.selection-options', [
            'selected_items' => $selected_items,
            'documents' => $documents,
            'categories' => $categories,
        ]);
    }

    private function generateUniqueFileName(UploadedFile $file)
    {
        return uniqid() . '.' . $file->getClientOriginalExtension();
    }

    private function saveDocument(UploadedFile $file)
    {
        $path = "documents/{$this->generateUniqueFileName($file)}";
        while (Document::where('file_path', $path)->exists())
        {
            $path = "documents/{$this->generateUniqueFileName($file)}";
        }

        // Saving document to the public storage
        $this->publicStorage()->put($path, File::get($file->getRealPath()));

        return ['file_path' => $path];
    }

    private function localStorage(): FileSystem
    {
        return Storage::disk('local');
    }

    private function publicStorage(): FileSystem
    {
        return Storage::disk('public');
    }

    private function downloadZipFromDocuments(Collection $documents)
    {
        $zip = new ZipArchive;
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

        session(['download-zip' => 'true']);
    }

    public function applyOptionsToSelection(Request $request)
    {
        $validated = $request->validate([
            'selected_items' => 'required|string',
            'new-category' => 'string|nullable',
            'category' => 'integer|nullable',
            'download-zip' => 'string|nullable',
            'delete-all' => 'string|nullable',
        ]);

        $selected_items = $request->input('selected_items');
        $new_category = $request->input('new-category');
        $category_id = $request->integer('category');
        $download_zip = $request->input('download-zip');
        $delete_all = $request->input('delete-all');

        $documentIds = $this->getDocumentIdsFromString($selected_items);
        $documents = Document::whereIn('id', $documentIds);

        if ($documents->count() == 0) return 'Selected documents weren\'t found';

        // Export to zip file checkbox checked
        if ($download_zip == 'on')
        {
            $this->downloadZipFromDocuments($documents->get());
        }

        // New category checkbox checked
        if ($new_category == 'on')
        {
            $documents->update(['category_id' => $category_id]);
        }
        // Delete documents checkbox checked
        // Deleting documents at the end so we can create a zip file before
        else if ($delete_all == 'on')
        {
            $documents->delete();
        }

        return Redirect::to('categories');
    }

    public function downloadZip()
    {
        if (session()->get('download-zip') == 'true')
        {
            session()->forget('download-zip');
            return response()->download(Storage::disk('local')->path('documents.zip'));
        }

        return Redirect::back();
    }


    public function create(Request $request)
    {
        $validated = $request->validate([
            'documents.*' => 'required|mimes:jpg,jpeg,png,pdf|min:1',
            'titles.*' => 'required|string|min:1',
            'categories.*' => 'required|integer|min:1',
        ]);

        $documents = $request->files->get('documents');
        $titles = $request->input('titles');
        $category_ids = $request->input('categories');

        if (count($documents) != count($titles) ||
            count($titles) != count($category_ids))
            return "Arrays must be equal";

        for ($i = 0; $i < count($documents); $i++)
        {
            $category_id = $category_ids[$i];
            $title = $titles[$i];
            $file = $documents[$i];

            $file_path = $this->saveDocument($file)['file_path'];

            Document::create([
                'file_path' => $file_path,
                'title' => $title,
                'category_id' => $category_id,
            ]);
        }

        return Redirect::to(route('category', ['id' => $category_id]));
    }

    public function modify(Request $request, string $id)
    {
        $validated = $request->validate([
            'new-document' => 'mimes:jpg,jpeg,png,pdf',
            'new-title' => 'string',
            'new-category' => 'integer',
        ]);

        $document = Document::where('id', $id);

        if (!$document->exists()) return 'Document doesn\'t exist';

        if ($request->has('new-document'))
        {
            // Deleting previous document
            $this->publicStorage()->delete($document->first()->file_path);
            $new_file = $request->file('new-document');
            $new_file_path = $this->saveDocument($new_file)['file_path'];
            $document->update(['file_path' => $new_file_path]);
        }

        if ($request->has('new-title'))
        {
            $new_title = $request->input('new-title');
            $document->update(['title' => $new_title]);
        }

        if ($request->has('new-category'))
        {
            $new_category_id = $request->integer('new-category');
            $document->update(['category_id' => $new_category_id]);
        }

        return Redirect::back();
    }

    public function delete(Request $request, string $id)
    {
        // TODO: Delete document file
        $document = Document::where('id', $id);
        if ($document->exists())
        {
            $category_id = $document->first()->category_id;
            $document->delete();
            return Redirect::to(route('category', ['id' => $category_id]));
        }

        return 'Document doesn\'t exist';
    }

    public function download(Request $request, string $id)
    {
        $document = Document::where('id', $id);
        if ($document->exists())
        {
            [$document_path, $document_name] = [$document->first()->file_path, $document->first()->title];
            return response()->download($this->publicStorage()->path($document_path), $document_name);
        }

        return 'Document doesn\'t exist';
    }
}
