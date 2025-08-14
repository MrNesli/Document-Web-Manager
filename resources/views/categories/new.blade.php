@extends('layouts.main')

@section('new-button')
  <x-buttons.create disabled></x-buttons.create>
@endsection

@section('content')

  <x-navigation.back-arrow to="{{ route('categories') }}" class="mt-6" stroke="#FD7C4B"></x-navigation.back-arrow>

  <h2 class="mt-4 text-3xl font-comfortaa font-bold text-[#474747]"> Nouvelle Catégorie </h2>

  <form class="flex flex-col pt-3" action="{{ route('categories.new') }}" method="POST">
    @csrf
    <input class="text-lg px-2 py-1 font-inter rounded-lg bg-white text-black border border-[#CACACA]" type="text" name="name">

    <input class="cursor-pointer w-[45%] mt-4 text-lg px-2 py-1 font-inter rounded-xl bg-linear-to-r from-cyan-500 to-blue-500 text-white" type="submit" name="submit" value="Créer">
  </form>


@endsection
