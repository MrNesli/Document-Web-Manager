<div {{ $attributes->merge(['class' => 'flex flex-col mb-2']) }}>
  <h4 class="font-bold text-[#BABEC1]">{{ $label }}</h4>

  {{ $slot }}
</div>
