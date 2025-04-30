@extends('layouts.base')

@section('content')
<main>
  <section class="container max-w-6xl px-4 py-10 mx-auto">
    <div class="flex flex-col items-center gap-4 md:flex-row md:items-start">
      <div class="relative w-full overflow-hidden aspect-square md:w-96 image-container hover:cursor-zoom-in">
        <img data-code="{{ $producto->codigo }}" class="hidden object-cover w-full h-full transition-transform" src="" alt="{{ $producto->codigo }} imagen">
      </div>
      <div class="flex flex-col w-full gap-4 md:w-1/2">
        <h1 class="text-4xl font-extrabold text-center text-red-600 md:text-left">{{ $producto->codigo }}</h1>
        <p class="font-semibold">{{ $producto->tipo }}</p>
        <p class="font-semibold">Aplicación: {{ $producto->aplicaciones }}</p>
        <form @submit.prevent="addToCart" x-data="product" class="flex add-to-cart">
          @csrf
          <input type="hidden" name="code" value="{{ $producto->codigo }}">
          <input type="hidden" name="desc" value="{{ $producto->tipo }}">
          <button @click="count += 1" class="text-white bg-gray-500 rounded-l-lg w-11 h-11" type="button"><i class="las la-plus"></i></button>
          <input class="w-20 text-center border-l-0 border-r-0 border-gray-200 h-11" type="text" name="count" x-model.number="count" />
          <button :disabled="count <= 1" @click="count -= 1" class="text-white bg-gray-500 w-11 h-11 disabled:bg-gray-200" type="button"><i class="las la-minus"></i></button>
          <button type="submit" class="px-4 py-2 text-lg italic font-semibold text-white bg-red-600 rounded-r-lg hover:bg-red-700 agregar-carrito font-helvetica cursor-pointer">Agregar a lista</button>
        </form>
      </div>
    </div>
  </section>
  <section class="container max-w-6xl px-4 py-10 mx-auto">
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-white">
          <tr>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Diametro interior
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Diametro exterior
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Altura
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              V. Anti
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              By pass
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Empaquetadura
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Unidades por caja
            </th>
          </tr>
        </thead>
        <tbody>
          <tr class="bg-gray-100">
            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
              {{ $producto->diametro_interior }}
            </td>
            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
              {{ $producto->diametro_exterior }}
            </td>
            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
              @if($producto->altura){{ $producto->altura }}@endif
            </td>
            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
              {{ $producto->valv_antidr }}
            </td>
            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
              {{ $producto->valv_by_pass }}
            </td>
            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
              {{ $producto->empaquetadura }}
            </td>
            <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
              @if($producto->pzs_x_caja){{ $producto->pzs_x_caja }}@endif
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
  <section class="container max-w-6xl px-4 py-10 mx-auto">
    <h4 class="mb-4 text-xl font-semibold">Modelos compatibles</h4>
    <div class="overflow-x-auto">
      <table class="min-w-full">
        <thead class="bg-white">
          <tr>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Marca
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Modelo
            </th>
            <th class="px-6 py-4 text-sm font-semibold text-left whitespace-nowrap">
              Año
            </th>
          </tr>
        </thead>
        <tbody>
          @foreach($producto_modelos as $index => $pm)
            <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
              <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                {{ $pm->modelo->marca->nombre }}
              </td>
              <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                {{ $pm->modelo->nombre }}
              </td>
              <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                {{ $pm->ano }}
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>
</main>
@endsection