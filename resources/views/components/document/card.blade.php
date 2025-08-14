<div {{ $attributes->merge(['class' => 'font-comfortaa']) }}>
  <div class="relative">
    <div class="absolute left-1 top-1">
      <!-- Selection button -->
      <svg width="18" height="18" viewBox="0 0 20 20" fill="none">
        <circle class="selection-btn" data-selected="false" data-document-id="{{ $id }}" cx="10" cy="10" r="9" fill="white"/>
      </svg>
    </div>

    <div class="px-6 pt-6 bg-gray-300 rounded-tr-xl rounded-tl-xl">
      @if ($fileType == 'image')
        <img src="{{ $fileSrc }}" class="bg-cover bg-no-repeat w-full h-50 rounded-tr-xl rounded-tl-xl" />
      @elseif ($fileType == 'pdf')
        <iframe src="{{ $fileSrc }}#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" class="border-none w-full h-50 rounded-tr-xl rounded-tl-xl"></iframe>
      @else
        <div class="bg-gray-300 w-full h-50 rounded-tr-xl rounded-tl-xl"></div>
      @endif
    </div>

    <h4 class="overflow-hidden overflow-ellipsis ellipsis font-inter bg-white px-2 pb-4 pt-1 text-sm text-blue-600 rounded-br-xl rounded-bl-xl font-bold ">
      <a href="{{ route('document', array_merge(['id' => $id], $params)) }}">{{ $title }}</a>
    </h4>
  </div>
</div>
