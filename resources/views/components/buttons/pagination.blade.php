@php

$isActive = $attributes->has('active');

@endphp

<form @class([
  'rounded-md mr-6 px-3 py-1 font-bold text-white',
  'bg-orange-500' => $isActive,
  'bg-amber-400' => !$isActive,
  ]) action="{{ $route }}" method="GET">

  <button class="cursor-pointer" type="submit"> {{ $page }} </button>

  @foreach($queryParams as $param => $value)
    @if (!empty($value))
      <input class="hidden" type="text" name="{{ $param }}" value="{{ $value }}">
    @endif
  @endforeach
</form>
