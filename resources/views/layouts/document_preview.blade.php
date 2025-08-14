<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/css/document.css', 'resources/js/app.js'])
  @endif
  <title>Gestion Administratif</title>
  @stack('scripts')
</head>
<body class="relative bg-blue-100">
  <div class="z-1000 menu fixed bottom-0 left-0">
  </div>

  @yield('content')
</body>
</html>

