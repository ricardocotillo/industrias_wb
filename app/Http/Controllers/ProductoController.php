<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\ProductoModelo;
use App\Filters\ProductoFilter;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filter = new ProductoFilter(request());
        $query = $filter->apply(Producto::query());
        $products = $query->distinct()->orderBy('codigo')->paginate(10);
        # order brands by name and limit to 10 results
        $brands = Marca::orderBy('nombre')->limit(10)->get();
        # order models by name and limit to 10 results
        $models = Modelo::orderBy('nombre')->limit(10)->get();
        # from productomodelo table get the highest year and the min year
        $year_min = ProductoModelo::min('ano');
        $year_max = ProductoModelo::max('ano');
        # get next link
        $next_page_url = $products->hasMorePages() ? '/api/productos/?page=2' : null;
        $page = [
            'title' => 'Industrias Willy Busch',
            'search_description' => 'Búsqueda de productos'
        ];
        $filters = $filter->getFiltersInRequest(request());
        return view('products.products', compact('products', 'brands', 'models', 'year_min', 'year_max', 'next_page_url', 'page', 'filters'));
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
    public function store(StoreProductoRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        // Load the related models with eager loading (equivalent to select_related)
        $producto_modelos = $producto->producto_modelos()
            ->with(['modelo', 'modelo.marca'])
            ->get();
        $page = [
            'title' => 'Industrias Willy Busch',
            'search_description' => 'Detalles del producto'
        ];
        
        // Return the view with context data
        return view('products.product', [
            'producto' => $producto,
            'producto_modelos' => $producto_modelos,
            'page' => $page,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductoRequest $request, Producto $producto)
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

    public function search(Request $request)
    {
        // Apply filters (equivalent to Django's FilterSet)
        $filter = new ProductoFilter($request);
        $query = $filter->apply(Producto::query())->distinct()->orderBy('codigo');
        
        // Get paginated results (equivalent to Django's paginate_by)
        $products = $query->paginate(5);
        
        // Return view with data
        return view('products.search_results', compact('products'));
    }

    /**
     * Display the cart page
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function cart()
    {
        $page = [
            'title' => 'Industrias Willy Busch',
            'search_description' => 'Carrito de compras',
        ];
        return view('products.cart', compact('page'));
    }

    /**
     * Update the cart with product details
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cart_update(Request $request)
    {
        $code = $request->input('code');
        $count = (int) $request->input('count', 1);
        
        $product = Producto::where('code', $code)->firstOrFail();
        
        // Get cart from session or initialize empty array
        $cart = $request->session()->get('cart', []);
        
        if (isset($cart[$product->codigo])) {
            $cart[$product->codigo]['count'] += $count;
        } else {
            $cart[$product->codigo] = [
                'pk' => $product->pk,
                'code' => $product->codigo,
                'count' => $count,
            ];
        }
        
        // Save cart back to session
        $request->session()->put('cart', $cart);
        
        return response()->json($cart);
    }

    /**
     * Remove a product from the cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cart_delete(Request $request)
    {
        $code = $request->input('code');
        
        $product = Producto::where('code', $code)->firstOrFail();
        
        // Get cart from session
        $cart = $request->session()->get('cart', []);
        
        if (isset($cart[$product->codigo])) {
            unset($cart[$product->codigo]);
        }
        
        // Save cart back to session
        $request->session()->put('cart', $cart);
        
        return response('', 200);
    }

    /**
     * Display the specific product line page based on slug.
     *
     * @param  string  $slug
     * @return \Illuminate\View\View
     */
    public function line($slug)
    {
        $page = [
            'title' => 'Industrias Willy Busch',
            'search_description' => 'Linea de productos'
        ];
        return view("products.line_{$slug}", compact('page'));
    }
}
