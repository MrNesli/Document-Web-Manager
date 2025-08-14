<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  @yield('head')

  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif
  <title>Gestion Administratif</title>
  @stack('scripts')
</head>
<body class="bg-blue-100">
  <!-- Centered bottom menu -->
  <div class="z-10 menu fixed bottom-0 left-1/2 -translate-x-1/2">
    <x-menu class="pointer-events-none"></x-menu>
    @yield('new-button')
    <div class="w-full absolute top-0 z-10 flex justify-between pt-5">
      <div class="flex">
        <!-- Compass icon -->
        <svg class="ml-7 mr-9" width="30" height="30" viewBox="0 0 26 26" fill="none">
          <path fill="#989A9D" d="M13.254 15.922 8.17 18.256c-.417.167-.75-.25-.583-.584l2.334-5.085c.583-1.167 1.5-2.167 2.667-2.667l5.169-2.418c.416-.166.75.25.583.584l-2.334 5.085c-.583 1.25-1.584 2.167-2.75 2.75Z"/>
          <path fill="#989A9D" d="M12.92 3.334c5.252 0 9.587 4.252 9.587 9.587 0 5.252-4.251 9.586-9.586 9.586a9.535 9.535 0 0 1-9.587-9.586c0-5.335 4.335-9.587 9.587-9.587Zm0-3.334C5.836 0 0 5.752 0 12.92c0 7.17 5.752 12.922 12.92 12.922 7.086 0 12.922-5.752 12.922-12.921C25.842 5.75 20.006 0 12.92 0Z"/>
        </svg>

        <!-- Squares icon -->
        <svg width="30" height="30" viewBox="0 0 26 26" fill="none">
          <path fill="#989A9D" d="M10.837 0H1.334C.584 0 0 .584 0 1.334v9.503c0 .667.584 1.334 1.334 1.334h9.503c.75 0 1.334-.584 1.334-1.334V1.334C12.17.584 11.587 0 10.837 0ZM9.253 2.918v6.335H2.918V2.918h6.335ZM24.508 0h-9.503c-.75 0-1.334.584-1.334 1.334v9.503c0 .667.584 1.334 1.334 1.334h9.503c.75 0 1.334-.584 1.334-1.334V1.334c0-.75-.584-1.334-1.334-1.334Zm-1.584 2.918v6.335h-6.335V2.918h6.335ZM10.837 13.671H1.334c-.75 0-1.334.584-1.334 1.334v9.503c0 .667.584 1.334 1.334 1.334h9.503c.75 0 1.334-.584 1.334-1.334v-9.503c0-.75-.584-1.334-1.334-1.334Zm-1.584 2.918v6.335H2.918v-6.335h6.335ZM24.508 13.671h-9.503c-.75 0-1.334.584-1.334 1.334v9.503c0 .667.584 1.334 1.334 1.334h9.503c.75 0 1.334-.584 1.334-1.334v-9.503c0-.75-.584-1.334-1.334-1.334Zm-1.584 2.918v6.335h-6.335v-6.335h6.335Z"/>
        </svg>
      </div>

      <div class="flex">
        <!-- Profile icon -->
        <svg class="mr-9" width="30" height="30" viewBox="0 0 26 26" fill="none">
          <path fill="#989A9D" d="M22.444 25.425H2.438c-.667 0-1.334-.334-1.834-.834-.5-.5-.667-1.25-.584-1.917.417-3.585 2.835-6.752 7.003-8.92-1.334-1.5-2.084-3.5-2.084-5.585C4.939 3.668 8.356 0 12.524 0s7.42 3.668 7.42 8.17c0 2.083-.75 4.084-2.084 5.584 4.084 2.168 6.585 5.335 7.002 8.92.083.667-.167 1.417-.584 1.917-.5.5-1.167.834-1.834.834ZM3.438 22.09h17.923c-.75-2.667-3.168-4.418-5.252-5.501a3.126 3.126 0 0 1-1.667-2.251c-.167-1 .083-2 .833-2.751a5.217 5.217 0 0 0 1.334-3.501c0-2.668-1.917-4.835-4.251-4.835-2.334 0-4.168 2.25-4.168 4.918 0 1.334.5 2.584 1.334 3.501.666.75 1 1.75.833 2.751-.167 1-.75 1.75-1.667 2.251-2.084 1-4.502 2.75-5.252 5.418Z"/>
        </svg>

        <!-- Search icon -->
        <svg id="search-button" class="mr-7 cursor-pointer" width="30" height="30" viewBox="0 0 26 26" fill="none">
          <path id="search-icon" stroke="#989A9D" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m23.625 23.625-4.894-4.894m2.644-6.356a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
          <defs>
            <linearGradient id="gradient" x1="12.8889" y1="-3.55557" x2="55.5556" y2="64" gradientUnits="userSpaceOnUse">
              <stop stop-color="#FFAC5F"></stop>
              <stop offset="1" stop-color="#FF4D3C"></stop>
            </linearGradient>
          </defs>
        </svg>
      </div>
    </div>

  </div>

  <div class="w-11/12 mx-auto">
    @yield('content')
  </div>

  @yield('scripts')
  <!-- @vite('resources/js/svg.js') -->
</body>
</html>
