<div {{ $attributes->merge(['class' => 'hidden confirmation-dialog flex justify-center items-center z-100 fixed left-0 top-0 w-full h-screen bg-black/50']) }}>
  <div class="relative rounded-xl px-5 py-3 flex flex-col bg-white">
    <h3 class="font-comfortaa text-center mb-4">{{ $title }}</h3>
    <div class="flex justify-around">
      <form action="{{ $routeOnConfirm }}" method="GET">
        @csrf
        <button class="w-fit cursor-pointer rounded-lg px-8 py-1 text-white bg-red-500" type="submit">Confirmer</button>
      </form>
      <button class="cancel-btn w-fit cursor-pointer rounded-lg px-8 py-1 text-white bg-linear-to-r from-[#FD814A] to-[#FC5C4C]" type="button">Abandonner</button>
    </div>
  </div>
</div>

@pushOnce('scripts')
  @vite('resources/js/confirmation/dialog.js')
@endPushOnce
