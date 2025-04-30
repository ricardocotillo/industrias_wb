@extends('layouts.base')

@section('extra_css')
<script>
    window.filters = @json($filters);
    window.products = @json($products);
    window.brands = @json($brands);
    window.models = @json($models);
    window.yearMin = @json($year_min);
    window.yearMax = @json($year_max);
    window.next_page_url = @json($next_page_url);
</script>
@endsection

<main>
  @section('hero')
  <section>
    <img class="object-cover w-full h-60" src="{{ asset('products/img/1.jpg') }}" alt="imagen de cabecera" />
  </section>
  @endsection
  
  @section('content')
  <section class="container px-4 py-10 mx-auto">
    <div x-data="{loading: false}" @reset:start.document="loading = true" @reset:end.document="loading = false" class="grid relative grid-cols-3 gap-8">
      <div class="flex absolute inset-0 justify-center items-center bg-white bg-opacity-50" x-show="loading">
      </div>
      <div
        x-data="{
          open: false,
          closeFilter() {
            this.open = false
            const body = document.querySelector('body')
            body.classList.remove('overflow-hidden')
          }
        }"
        @filter:open.document="open = true"
        class="overflow-y-auto fixed top-0 left-1/2 col-span-1 w-full min-w-full max-w-sm max-h-full -translate-x-1/2 lg:translate-y-0 lg:block lg:static lg:translate-x-0"
        :class="open ? '' : 'hidden'"
      >
        <div class="relative bg-gray-200 rounded-sm">
          <h2 class="p-4 text-3xl font-extrabold border-t border-gray-400 border-x">Limita tu búsqueda</h2>
          <button @click="closeFilter" class="absolute top-2 right-2 p-2 text-3xl lg:hidden"><i class="las la-times"></i></button>
          <div class="border-t border-gray-400 border-x" x-data="yearData">
            <button @click="open = !open" class="flex justify-between items-center px-4 py-2 w-full text-lg font-semibold">Año <i class="las" :class="open ? 'la-angle-up' : 'la-angle-down'"></i></button>
            <div x-show="open" class="px-6 pt-12 pb-4">
              <div x-ref="range"></div>
            </div>
          </div>
          <div x-data="brandData" class="border-t border-gray-400 border-x">
            <button @click="open = !open" class="flex justify-between items-center px-4 py-2 w-full text-lg font-semibold">Marca <i class="las" :class="open ? 'la-angle-up' : 'la-angle-down'"></i></button>
            <div x-show="open" x-transition class="pt-2 bg-white">
              <div class="px-2 mb-2">
                <input @input="search" x-model="query" type="text" class="w-full" placeholder="Busca más marcas...">
              </div>
              <ul class="flex flex-col gap-2 px-4 pt-2 pb-6">
                <template x-for="brand in brands" :key="brand.id">
                  <li>
                    <label class="flex gap-2 items-center w-full cursor-pointer" :for="`brand-${brand.id}`">
                      <input class="rounded" :id="`brand-${brand.id}`" @change="dispatch" type="checkbox" :value="brand.id" x-model.number="selectedBrands">
                      <span x-text="brand.nombre"></span>
                    </label>
                  </li>
                </template>
              </ul>
            </div>
          </div>
          <div x-data="modelData" class="border border-gray-400">
            <button @click="open = !open" class="flex justify-between items-center px-4 py-2 w-full text-lg font-semibold">Modelo <i class="las" :class="open ? 'la-angle-up' : 'la-angle-down'"></i></button>
            <div x-show="open" x-transition class="pt-2 bg-white">
              <div class="px-2 mb-2">
                <input @input="search" x-model="query" type="text" class="w-full" placeholder="Busca más modelos...">
              </div>
              <ul class="flex flex-col gap-2 px-4 pt-2 pb-6">
                <template x-for="model in models" :key="model.id">
                  <li>
                    <label class="flex gap-2 items-center w-full cursor-pointer" :for="`model-${model.id}`">
                      <input class="rounded" :id="`model-${model.id}`" @change="dispatch" type="checkbox" :value="model.id" x-model.number="selectedModels">
                      <span x-text="model.nombre"></span>
                    </label>
                  </li>
                </template>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="flex flex-col col-span-3 gap-4 bg-no-repeat lg:col-span-2" style="background-image: url({{ asset('products/img/sello-agua.svg') }})" x-data="products">
        <div class="flex gap-2">
          <button @click="handleFilter" class="flex justify-center items-center w-12 h-12 text-3xl text-gray-800 bg-gray-200 rounded md:hidden"><i class="las la-filter"></i></button>
          <template x-if="Object.keys(params).length">
            <div class="flex gap-2">
              <button @click="clearFilters" class="px-4 py-2 text-sm text-gray-900 bg-gray-200 cursor-pointer">Quitar parámetros de búsqueda</button>
            </div>
          </template>
        </div>
        <template x-if="productos.length">
          <ul class="flex flex-col gap-6 md:gap-4">
            <template x-for="producto in productos">
              <li class="flex flex-col gap-4 items-start md:flex-row" :data-code="producto.codigo">
                <a :href="`/productos/${producto.id}/`" class="block w-full rounded md:w-40 shrink-0 bg-slate-100 md:min-w-40 md:min-h-40 aspect-square md:aspect-auto">
                  <img :data-code="producto.codigo" class="hidden object-contain w-full rounded border md:aspect-auto aspect-square md:w-40 md:h-40" src="" :alt="`${producto.codigo} imagen`"/>
                </a>
                <div class="flex flex-col gap-2 w-full grow">
                  <a :href="`/productos/${producto.id}/`">
                    <div class="px-4 py-2 w-full text-lg italic font-extrabold text-center text-white bg-red-600 rounded-md md:w-60 font-helvetica" x-text="producto.codigo"></div>
                  </a>
                  <p class="font-semibold text-gray-500" x-text="producto.tipo"></p>
                  <p class="font-semibold text-gray-500 line-clamp-3" x-text="producto.aplicaciones"></p>
                  <p class="font-semibold text-gray-500 line-clamp-3" x-text="producto.descripcion"></p>
                </div>
                <form @submit.prevent="addToCart" class="flex items-end h-auto md:h-40 shrink-0">
                  @csrf
                  <input type="hidden" name="count" value="1" />
                  <input type="hidden" name="code" :value="producto.codigo">
                  <input type="hidden" name="desc" :value="producto.tipo">
                  <button type="submit" class="px-4 py-2 text-lg italic font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 agregar-carrito font-helvetica cursor-pointer">Agregar a lista</button>
                </form>
              </li>
            </template>
          </ul>
        </template>
        <div x-show="productos.length && next" x-ref="next" x-text="next"></div>
        <template x-if="!productos.length">
          <p class="text-lg italic font-semibold text-center text-gray-500">No se encontraron resultados</p>
        </template>
      </div>
    </div>
  </section>
  @endsection
</main>

@section('extra_js')
@endsection