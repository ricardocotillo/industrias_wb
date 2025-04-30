<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Filters\ProductoFilter;
use Illuminate\Http\Request;

class ProductoAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        info(request()->all());
        $filter = new ProductoFilter(request());
        $query = $filter->apply(Producto::query());
        $productos = $query->distinct()->orderBy('codigo')->paginate(10);
        return response()->json($productos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
}
