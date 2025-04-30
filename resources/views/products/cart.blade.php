@extends('layouts.base')

@section('content')
  <section x-data="fullCartData" class="container px-4 py-10 mx-auto min-h-[calc(100dvh-17.75rem)]">
    <template x-if="cart">
      <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="md:col-span-1">
          <h4 class="mb-4 text-xl font-semibold">¿Deseas solicitar una cotización?</h4>
          <p class="mb-4 text-gray-900">Comunicate con nosotros. Enviaremos tu pedido a uno de nuestros representantes de venta y el te responderá lo más rápido posible</p>
          <template x-if="!showQuoteForm">
            <button class="flex gap-2 justify-center items-center px-4 py-2 w-full text-white bg-red-600 hover:bg-red-700 cursor-pointer" @click="showQuoteForm = true">
              <i class="text-2xl las la-envelope"></i> Solicitar cotización <span x-text="totalItems"></span>
            </button>
          </template>
          <template x-if="showQuoteForm">
            <button class="flex gap-2 justify-center items-center px-4 py-2 w-full text-white bg-red-600 hover:bg-red-700 cursor-pointer" @click="showQuoteForm = false">
              <i class="text-2xl las la-times"></i> No solicitar por ahora
            </button>
          </template>
          <form class="mt-4 space-y-4" x-show="showQuoteForm" @submit.prevent="requestQuote" action="{{ route('contact.quote') }}">
            @csrf
            <div>
              <label class="block mb-2 text-sm font-semibold" for="full_name">Nombre completo(*)</label>
              <input class="w-full rounded border-gray-300" type="text" name="full_name" id="full_name" required>
            </div>
            <div>
              <label class="block mb-2 text-sm font-semibold" for="ruc">RUC</label>
              <input class="w-full rounded border-gray-300" type="text" name="ruc" id="ruc">
            </div>
            <div>
              <label class="block mb-2 text-sm font-semibold" for="email">Email (*)</label>
              <input class="w-full rounded border-gray-300" type="email" name="email" id="email" required>
            </div>
            <div class="mb-3">
              <label class="block mb-2 text-sm font-semibold" for="phone">Teléfono (*)</label>
              <input class="w-full rounded border-gray-300" type="tel" name="phone" id="phone" required>
            </div>
            <div class="flex justify-end">
              <button class="flex gap-2 items-center px-4 py-2 text-white bg-red-600 hover:bg-red-700 cursor-pointer" type="submit">
                Solicitar cotización <i class="las la-paper-plane"></i>
              </button>
            </div>
            <div x-cloak class="flex justify-center p-4 mt-4 bg-green-500" x-show="sent && success">
              <p>Cotización solicitada correctamente</p>
            </div>
            <div x-cloak class="flex justify-center p-4 mt-4 bg-red-500" x-show="sent && !success">
              <p>Error al solicitar la cotización. Por favor, intente nuevamente.</p>
            </div>
          </form>
        </div>
        <ul class="md:col-span-2">
          <template x-for="(item, i) in cart">
            <li class="flex flex-col gap-4 py-4 border-b md:flex-row border-b-gray-500">
              <div class="w-full rounded md:w-auto min-w-40 aspect-square bg-slate-100 shrink-0">
                <img :data-code="item.code" class="hidden object-contain w-full rounded md:w-40 aspect-square" src="" :alt="`${item.code} imagen`" />
              </div>
              <div class="flex flex-col gap-4">
                <span x-text="item.code" class="text-2xl font-extrabold text-red-600"></span>
                <p x-text="item.desc"></p>
                <div class="flex flex-col gap-2 items-start">
                  <div>
                    <button @click="increase(item.code)" class="w-11 h-11 text-white bg-gray-500 rounded-l-lg" type="button"><i class="las la-plus"></i></button>
                    <input class="w-20 h-11 text-center border-r-0 border-l-0 border-gray-200" type="text" name="count" x-model.number="item.count" />
                    <button :disabled="item.count <= 1" @click="decrease(item.code)" class="w-11 h-11 text-white bg-gray-500 rounded-r-lg disabled:bg-gray-200" type="button"><i class="las la-minus"></i></button>
                  </div>
                  <button @click="remove(item.code)" class="text-xs font-semibold text-gray-500">REMOVE</button>
                </div>
              </div>
            </li>
          </template>
        </ul>
      </div>
    </template>
    <template x-if="!cart || !Object.keys(cart).length">
      <p class="italic font-medium text-center text-gray-500">Esta página está vacía, agrega productos desde el catálogo</p>
    </template>
  </section>
@endsection