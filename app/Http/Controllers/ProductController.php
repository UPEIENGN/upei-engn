<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Society;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Society $society)
    {
        $this->authorize('viewAny', [Product::class, $society]);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search', '');
        $sort = $request->input('sort', 'created_at');
        $desc = $request->boolean('desc', true);

        $members = $society->products()
            ->where('name', 'like', "%$search%")
            ->orderBy($sort, $desc ? 'desc' : 'asc')
            ->paginate($perPage);

        return Inertia::render('admin/product/Index', [
            'society' => $society,
            'products' => $members,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Society $society)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, Society $society)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society, Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Society $society, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Society $society, Product $product)
    {
        //
    }
}
