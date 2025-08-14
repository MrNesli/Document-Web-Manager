@extends('layouts.main')

@section('new-button')
  <x-buttons.create action="{{ route('documents.new') }}" method="POST">
    <input class="hidden" type="number" name="current_category_id" value="{{ $documents[0]->category_id }}" />
  </x-buttons.create>
@endsection

@section('content')
  <x-navigation.back-arrow to="{{ route('category', ['id' => $documents[0]->category_id])}}" class="mt-6" stroke="#FD7C4B"></x-navigation.back-arrow>

  <h2 class="mt-4 text-3xl font-comfortaa font-bold text-[#474747]"> Documents selectionnés </h2>

  <div class="border-t mt-3 pt-3 border-b mb-3 pb-3">
    <div class="w-1/2 flex flex-col">
      <ul class="list-disc">
        @foreach($documents as $document)
          <li class="whitespace-nowrap overflow-hidden overflow-ellipsis font-inter pl-4 text-lg font-bold">{{ $document->title }} </li>
        @endforeach
      </ul>
    </div>
  </div>

  <form class="mb-28" id="selection-form" action="{{ route('documents.options.apply') }}" method="POST">
    @csrf
    <input class="hidden" type="text" name="selected_items" value="{{ $selected_items }}">

    <div class="flex items-center">
      <input id="new-category" type="checkbox" name="new-category">
      <label class="pl-1 text-gray-500" for="new-category">Changer la catégorie</label>
    </div>

    <!-- Category selection -->
    <x-category.select class="hidden my-2" id="category" name="category" current-category-id="{{ $documents[0]->category_id }}"></x-category.select>

    <div class="flex items-center">
      <input id="download-zip" type="checkbox" name="download-zip">
      <label class="pl-1 text-gray-500" for="download-zip">Exporter le tout en fichier ZIP</label>
    </div>

    <div class="flex items-center">
      <input id="delete-all" type="checkbox" name="delete-all">
      <label class="pl-1 text-gray-500" for="delete-all">Supprimer</label>
    </div>

    <button class="cursor-pointer rounded-lg px-4 mt-3 py-1 text-white bg-linear-to-r from-[#FD814A] to-[#FC5C4C]" type="submit">Confirmer</button>
  </form>

@endsection

@push('scripts')
  @vite('resources/js/selection-options.js')
@endpush
