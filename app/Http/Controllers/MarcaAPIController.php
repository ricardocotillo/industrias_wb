<?php

namespace App\Http\Controllers;

use App\Filters\MarcaFilter;
use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = new MarcaFilter(request());
        $marcas = $filter->apply(Marca::query())->orderBy('nombre')->paginate(10);
        return response()->json($marcas);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Marca $marca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Marca $marca)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Marca $marca)
    {
        //
    }
}
