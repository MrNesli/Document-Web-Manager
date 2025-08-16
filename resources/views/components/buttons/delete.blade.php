{{-- In this delete button we only have the icon.
     Actual deletion happens inside of a confirmation dialog. --}}

<div>
  @isset($itemId)
    {{-- We merge attributes so that the icon can merge the attributes passed to this button --}}
    <x-icons.delete {{ $attributes->merge(['data-item-id' => $itemId])}} ></x-icons.delete>
  @else
    <x-icons.delete {{ $attributes->merge(['data-item-id' => ''])}}></x-icons.delete>
  @endisset
</div>

@pushOnce('scripts')
  @vite('resources/js/buttons/delete.js')
@endPushOnce
