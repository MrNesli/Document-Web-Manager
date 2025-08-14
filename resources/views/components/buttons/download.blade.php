<form action="{{ route('documents.download', ['id' => $id]) }}" method="GET">
  @csrf
  <button class="mr-4 cursor-pointer" type="submit">
    <svg width="32" height="32" viewBox="0 0 33 33" fill="none">
      <path stroke="url(#a)" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M28.875 20.625v5.5a2.75 2.75 0 0 1-2.75 2.75H6.875a2.75 2.75 0 0 1-2.75-2.75v-5.5m5.5-6.875 6.875 6.875m0 0 6.875-6.875M16.5 20.625v-16.5" />
      <defs>
        <linearGradient id="a" x1="16.5" x2="16.5" y1="4.125" y2="28.875" gradientUnits="userSpaceOnUse">
          <stop stop-color="#FD814A" />
          <stop offset="1" stop-color="#FC5C4C" />
        </linearGradient>
      </defs>
    </svg>
  </button>
</form>
