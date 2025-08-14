<div class="mb-5">
  <div data-file-id="{{ $index + 1 }}" class="file-btn w-fit flex items-center mb-2">
    <button class="font-bold text-lg mr-1" type="button">
      Fichier {{ $index + 1 }}
    </button>

    <svg class="dropdown-icon rotate-180" width="24" height="24">
      <path d="m17.657 16.243 1.414-1.414-7.07-7.072-7.072 7.072 1.414 1.414L12 10.586l5.657 5.657Z"/>
    </svg>
  </div>

  <div class="collapsible-block-{{ $index + 1 }} hidden border-t border-black">
    <div class="flex flex-col mb-4">
      <label class="text-lg font-inter font-light pb-1" for="name">Nom du document</label>
      <input class="text-md px-2 py-1 font-inter rounded-lg bg-white text-black border border-[#CACACA]" value="{{ $documentTitle }}" type="text" id="titles" name="titles[]" required>
    </div>

    <x-category.select name="categories[]" id="categories" current-category-id="{{ $categoryId }}"></x-category.select>
  </div>
</div>
