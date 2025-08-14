@php
  $disabled = $attributes->has('disabled');
  $btn_color = $disabled ? "#989A9D" : "url(#paint0_linear_3_190)";
@endphp

<form action="{{ $action }}" method="{{ $method }}">
  @csrf

  {{ $slot }}

  <svg class="z-15 absolute" viewBox="0 0 80 80" width="80" height="80" fill="orange" style="bottom: 32px; left: 144px;">
    <g filter="url(#filter0_d_3_190)">
      <rect @class(['cursor-pointer' => !$disabled]) id="new-button" x="4" width="64" height="64" rx="32" fill="{{ $btn_color }}"></rect>
    </g>

    <path class="pointer-events-none" d="M25.3333 32H46.6667" stroke="white" stroke-width="3" stroke-linecap="round"></path>
    <path class="pointer-events-none" d="M36 21.3334L36 42.6667" stroke="white" stroke-width="3" stroke-linecap="round"></path>

    <defs>
      <filter id="filter0_d_3_190" x="0" y="0" width="72" height="72" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
        <feFlood flood-opacity="0" result="BackgroundImageFix"></feFlood>
        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"></feColorMatrix>
        <feOffset dy="4"></feOffset>
        <feGaussianBlur stdDeviation="2"></feGaussianBlur>
        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"></feColorMatrix>
        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_3_190"></feBlend>
        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_3_190" result="shape"></feBlend>
      </filter>

      <linearGradient id="paint0_linear_3_190" x1="12.8889" y1="-3.55557" x2="55.5556" y2="64" gradientUnits="userSpaceOnUse">
        <stop stop-color="#FFAC5F"></stop>
        <stop offset="1" stop-color="#FF4D3C"></stop>
      </linearGradient>
    </defs>
  </svg>
</form>

@pushIf(!$disabled, 'scripts')
  @vite('resources/js/buttons/create.js')
@endPushIf
