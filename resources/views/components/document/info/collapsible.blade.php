@php
    // This is a category that's passed down as view data
    $current_category = $category;
@endphp

<div {{ $attributes->merge(['class' => 'z-10 absolute bottom-0 w-full h-20']) }}>
  <x-document.info.button></x-document.info.button>

  <div class="absolute w-full h-full bg-white bottom-0 rounded-tl-4xl rounded-tr-4xl overflow-y-hidden">
    <!-- Info block container -->
    <div class="w-[70%] mx-auto">
      <!-- Category label -->
      <div class="h-25 flex flex-col items-center justify-center">
        <div class="flex">
          <!-- Pencil -->
          <x-icons.modify id="modify-btn"></x-icons.modify>

          <h4 class="pl-2 font-inter text-[#999999]">{{ $category->name }}</h4>
        </div>

        <p class="modif-label hidden text-center font-inter text-[#999999]">
          (En modification)
        </p>
      </div>

      <!-- Document Preview/Modification form -->
      <form action="{{ route('documents.modify', ['id' => $document->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- info-container -->
        <x-document.info.container>
          <!-- info-field -->
          <x-document.info.field label="Document">
            <!-- Textarea with auto-resizing -->
            <textarea rows="1" maxlength="120" id="new-title" name="new-title" class="w-full h-6 resize-none shadow-none border-none outline-none overflow-y-hidden" disabled>{{ $document->title }}</textarea>
          </x-document.info.field>

          <x-document.info.field label="Fichier">
            <div class="flex items-end">
              <p class="filename pr-2">{{ $document->getFileName() }}</p>
              <!-- Upload svg -->
              <x-icons.upload id="upload-btn" class="hidden">
              </x-icons.upload>

              <input id="doc-file" class="hidden" type="file" name="new-document">
            </div>
          </x-document.info.field>

          @if ($document->getFileType() == 'image')
            <x-document.info.field label="Dimensions">
              <p> {{ $document->getFileSize() }}</p>
            </x-document.info.field>
          @elseif ($document->getFileType() == 'pdf')
            <x-document.info.field label="Taille">
              <p> {{ $document->getFileSize() }}</p>
            </x-document.info.field>
          @endif

          <!-- This category select block differs quite a bit from categorySelect component so I'm leaving it at that for now. -->
          <x-document.info.field id="new-category" class="hidden" label="Nouvelle catégorie">
            <select class="px-4 py-2 bg-gray-100 rounded-md" name="new-category">
              @foreach ($categories as $category)
                @if ($category->name == $current_category->name)
                  <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                @else
                  <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endif
              @endforeach
            </select>
          </x-document.info.field>
        </x-document.info.container>

        <div id="edit-btns" class="flex mt-4 hidden">
          <button class="cursor-pointer rounded-lg px-4 mr-2 py-1 text-white bg-linear-to-r from-[#FD814A] to-[#FC5C4C]" type="submit">Sauvegarder</button>
          <button id="cancel-btn" class="cursor-pointer rounded-lg px-4 py-1 text-white bg-red-500" type="button">Abandonner</button>
        </div>
      </form>

      <!-- Replace those by save and cancel buttons -->
      <div id="action-btns" class="flex mt-4">
        <!-- document.delete-button -->
        <x-buttons.delete class="mr-4" delete-action="{{ route('documents.delete', ['id' => $document->id]) }}"></x-buttons.delete>

        <!-- document.download-button -->
        <x-buttons.download id="{{ $document->id }}"></x-buttons.download>
      </div>
    </div>
  </div>
</div>

@push('scripts')
  @vite('resources/js/document/collapsible-info.js')
@endpush
