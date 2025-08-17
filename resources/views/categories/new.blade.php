@extends('layouts.main')

@section('new-button')
  <x-buttons.create disabled></x-buttons.create>
@endsection

@section('content')

  <x-navigation.back-arrow to="{{ route('categories') }}" class="mt-6" stroke="#FD7C4B"></x-navigation.back-arrow>

  <h2 class="mt-4 text-3xl md:text-center font-comfortaa font-bold text-[#474747]"> Nouvelle Catégorie </h2>

  <div class="flex md:justify-center">
    <form class="flex flex-col pt-3" action="{{ route('categories.new') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <!-- Category name -->
      <div class="flex flex-col mb-4">
        <label class="text-lg font-inter font-light pb-1" for="name">Nom</label>
        <input class="w-full text-lg px-2 py-1 font-inter rounded-lg bg-white text-black border border-[#CACACA]" type="text" name="name">
      </div>

      <!-- Image selection -->
      <div class="flex flex-col mb-4">
        <label class="text-lg font-inter font-light pb-1" for="image">Image d'affichage (Optionnel)</label>

        <button id="image-btn" type="button" class="w-full xxs:w-[350px] text-left text-sm px-2 py-1 font-inter rounded-sm bg-white text-black border border-[#CACACA]">Cliquez ici pour selectionner l'image</button>

        <input class="hidden" type="file" accept="image/png, image/jpeg" id="image" name="image">
      </div>

      <!-- Category description -->
      <div class="flex flex-col mb-4">
        <label class="text-lg font-inter font-light pb-1" for="description">Description (Optionnel)</label>
        <textarea class="w-full text-lg px-2 py-1 font-inter rounded-lg bg-white text-black border border-[#CACACA]" type="text" name="description"></textarea>
      </div>

      <div class="md:flex md:justify-center">
        <input class="cursor-pointer w-[45%] xs:w-[200px] mt-4 text-lg px-2 py-1 font-inter rounded-xl bg-linear-to-r from-cyan-500 to-blue-500 text-white" type="submit" name="submit" value="Créer">
      </div>
    </form>
  </div>
@endsection

@push('scripts')
  @vite('resources/js/category/create.js')
@endpush
