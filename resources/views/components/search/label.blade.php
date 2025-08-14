  @if (!empty($searchName))
    <div {{ $attributes->merge(['class' => 'flex items-center font-comfortaa font-bold text-sm text-[#979EA6]']) }}>
      <p class="pr-4">
        Recherche: <span class="text-black">{{ $searchName }}</span>
      </p>

      <form action="{{ $onClearAction }}" method="GET">
        <input class="cursor-pointer text-red-500 underline" type="submit" value="Supprimer">
      </form>
    </div>
  @endif
