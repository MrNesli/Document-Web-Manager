<div id="selection-dialog" class="bg-white rounded-2xl border-3 border-orange-400 px-6 py-3 flex flex-col justify-center items-center font-inter font-light z-15 fixed bottom-29 left-1/2 -translate-x-1/2">
  <h4 class="whitespace-nowrap">{{ $count }} Fichiers Selectionnés</h4>

  <div class="w-full flex justify-between text-sm">
    <button id="unselect-btn" class="text-red-600 cursor-pointer">Abandonner</button>

    <form action="{{ route('documents.options') }}" method="GET">
      @csrf
      <input class="hidden" type="text" name="selected_items" value="{{ $items }}">
      <button class="text-orange-500 cursor-pointer" type="submit">Options</button>
    </form>
  </div>
</div>
