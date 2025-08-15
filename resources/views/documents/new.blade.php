@extends('layouts.main')

@section('new-button')
  <x-buttons.create disabled>
  </x-buttons.create>
@endsection

@section('content')
  <!-- Can be transformed into an Arrow component -->
  <x-navigation.back-arrow to="{{ route('category', ['id' => $current_category->id])}}" class="mt-6" stroke="#FD7C4B"></x-navigation.back-arrow>

  <h2 class="mt-4 text-3xl font-comfortaa font-bold text-[#474747]"> Nouveau(x) Document </h2>

  <form class="flex flex-col pt-3" action="{{ route('documents.create') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input class="hidden" type="text" name="current-category-id" value="{{ $current_category->id }}">

    <div class="flex flex-col mb-4">
      <label class="text-lg font-inter font-light pb-1" for="documents">Document(s)</label>

      <button id="documents-btn" type="button" class="text-left text-sm px-2 py-1 font-inter rounded-sm bg-white text-black border border-[#CACACA]">Cliquez ici pour selectionner des fichiers</button>

      <input class="hidden" type="file" accept="image/png, image/jpeg, application/pdf" id="documents" name="documents[]" multiple required>
    </div>

    <!-- Container used when multiple files are uploaded  -->
    <div id="file-container">
    </div>

    <!-- Container used when a single file is uploaded  -->
    <div id="single-file-container">
      <div class="flex flex-col mb-4">
        <label class="text-lg font-inter font-light pb-1" for="name">Nom du document</label>
        <input class="text-md px-2 py-1 font-inter rounded-lg bg-white text-black border border-[#CACACA]" type="text" id="titles" name="titles[]" required>
      </div>

      <!-- Category selection -->
      <div class="flex flex-col">
        <label class="text-lg font-inter font-light pb-1" for="category">Catégorie</label>
        <select class="w-1/2 text-black bg-white rounded-lg p-2" name="categories[]" id="categories">
          @foreach($categories as $category)
            @if (!is_null($current_category) && $category->id == $current_category->id)
              <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
            @else
              <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endif
          @endforeach
        </select>
      </div>
    </div>

    <input class="mb-35 w-[45%] mt-6 text-lg px-2 py-1 font-inter rounded-xl bg-linear-to-r from-[#FD814A] to-[#FC5C4C] text-white" type="submit" name="submit" value="Créer">
  </form>

@endsection

@push('scripts')
  @vite('resources/js/document/upload.js')
@endpush
