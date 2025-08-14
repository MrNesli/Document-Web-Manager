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
  <x-search.dialog title="Rechercher une catégorie" search-name="{{ $data['search_name'] }}"></x-search.dialog>

  <div class="mt-6 flex justify-between items-center">
    <x-navigation.back-arrow to='' class="mt-6 mb-2" stroke="#FD7C4B"></x-navigation.back-arrow>

    <x-pagination redirect-to="{{ route('categories') }}" :pagination-data="$data"></x-pagination>
  </div>

  <!-- Component Heading -->
  <h2 class="text-3xl font-comfortaa font-bold text-[#474747]"> Catégories </h2>

  <!-- Component Description -->
  <p class="mt-2 font-comfortaa font-bold text-sm text-[#979EA6]">Ici vous allez pouvoir créer les catégories ou consulter les documents dans les catégories existantes</p>

  <x-search.label class="mt-4 " search-name="{{ $data['search_name'] }}" on-clear-action="{{ route('categories') }}"></x-search.label>

  <!-- TODO: Add Container component for responsiveness with grid  -->
  @if (count($data['items']) > 0)
    @php
        $categories = $data['items'];
    @endphp

    @for ($i = 0; $i < count($categories); $i++)
      @php
        $first = ($i == 0);
        $last = ($i == (count($categories) - 1));
      @endphp

      <x-category.card @class([
        'mt-14' => $first,
        'mt-4' => !$first && !$last,
        'mt-4 mb-30' => $last,
      ]) title="{{ $categories[$i]->name }}" id="{{ $categories[$i]->id }}" imgsrc="/images/mountain-landscape.jpg">
      </x-category.card>
    @endfor
  @endif
@endsection
