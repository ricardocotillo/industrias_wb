@extends('layouts.base')

@section('content')
<main>
  <section class="container grid grid-cols-1 gap-8 px-4 py-24 mx-auto lg:grid-cols-2 lg:px-0">
    <div class="flex flex-col col-span-1 gap-4 text-lg">
      <h1 class="mb-4 text-4xl font-bold underline">FILTRACION EN FILTROS PARA LUBRICANTE</h1>
      <p>Se dice muchas veces que el lubricante es equivalente a la sangre en lo seres humanos, circula por todas las partes de los equipos y motores y va ejerciendo su trabajo de reducir la friccion, limpiar las impurezas y contaminantes que han ingresado al motor o se han generado producto de su  funcionamiento y/o mantenimiento, los contaminantes producto del desgaste de las diferentes partes en movimiento, el agua producto de la humedad del medio ambiente  por mencionar los mas importantes.</p>
      <div class="p-8 bg-gray-100 rounded-lg">
        <p>De alli su importancia en la vida de un motor y/o equipo. mencion especial  merecen los sistemas hidraulicos que aparte de ejercer las funciones indicadas anteriormente deben transmitir fuerza para el movimiento de sus partes para el cumplimiento de sus funciones.</p>
      </div>
      <p>Las especificaciones de los filtros para lubricante e hidraulicos WB recogen toda la experiencia a traves de su larga trayectoria de todos los factores que tienen que ver con la vida los equipos y motores.</p>
    </div>
    <div class="col-span-1">
      <div class="flex flex-col items-center justify-center gap-4 p-8 bg-gray-800 rounded-lg">
        <img class="max-w-full w-200" src="{{ asset('products/img/bodegon-lubricante.png') }}" alt="bodegon filtros de lubricante"/>
        <div class="flex justify-end w-full">
          <a href="{{ route('productos.index') }}" class="flex items-center text-lg font-semibold text-white">Ver catálogo completo <i class="las la-angle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection