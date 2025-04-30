@extends('layouts.base')

@section('content')
<main>
  <section class="container grid grid-cols-1 gap-8 px-4 py-24 mx-auto lg:grid-cols-2 lg:px-0">
    <div class="flex flex-col col-span-1 gap-4 text-lg">
      <h1 class="mb-4 text-4xl font-bold underline">FILTRACION EN FILTROS PARA COMBUSTIBLE</h1>
      <p>Es conocido que los combustibles que salen de las refinerias deben ser transportados y manipulados hasta llegar al usuario final. estas fases son muy variadas sobre todo cuando se tiene regiones nuy variadas como en el peru como son costa, sierra y selva.</p>
      <div class="p-8 bg-gray-100 rounded-lg">
        <p>En cada fase el combustible es contaminado con presencia de particulas y elementos que hacen daño al sistema de combustible que de los motores y equipos. se debe tener mucho cuidado y tambien tener en cuenta en las especificaciones tecnicas de los filtros para combustible.</p>
      </div>
      <p>En IWB se fabrican una gran variedad de filtros para combustible diseñados con especificaciones tecnicas que incluyen estos contaminantes que se van incorporando en la diferentes fases de manipuleo asi como los se van integrando producto del funcionamiento de los motores tales como el oxido, el polvo atmosferico, el agua, etc y las labores de mantenimiento.</p>
    </div>
    <div class="col-span-1">
      <div class="flex flex-col items-center justify-center gap-4 p-8 bg-gray-800 rounded-lg">
        <img class="max-w-full w-200" src="{{ asset('products/img/bodegon-combustible.png') }}" alt="bodegon filtros de combustible"/>
        <div class="flex justify-end w-full">
          <a href="{{ route('productos.index') }}" class="flex items-center text-lg font-semibold text-white">Ver catálogo completo <i class="las la-angle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection