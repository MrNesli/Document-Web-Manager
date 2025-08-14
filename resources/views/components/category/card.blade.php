<div {{ $attributes->merge(['class' => 'font-comfortaa']) }} >
  <div>
    <img class="rounded-tl-xl rounded-tr-xl" src="{{ $imgsrc }}">

    <div class="bg-white pb-5 rounded-bl-xl rounded-br-xl">
      <div class="flex justify-between items-center pt-3 px-2">
        <h4 class="pl-2 text-lg"><a href="{{ route ('category', ['id' => $id]) }}">{{ $title }}</a></h4>

        <x-buttons.delete delete-action="{{ route('categories.delete', ['id' => $id])}}"></x-buttons.delete>
      </div>
    </div>
  </div>
</div>
