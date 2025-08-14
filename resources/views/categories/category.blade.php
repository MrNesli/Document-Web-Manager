@extends('layouts.main')

@section('new-button')
  <x-buttons.create action="{{ route('documents.new') }}" method="POST">
    <input class="hidden" type="number" name="current_category_id" value="{{ $category->id }}" />
  </x-buttons.create>
@endsection


@section('content')
  <x-search.dialog title="Rechercher un document" search-name="{{ $data['search_name'] }}"></x-search.dialog>


  <div class="mt-6 flex justify-between items-center">
    <x-navigation.back-arrow stroke="#FD7C4B" to="{{ route('categories') }}"></x-navigation.back-arrow>

    <x-pagination redirect-to="{{ route('category', ['id' => $category->id]) }}" :pagination-data="$data" :category="$category"></x-pagination>
  </div>

  <h2 class="mt-4 mb-2 text-3xl font-comfortaa font-bold text-[#474747]"> {{ $category->name }} </h2>

  <x-search.label search-name="{{ $data['search_name'] }}" on-clear-action="{{ route('category', ['id' => $category->id]) }}"></x-search.label>


  <!-- TODO: Add files recently viewed section -->

  <!-- TODO: Add a document container -->
  @if (count($data['items']) > 0)
    @php
      $documents = $data['items'];
    @endphp
    @for ($i = 0; $i < count($documents); $i++)
      @php
        $first = ($i == 0);
        $last = ($i == (count($documents) - 1));

        $file_path = asset($documents[$i]->file_path);
        $file_type = $documents[$i]->getFileType();
        $title = $documents[$i]->title;
        $id = $documents[$i]->id;
      @endphp

      <x-document.card @class([
        'mt-14' => $first,
        'mt-4' => !$first && !$last,
        'mt-4 mb-30' => $last,
      ]) file-src="{{ $file_path }}" file-type="{{ $file_type }}" title="{{ $title }}" id="{{ $id }}" :params="['search_name' => $data['search_name']]">
      </x-document.card>
    @endfor
  @endif
@endsection

@push('scripts')
  @vite('resources/js/document/selection.js')
@endpush
