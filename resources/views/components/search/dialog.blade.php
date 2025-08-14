<form id="search-dialog" class="hidden" method="GET">
  <div class="flex justify-center items-center z-100 fixed left-0 top-0 w-full h-screen bg-black/50">
    <div class="relative rounded-xl px-5 py-3 flex flex-col bg-white">
      <h3 class="font-comfortaa text-center">{{ $title }}</h3>
      <input class="font-inter px-4 my-2 border border-[#CACACA] rounded-xl focus:outline-none" type="text" name="search_name" value="{{ $searchName }}">

      <div class="flex justify-center">
        <button class="w-fit cursor-pointer rounded-lg px-8 py-1 text-white bg-linear-to-r from-[#FD814A] to-[#FC5C4C]" type="submit">Trouver</button>
      </div>

      <p id="close-button" class="absolute right-2 top-1 cursor-pointer"> &#x2715; </p>
    </div>
  </div>
</form>

@push('scripts')
  @vite('resources/js/search/dialog.js')
@endpush
