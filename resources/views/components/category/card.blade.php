<x-confirmation.dialog data-item-id="{{ $category->id }}" title="Vous êtes sur de vouloir supprimer cette catégorie?" route-on-confirm="{{ route('categories.delete', ['id' => $category->id])}}"> </x-confirmation.dialog>

<div {{ $attributes->merge(['class' => 'font-comfortaa flex flex-col items-center w-[80%] xs:w-[400px] md:w-[340px] lg:w-[310px]']) }} >
  <div class="w-full">
    <img class="rounded-tl-xl rounded-tr-xl w-full h-40" src="{{ $category->img_path ? asset($category->img_path) : "/images/mountain-landscape.jpg" }}">

    <div class="bg-white pb-5 rounded-bl-xl rounded-br-xl">
      <div class="flex justify-between items-center pt-3 px-2">
        <h4 class="overflow-hidden w-[80%] pl-2 text-lg"><a href="{{ route ('category', ['id' => $category->id]) }}">{{ $category->name }}</a></h4>

        <x-buttons.delete :item-id="$category->id"></x-buttons.delete>
      </div>
    </div>
  </div>
</div>
