<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Filters\ModeloFilter;
use Illuminate\Http\Request;

class ModeloAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = new ModeloFilter(request());
        $modelos = $filter->apply(Modelo::query())->orderBy('nombre')->paginate(10);
        return response()->json($modelos);
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
    public function show(Modelo $modelo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modelo $modelo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modelo $modelo)
    {
        //
    }
}
