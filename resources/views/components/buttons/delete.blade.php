<form action="{{ $deleteAction }}" method="GET">
  @csrf
  <button {{ $attributes->merge(['class' => 'cursor-pointer']) }} type="submit">
    <x-icons.delete></x-icons.delete>
  </button>
</form>
