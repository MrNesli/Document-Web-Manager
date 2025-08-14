<div {{ $attributes->merge(['class' => '']) }}>
  <form action="{{ $to }}" method="GET">
    @isset ($queryParams)
      @foreach($queryParams as $param => $value)
        @if (!empty($value))
          <input class="hidden" type="text" name="{{ $param }}" value="{{ $value }}">
        @endif
      @endforeach
    @endisset
    <svg class="cursor-pointer arrow-btn inline" width="14" height="22" viewBox="0 0 14 22" fill="none">
      <path d="M12 2L2 11L12 20" stroke="{{ $stroke }}" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </form>
</div>

@push('scripts')
  @vite('resources/js/navigation/back-arrow.js')
@endpush
