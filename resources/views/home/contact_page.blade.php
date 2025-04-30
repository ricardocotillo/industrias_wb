@extends('layouts.base')

@section('content')
<main class="container px-4 mx-auto">
  <section class="flex flex-wrap mt-10">
    <div class="w-full px-6 pt-24 pb-20 bg-gray-100 rounded-l-lg lg:px-8 lg:w-1/2">
      <h3 class="mb-6 text-2xl font-semibold">Contáctanos</h3>
      <ul class="flex flex-col gap-4">
        <li class="flex gap-2">
          <i class="text-3xl text-gray-500 las la-building"></i>
          <span>Av. Santa Maria 135<br>Ate 15022, Lima, Peru</span>
        </li>
        <li class="flex items-center gap-2">
          <i class="text-3xl text-gray-500 las la-phone"></i>
          <a href="tel:+5112002900">+51 (01) 2002900 Anexos: 2005 / 2006 / 2007</a>
        </li>
        <li class="flex items-center gap-2">
          <i class="text-3xl text-gray-500 las la-envelope"></i>
          <a href="mailto:atencionalcliente@filtroswillybusch.com.pe">atencionalcliente@filtroswillybusch.com.pe</a>
        </li>
      </ul>
    </div>
    <div class="w-full px-6 pt-20 pb-24 rounded-r-lg lg:px-8 lg:w-1/2">
      <form class="space-y-4" x-data="contact" @submit.prevent="sendEmail" action="{{ route('contact.email') }}">
        @csrf
        <div>
          <label class="block mb-2 text-sm font-semibold" for="first_name">Nombre (*)</label>
          <input class="w-full border-gray-300 rounded" type="text" name="first_name" id="first_name" required>
        </div>
        <div>
          <label class="block mb-2 text-sm font-semibold" for="last_name">Apellido (*)</label>
          <input class="w-full border-gray-300 rounded" type="text" name="last_name" id="last_name" required>
        </div>
        <div>
          <label class="block mb-2 text-sm font-semibold" for="email">Email (*)</label>
          <input class="w-full border-gray-300 rounded" type="email" name="email" id="email" required>
        </div>
        <div>
          <label class="block mb-2 text-sm font-semibold" for="phone">Teléfono (*)</label>
          <input class="w-full border-gray-300 rounded" type="tel" name="phone" id="phone" required>
        </div>
        <div>
          <label class="block mb-2 text-sm font-semibold" for="message">Mensaje (*)</label>
          <textarea class="w-full border-gray-300 rounded" rows="5" name="message" id="message" required></textarea>
        </div>
        <div class="flex justify-end">
          <button class="px-4 py-2 text-white bg-red-600 hover:bg-red-700 cursor-pointer" type="submit">Enviar mensaje</button>
        </div>
        <div x-cloak class="flex justify-center p-4 mt-4 bg-green-500" x-show="sent && success">
          <p>Mensaje enviado correctamente</p>
        </div>
        <div x-cloak class="flex justify-center p-4 mt-4 bg-red-500" x-show="sent && !success">
          <p>Error al enviar el mensaje. Por favor, intente nuevamente.</p>
        </div>
      </form>
    </div>
  </section>
</main>
@endsection