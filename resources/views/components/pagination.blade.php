@php
    $pages = $paginationData['pages'];
    $per_page = $paginationData['per_page'];
    $search_name = $paginationData['search_name'];
@endphp

<!-- /categories/4?page=1&selected_items=[1, 5, 6, 7, 2] -->
<!-- /categories/4?page=2&per_page=10&selected_items=12,4,3,1,5 -->

<div class="flex font-comfortaa">
  @foreach ($pages as $page => $state)
    @if ($state == 'active')
      <x-buttons.pagination page="{{ $page }}" route="{{ $redirectTo }}" :query-params="['page' => $page, 'per_page' => $per_page, 'search_name' => $search_name]" active>
      </x-buttons.pagination>
    @else
      <x-buttons.pagination page="{{ $page }}" route="{{ $redirectTo }}" :query-params="['page' => $page, 'per_page' => $per_page, 'search_name' => $search_name]">
      </x-buttons.pagination>
    @endif
  @endforeach
</div>
