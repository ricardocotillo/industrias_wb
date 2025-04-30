@extends('layouts.base')

@section('content')
<main>
  <section class="container grid grid-cols-1 gap-8 px-4 py-24 mx-auto lg:grid-cols-2 lg:px-0">
    <div class="flex flex-col col-span-1 gap-4 text-lg">
      <h1 class="mb-4 text-4xl font-bold underline">FILTRACIÓN EN FILTROS PARA AIRE</h1>
      <p>Industrias Willy Busch a través de los años de trabajo tiene claro los diferentes ambentes medio ambientes  que se tiene en el peru en los sectores de trasnporte liviano, trabsporte  de pasajeros por las dierentes regiones, trasnporte de carga por costa sierra y selva, construccion, pesca, mineria, etc. en filtracion de aire   esta es una de las consideraciones importantes a tener en cuenta para las especificaciones tecnicas de los filtros para aire WB.</p>
      <div class="p-8 bg-gray-100 rounded-lg">
        <p>Este aspecto constituye una ventaja competitiva para filtros wb porque a traves de los años recoge informacion de los ambientes de trabajo de las maquinarias y equipos en nuestro pais asi como sus cambios a traves del tiempo para considerarlosen  el  diseño de los filtros para aire WB.</p>
      </div>
      <p>IWB cuenta con una amplia gama de aplicaciones que van desde filtros para aire para automoviles y camionetas, buses y camiones, equipos fuera de carretera como maquinaria para la industria de la construccion construcción, para motores de la industria pesquera, equipos y maquinaria para mineria y equipos para la industria en general.</p>
    </div>
    <div class="col-span-1">
      <div class="flex flex-col items-center justify-center gap-4 p-8 bg-gray-800 rounded-lg">
        <img class="w-full max-w-full" src="{{ asset('products/img/bodegon-aire.png') }}" alt="bodegon filtros de aire"/>
        <div class="flex justify-end w-full">
          <a href="{{ route('productos.index') }}" class="flex items-center text-lg font-semibold text-white">Ver catálogo completo <i class="las la-angle-right"></i></a>
        </div>
      </div>
    </div>
  </section>
</main>
@endsection