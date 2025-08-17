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

  <!-- Category name -->
  <h2 class="mt-4 mb-2 text-3xl font-comfortaa font-bold text-[#474747] xs:text-center sm:text-4xl lg:text-5xl"> {{ $category->name }} </h2>

  <!-- Category description -->
  <p class="mt-4 font-comfortaa font-bold text-sm text-[#979EA6] xs:text-center md:text-lg">{{ $category->description }}</p>

  <x-search.label search-name="{{ $data['search_name'] }}" on-clear-action="{{ route('category', ['id' => $category->id]) }}"></x-search.label>


  <!-- TODO: Add files recently viewed section -->

  <div class="flex justify-center">
    <div class="mt-14 mb-30 flex flex-col items-center md:flex-none sm:grid sm:grid-cols-2 sm:gap-6 lg:grid-cols-3 2xl:grid-cols-4">
      @if (count($data['items']) > 0)
        @php
          $documents = $data['items'];
        @endphp

        @foreach($documents as $document)
          <x-document.card class="mt-4 sm:mt-0" :document="$document" :params="['search_name' => $data['search_name']]">
          </x-document.card>
        @endforeach
      @endif
    </div>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/document/selection.js')
@endpush
