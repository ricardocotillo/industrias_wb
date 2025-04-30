@extends('layouts.base')

@section('content')
  <main>
    <section class="container grid grid-cols-1 gap-10 py-10 mx-auto xl:grid-cols-2">
      <div class="w-full col-span-1 px-6 py-10">
        <h1 class="mb-8 text-4xl font-extrabold text-gray-900 lg:text-7xl">Transformamos la manera de proteger tu motor</h1>
        <p class="text-lg font-medium text-gray-600 lg:text-xl">con filtros diseñados para maximizar el rendimiento y la durabilidad de cualquier vehículo. Ya sea aire, gasolina o aceite, cada filtro combina innovación y calidad para garantizar un motor más limpio y eficiente. Nuestra tecnología asegura que cada componente esté protegido, brindando confianza y potencia en cada trayecto. Confía en quienes cuidan lo esencial, confia en la perfección que filtra.</p>
      </div>
      <div class="flex justify-center w-full col-span-1 gap-8 overflow-hidden xl:justify-end flex-nowrap">
        <div class="pt-36 shrink-0">
          <img class="rounded-xl w-36 h-36 md:w-64 md:h-64 xl:w-72 xl:h-72" src="{{ asset('img/1.jpg') }}" alt="autos"/>
          <img class="mt-8 rounded-xl w-36 h-36 md:w-64 md:h-64 xl:h-72 xl:w-72" src="{{ asset('img/2.jpg') }}" alt="camioneta"/>
        </div>
        <div class="pb-36 shrink-0">
          <img class="rounded-xl w-36 h-36 md:w-64 md:h-64 xl:w-72 xl:h-72" src="{{ asset('img/3.jpg') }}" alt="auto y camioneta"/>
          <img class="mt-8 rounded-xl w-36 h-36 md:w-64 md:h-64 xl:h-72 xl:w-72" src="{{ asset('img/4.jpg') }}" alt="camion"/>
        </div>
      </div>
    </section>
    <section class="flex flex-col px-6 py-32 text-white bg-gray-900 lg:py-10 lg:px-8">
      <div class="grid w-full max-w-6xl grid-cols-1 mx-auto gap-x-8 gap-y-10 md:grid-cols-3">
        <div>
          <h2 class="mb-4 text-4xl font-bold font-helvetica">Objetivos de Calidad</h2>
          <ul class="flex flex-col gap-2 pl-4 text-xl list-disc">
            <li>Satisfacer los requisitos de nuestros clientes.</li>
            <li>Mejorar nuestros indicadores de procesos</li>
            <li>Aumentar la variedad de nuestros productos</li>
            <li>Fomentar la competencia de nuestro personal</li>
          </ul>
        </div>
        <img class="mx-auto w-80" src="{{ asset('img/sello-mini.svg') }}" alt="sello de calidad willy busch">
        <div>
          <h2 class="mb-4 text-4xl font-bold font-helvetica">Nuestros Valores</h2>
          <ul class="flex flex-col gap-2 pl-4 text-xl list-disc">
            <li>Trabajo en equipo.</li>
            <li>Colaboración.</li>
            <li>Disciplina.</li>
            <li>Orden.</li>
            <li>Honestidad.</li>
            <li>Eficiencia.</li>
            <li>Respeto.</li>
            <li>Fe.</li>
          </ul>
        </div>
        <div class="col-span-1 text-left lg:text-center lg:col-span-3">
          <h2 class="mb-4 text-4xl font-bold font-helvetica">Políticas de calidad</h2>
          <p class="text-xl">En Industrias Willy Busch S.A. buscamos la mejora continua de nuestro sistema de  gestión de la calidad, y es nuestro compromiso satisfacer los requisitos de nuestros clientes ofreciendo calidad y variedad en nuestros productos y servicios.</p>
        </div>
      </div>
    </section>
    <section class="bg-fixed bg-center bg-no-repeat bg-cover py-60" style="background-image: url({{ asset('img/trailer.jpg') }})"></section>
    <section class="container px-6 py-20 mx-auto lg:px-8">
      <div class="flex flex-col-reverse gap-8 lg:flex-row">
        <img class="object-cover w-full bg-right aspect-video lg:w-125 rounded-xl shrink-0" src="{{ asset('img/camioneta-2.jpg') }}" alt="camioneta y filtro"/>
        <div>
          <h1 class="mb-6 text-5xl font-bold text-gray-900">Nuestra misión</h1>
          <p class="text-lg font-medium text-gray-600 lg:text-xl">Fabricar y comercializar filtros automotrices e industriales protegiendo máquinas y equipos para satisfacción de los requisitos de nuestros clientes, potenciando el valor de la empresa en base al mejoramiento continuo contando con el compromiso de sus colaboradores y contribuyendo con el bienestar de nuestra Sociedad.</p>
        </div>
      </div>
    </section>
    <section class="px-6 py-20 text-white bg-gray-900 lg:px-8">
      <div class="container flex flex-col gap-8 mx-auto lg:flex-row">
        <div>
          <h1 class="mb-6 text-5xl font-bold">Nuestra visión</h1>
          <p class="text-lg font-medium lg:text-xl">Es convertirnos en una empresa líder en la fabricación y comercialización de filtros en el mercado nacional brindando la opción más confiable en base a filtros de calidad.</p>
        </div>
        <img class="object-cover w-full bg-right aspect-video lg:w-125 rounded-xl shrink-0" src="{{ asset('img/trailer.jpg') }}" alt="trailer y filtros"/>
      </div>
    </section>
  </main>
@endsection