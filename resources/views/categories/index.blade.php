@extends('layouts.main')

@section('new-button')
  <x-buttons.create method="GET" action="{{ route('categories.new') }}"></x-buttons.create>
@endsection

@section('head')
  @if (session()->get('download-zip') == 'true')
    <meta http-equiv="refresh" content="0;url={{ route('documents.download-zip') }}" />
  @endif
@endsection

@section('content')
  <x-confirmation.dialog title="Vous êtes sur de vouloir supprimer cette catégorie?" route-on-confirm="{{ route('categories.delete', ['id' => 1]) }}"> </x-confirmation.dialog>
  <x-search.dialog title="Rechercher une catégorie" search-name="{{ $data['search_name'] }}"></x-search.dialog>

  <div class="mt-6 flex justify-between items-center">
    <x-navigation.back-arrow to='' class="mt-6 mb-2" stroke="#FD7C4B"></x-navigation.back-arrow>

    <x-pagination redirect-to="{{ route('categories') }}" :pagination-data="$data"></x-pagination>
  </div>

  <!-- Component Heading -->
  <h2 class="text-3xl font-comfortaa font-bold text-[#474747] xs:text-center xs:text-4xl"> Catégories </h2>

  <!-- Component Description -->
  <p class="mt-2 font-comfortaa font-bold text-sm text-[#979EA6] xs:text-center md:text-lg">Ici vous allez pouvoir créer les catégories ou consulter les documents dans les catégories existantes</p>

  <x-search.label class="mt-4 " search-name="{{ $data['search_name'] }}" on-clear-action="{{ route('categories') }}"></x-search.label>

  <!-- TODO: Add Container component for responsiveness with grid  -->
  <div class="flex justify-center">
    <div class="mt-14 mb-30 flex flex-col items-center md:flex-none md:grid md:grid-cols-2 lg:grid-cols-3 md:gap-8">
      @if (count($data['items']) > 0)
        @php
            $categories = $data['items'];
        @endphp

        @foreach($categories as $category)
          <x-category.card class="mt-4 md:m-0" :category="$category">
          </x-category.card>
        @endforeach
      @endif
    </div>
  </div>
@endsection
