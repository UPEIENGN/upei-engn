<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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

        $products = $society->products()
            ->where('name', 'like', "%$search%")
            ->orderBy($sort, $desc ? 'desc' : 'asc')
            ->paginate($perPage);

        return Inertia::render('admin/product/Index', [
            'society' => $society,
            'products' => $products,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Society $society)
    {
        $this->authorize('create', [Product::class, $society]);

        return Inertia::render('admin/product/Create', [
            'society' => $society,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request, Society $society)
    {
        $product = $society->products()->create(
            $request->safe()->except('images')
        );

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $uploadedFile) {
                $path = $uploadedFile->store('products', 'public');

                $product->images()->create([
                    'name' => $uploadedFile->hashName(),
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'path' => $path,
                    'disk' => 'public',
                    'size' => $uploadedFile->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.societies.products.index', $society)
            ->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Society $society, Product $product)
    {
        $this->authorize('update', [Product::class, $society, $product]);

        return Inertia::render('admin/product/Edit', [
            'society' => $society,
            'product' => $product->load(['images']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Society $society, Product $product)
    {
        $product->update(
            $request->safe()->except('images')
        );

        if ($request->hasFile('images')) {
            // Remove old images
            $product->images->each(function ($image) {
                Storage::disk($image->disk)->delete($image->path);
            });
            $product->images()->delete();

            foreach ($request->file('images') as $uploadedFile) {
                $path = $uploadedFile->store('products', 'public');

                $product->images()->create([
                    'name' => $uploadedFile->hashName(),
                    'original_name' => $uploadedFile->getClientOriginalName(),
                    'path' => $path,
                    'disk' => 'public',
                    'size' => $uploadedFile->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.societies.products.index', $society)
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Society $society, Product $product)
    {
        $this->authorize('delete', [Product::class, $society, $product]);

        $product->delete();

        return back()->with('success', 'Event deleted successfully.');
    }
}
