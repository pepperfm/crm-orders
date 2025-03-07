<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Product\Requests\SaveRequest;
use App\Data\Product\Responses\ShowResponse;
use App\Services\Category\CategoryService;
use Inertia\Inertia;
use App\Services\Product\ProductService;
use App\Data\Product\Responses\IndexResponse;

class ProductController extends Controller
{
    public function __construct(public ProductService $productService)
    {
    }

    public function index(): \Illuminate\Contracts\Support\Responsable
    {
        $products = $this->productService->paginate(['category']);

        return Inertia::render('Products/Index', [
            'data' => IndexResponse::collect($products),
        ]);
    }

    public function create(CategoryService $categoryService): \Illuminate\Contracts\Support\Responsable
    {
        return Inertia::render('Products/Form', [
            'categories' => $categoryService->get(),
        ]);
    }

    public function store(SaveRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->productService->create($request);

        return to_route('products.index');
    }

    public function edit(string $id, CategoryService $categoryService): \Illuminate\Contracts\Support\Responsable
    {
        $product = $this->productService->find($id, ['category']);

        return Inertia::render('Products/Form', [
            'product' => ShowResponse::from($product),
            'categories' => $categoryService->get(),
        ]);
    }

    public function update(SaveRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->productService->update($request);

        return to_route('products.index');
    }

    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->productService->delete($id);

        return back();
    }
}
