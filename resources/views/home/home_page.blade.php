@extends('layouts.base')

@section('body_class', 'template-homepage')

@section('hero')
<section class="splide hero-splide">
  <div class="splide__track">
    <ul class="splide__list">
      <li class="splide__slide">
        <img src="{{ asset('home/img/image-1.jpg') }}" alt="filtros slider 1" />
      </li>
      <li class="splide__slide">
        <img src="{{ asset('home/img/image-2.jpg') }}" alt="filtros slider 1" />
      </li>
      <li class="splide__slide">
        <img src="{{ asset('home/img/image-3.jpg') }}" alt="filtros slider 1" />
      </li>
      <li class="splide__slide">
        <img src="{{ asset('home/img/image-4.jpg') }}" alt="filtros slider 1" />
      </li>
      <li class="splide__slide">
        <img src="{{ asset('home/img/image-5.jpg') }}" alt="filtros slider 1" />
      </li>
    </ul>
  </div>
</section>
@endsection

@section('content')
<main>
  <section
    x-data="{
      mode: 'code',
      suggestions: [],
      query: '',
      show: false,
      changeMode(mode) {
        this.query = ''
        this.mode = mode
      },
      handleInput() {
        if (this.query.length > 2) {
          const id = this.mode == 'code' ? '#search-form' : '#eq-form'
          htmx.trigger(id, 'search-input');
          this.show = true;
        } else {
          this.show = false;
        }
      }
    }"
    class="container relative z-10 px-4 mx-auto -mt-8 search"
  >
    <div class="flex flex-col gap-4 p-4 mx-auto max-w-4xl bg-red-600 rounded-lg">
      <ul class="flex gap-4 text-white">
        <li @click="changeMode('code')" class="[&.active]:border-b-2 [&.active]:border-b-white cursor-pointer" :class="mode == 'code' ? 'active' : ''">Por código</li>
        <li @click="changeMode('eq')" class="[&.active]:border-b-2 [&.active]:border-b-white cursor-pointer" :class="mode == 'eq' ? 'active' : ''">Por equivalencia</li>
      </ul>
      <div x-show="mode == 'code'" id="q-code">
        <form action="{{ route('productos.index') }}" id="search-form" hx-get="{{ route('products.search') }}" hx-trigger="search-input" hx-target="#searchSuggestions">
          <input
            name="codigo_alt__icontains"
            x-model="query"
            placeholder="Ingresa código a buscar"
            type="search"
            @input="handleInput"
            class="w-full rounded search-input bg-white p-3"
          >
        </form>
      </div>
      <div x-show="mode == 'eq'" id="q-eq">
        <form action="{{ route('productos.index') }}" id="eq-form" hx-get="{{ route('products.search') }}" hx-trigger="search-input" hx-target="#searchSuggestions">
          <input
            name="equivalencias__codigo_alt__icontains"
            placeholder="Ingresa código a comparar"
            x-model="query"
            type="search"
            @input="handleInput"
            class="w-full rounded search-input bg-white p-3"
          >
        </form>
      </div>
    </div>
    <div
      class="mx-auto mt-1 max-w-4xl bg-white rounded border border-gray-100 shadow-md"
      id="searchSuggestions"
      x-show="show"
      @click.away="show = false"
    >
    </div>
  </section>
  <section class="px-4 py-20 mx-auto">
    <div class="grid grid-cols-1 gap-20 mx-auto max-w-7xl lg:grid-cols-2">
      <div class="flex flex-col col-span-1 gap-8">
        <h1 class="text-3xl font-black text-gray-900 lg:text-5xl">Perfección y tecnología Peruana para el mundo</h1>
        <p class="text-lg">Desarrollamos filtros para toda la industria automotriz. Cada una de nuestras lineas de producción ya sea para motores livianos o pesados pasa por un alto nivel de supervisión, lo que hace que cada una de nuestras piezas sea reconocida a nivel mundial por sus materiales, diseño y calidad. Somos filtros Willy Busch ¡Perfección que filtra!</p>
      </div>
      <video class="col-span-1 w-full aspect-video" src="{{ asset('home/vids/wb.mp4') }}" autoplay muted loop></video>
     {{-- <iframe class="col-span-1 w-full aspect-video" src="https://www.youtube.com/embed/d8zWxbDHWn4?si=tq7r0Bz_q5PRPk1_&amp;controls=0&autoplay=1&mute=1&loop=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe> --}}
    </div>
  </section>
  <section class="container px-4 py-10 mx-auto">
    <h2 class="mb-4 text-3xl font-bold text-center text-red-600">Nuestras Lineas</h2>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-3 sm:grid-cols-2">
      <div class="flex flex-col col-span-1 gap-2 p-4 bg-gray-50 bg-opacity-50 rounded shadow-md">
        <h4 class="text-xl font-bold text-center text-gray-900">Filtros para aire</h4>
        <img class="w-full rounded" src="{{ asset('home/img/aire.jpeg') }}" alt="filtro de aire"/>
        <p class="text-gray-800">Diseñados con materiales resistentes, incluyen cubierta metálica, tubo interior, sistema de separación, plisado facetado y sellado eficiente, adaptados a condiciones operativas exigentes y diferentes ambientes.</p>
        <div class="flex justify-end">
          <a href="{{ route('products.line', 'aire') }}" class="flex gap-2 items-center text-lg font-semibold text-gray-900">Conoce más<i class="las la-angle-right"></i></a>
        </div>
      </div>
      <div class="flex flex-col col-span-1 gap-2 p-4 bg-gray-50 bg-opacity-50 rounded shadow-md">
        <h4 class="text-xl font-bold text-center text-gray-900">Filtros para lubricante</h4>
        <img class="w-full rounded" src="{{ asset('home/img/aceite.jpeg') }}" alt="filtro de aceite"/>
        <p class="text-gray-800">Filtros diseñados con materiales resistentes y herméticos, probados en diversas condiciones para garantizar protección del motor y cumplir estándares internacionales mediante monitoreo y mejora continua.</p>
        <div class="flex justify-end">
          <a href="{{ route('products.line', 'lubricante') }}" class="flex gap-2 items-center text-lg font-semibold text-gray-900">Conoce más<i class="las la-angle-right"></i></a>
        </div>
      </div>
      <div class="flex flex-col col-span-1 gap-2 p-4 bg-gray-50 bg-opacity-50 rounded shadow-md">
        <h4 class="text-xl font-bold text-center text-gray-900">Filtros para combustible</h4>
        <img class="w-full rounded" src="{{ asset('home/img/combustible.jpeg') }}" alt="filtro de combustible"/>
        <p class="text-gray-800">Los filtros WB protegen motores de contaminantes en combustibles, asegurando calidad mediante materiales resistentes y pruebas que mejoran continuamente su diseño para diversas condiciones de operación.</p>
        <div class="flex justify-end">
          <a href="{{ route('products.line', 'combustible') }}" class="flex gap-2 items-center text-lg font-semibold text-gray-900">Conoce más<i class="las la-angle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
  <section class="container px-4 py-10 mx-auto">
    <div class="flex flex-col justify-between items-start lg:flex-row lg:items-center">
      <h1 class="mb-4 text-2xl font-extrabold text-red-600 lg:text-4xl">Productos destacados</h1>
      <a href="#" class="text-sm font-semibold text-gray-500 lg:text-base">VER TODOS <i class="las la-arrow-right"></i></a>
    </div>
    <div class="featured-splide splide">
      <div class="splide__track">
        <ul class="splide__list">
          @foreach($featured_products as $product)
          <li data-code="{{ $product->codigo }}" class="flex flex-col gap-2 items-center splide__slide">
            <div class="w-80 h-80">
              <img data-code="{{ $product->codigo }}" class="hidden object-contain w-80 h-80" src="" alt="{{ $product->codigo }} imagen" />
            </div>
            <a href="{{ route('productos.show', $product->id) }}" class="block px-4 py-2 text-2xl italic font-extrabold text-center text-white bg-red-600 rounded-md font-helvetica">{{ $product->codigo }}</a>
            <p class="w-full font-semibold text-center text-gray-500 line-clamp-2">{{ $product->tipo }}</p>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>
  <section class="flex justify-center items-center text-white bg-fixed bg-cover h-125" style="background-image: url({{ asset('home/img/paralelaje.webp') }})">
    {{-- <h1 class="text-6xl font-bold">Perfección que filtra</h1> --}}
    <img class="w-125" src="{{ asset('img/sello.svg') }}" alt="sello willy busch">
  </section>
  <section class="container px-4 py-10 mx-auto">
    <div class="flex flex-col justify-between items-start lg:flex-row lg:items-center">
      <h1 class="mb-4 text-2xl font-extrabold text-red-600 lg:text-4xl">Promociones</h1>
      <a href="#" class="text-sm font-semibold text-gray-500 lg:text-base">VER TODOS <i class="las la-arrow-right"></i></a>
    </div>
    <div class="featured-splide splide">
      <div class="splide__track">
        <ul class="splide__list">
          @foreach($promoted_products as $product)
          <li data-code="{{ $product->codigo }}" class="flex flex-col gap-2 items-center w-full splide__slide">
            <img data-code="{{ $product->codigo }}" class="hidden object-contain w-80 h-80" src="" alt="{{ $product->codigo }} imagen" />
            <a href="{{ route('productos.show', $product->id) }}" class="block px-4 py-2 w-5/6 text-2xl italic font-extrabold text-center text-white bg-red-600 rounded-md font-helvetica">{{ $product->codigo }}</a>
            <p class="w-full font-semibold text-center text-gray-500 line-clamp-2">{{ $product->tipo }}</p>
          </li>
          @endforeach
        </ul>
      </div>
    </div>
  </section>
</main>
@endsection