<div {{ $attributes->merge(['class' => 'font-comfortaa flex flex-col items-center w-[90%] xs:w-[400px] md:w-[340px] lg:w-[310px]']) }} >
  <div>
    <img class="rounded-tl-xl rounded-tr-xl w-full" src="/images/mountain-landscape.jpg">

    <div class="bg-white pb-5 rounded-bl-xl rounded-br-xl">
      <div class="flex justify-between items-center pt-3 px-2">
        <h4 class="pl-2 text-lg"><a href="{{ route ('category', ['id' => $category->id]) }}">{{ $category->name }}</a></h4>

        <x-buttons.delete delete-action="{{ route('categories.delete', ['id' => $category->id])}}"></x-buttons.delete>
      </div>
    </div>
  </div>
</div>
