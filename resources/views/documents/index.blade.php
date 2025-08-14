@extends('layouts.document_preview')

@section('content')
  <div class="relative w-full h-screen">

    <!-- Back arrow -->
    <x-navigation.back-arrow stroke="#FD7C4B" class="z-100 absolute mt-10 ml-2" to="{{ route('category', ['id' => $category->id]) }}" :query-params="['search_name' => $search_name]"></x-navigation.back-arrow>

    <!-- Image preview -->
    <div class="top-0 left-0 w-full h-screen absolute">
      <!-- Add blade condition based on file extension: -->
      <!-- If the file is pdf we use embed, if the file is an image we use canvas -->
      @if ($document->getFileType() == 'image')
        <img id="doc-image" class="hidden" src="{{ asset($document->file_path) }}">
        <canvas id="doc-canvas"></canvas>
      @elseif ($document->getFileType() == 'pdf')
        <embed class="w-full h-screen" src="{{ asset($document->file_path) }}" type="application/pdf">
      @else
        <div>
          Got {{ $document->getFileType() }} Type.
        </div>
      @endif
    </div>

    <!-- Collapsible document info block -->
    <x-document.info.collapsible :document="$document" :category="$category" class="info-block">
    </x-document.info.collapsible>
  </div>

@endsection

@if ($document->getFileType() == 'image')
  @push('scripts')
    @vite('resources/js/document/viewer.js')
  @endpush
@endif
