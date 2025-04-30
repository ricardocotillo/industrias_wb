<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoModeloRequest;
use App\Http\Requests\UpdateProductoModeloRequest;
use App\Models\ProductoModelo;

class ProductoModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $producto_modelos = ProductoModelo::orderBy('id')->paginate(10);
        return response()->json($producto_modelos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoModeloRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductoModelo $productoModelo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductoModelo $productoModelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoModeloRequest $request, ProductoModelo $productoModelo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductoModelo $productoModelo)
    {
        //
    }
}
