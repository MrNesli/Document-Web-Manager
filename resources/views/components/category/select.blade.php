<div id="category-select" {{ $attributes->merge(['class' => 'flex flex-col']) }}>
  <label class="text-lg font-inter font-light pb-1" for="{{ $id }}">Catégorie</label>
  <select class="w-1/2 text-black bg-white rounded-lg p-2" name="{{ $name }}" id="{{ $id }}">
    @foreach($categories as $category)
      @if ($category->id == $currentCategoryId)
        <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
      @else
        <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endif
    @endforeach
  </select>
</div>
