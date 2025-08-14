<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Gestion</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class="upload-success-msg text-white font-bold text-center py-5 bg-green-400 hidden">
            Le document a été chargé avec succès
        </div>
        <div class="flex">
            {{-- Left sidebar --}}
            <section class="w-48 sticky top-0 rounded-tr-md border h-screen">
                <div class="flex justify-center font-bold mt-4">
                    <h2>Categories</h2>
                </div>

                {{-- https://medium.com/@darshitabaldha2001/laravel-fundamentals-components-f03e8c2874b7 --}}
                {{-- CategoryContainer component --}}
                <div class="flex flex-col items-center p-2">
                    {{-- Category components --}}
                    <x-category name="CAF" />
                    <x-category name="TEST" />
                </div>
            </section>

            {{-- Right content block --}}
            <section>
                <button class="px-3 py-1"> À propos </button>

                <h1 class="flex justify-center text-2xl font-bold mt-4">Gestion Administratif</h1>

                <div class="flex">
                    <form class="ml-8" action="/test">
                        <input class="rounded-md p-2 text-white bg-blue-400 hover:cursor-pointer" type="submit" value="Nouvelle catégorie">
                    </form>

                    <div class="flex ml-2">
                        <label for="doc-upload" class="rounded-md p-2 text-white bg-blue-400 hover:cursor-pointer">Charger un document</label>
                        <input id="doc-upload" class="hidden" accept="image/png, image/jpeg" type="file">
                    </div>
                </div>

                <input type="text" placeholder="Entrez le titre de document" class="border border-black px-1 py-1 ml-8 my-3">

                <div>
                    {{-- Documents grid --}}
                    <div class="grid grid-cols-3 py-5 px-8">
                        {{-- Document cards --}}
                        @foreach ($documents as $document)
                            {{-- docid - Document id --}}
                            <x-document-card src="{{ $document->path }}" title="{{ $document->title }}" docid="{{ $document->id }}" />
                        @endforeach
                    </div>
                </div>
            </section>
        </div>

        <script src="/js/zoom.js"></script>
        <script src="/js/upload.js"></script>
    </body>
</html>
