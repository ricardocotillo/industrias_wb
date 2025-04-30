<ul class="flex flex-col gap-2">
  @foreach($products as $product)
    <li data-code="{{ $product->codigo }}">
      <a href="{{ route('productos.show', $product->id) }}" class="flex gap-4 px-4 py-2">
        <img class="hidden object-cover w-40 h-40 rounded" src="" alt="{{ $product->codigo }} image" />
        <div class="flex flex-col gap-2">
          <h4 class="text-xl font-semibold text-red-600">{{ $product->codigo }}</h4>
          <p>{{ $product->descripcion }}</p>
        </div>
      </a>
    </li>
  @endforeach
</ul>