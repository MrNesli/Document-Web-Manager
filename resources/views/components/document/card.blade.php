@php
  // Document fields
  $file_path = asset($document->file_path);
  $file_type = $document->getFileType();
  $title = $document->title;
  $id = $document->id;
@endphp

<div {{ $attributes->merge(['class' => 'font-comfortaa w-[320px] sm:w-[300px]']) }}>
  <div class="relative">
    <div class="absolute left-1 top-1">
      <!-- Selection button -->
      <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
        <circle class="selection-btn" data-selected="false" data-document-id="{{ $id }}" cx="10" cy="10" r="9" fill="white"/>
      </svg>
    </div>

    <div class="px-6 pt-6 bg-gray-300 rounded-tr-xl rounded-tl-xl">
      @if ($file_type == 'image')
        <img src="{{ $file_path }}" class="bg-cover bg-no-repeat w-full h-50 rounded-tr-xl rounded-tl-xl" />
      @elseif ($file_type == 'pdf')
        <iframe src="{{ $file_path }}#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" class="border-none w-full h-50 rounded-tr-xl rounded-tl-xl"></iframe>
      @else
        <div class="bg-gray-300 w-full h-50 rounded-tr-xl rounded-tl-xl"></div>
      @endif
    </div>

    <h4 class="overflow-hidden overflow-ellipsis ellipsis font-inter bg-white px-2 pb-4 pt-1 text-sm text-blue-600 rounded-br-xl rounded-bl-xl font-bold ">
      <a href="{{ route('document', array_merge(['id' => $id], $params)) }}">{{ $title }}</a>
    </h4>
  </div>
</div>
