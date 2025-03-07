<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\User\UserService;
use Inertia\Inertia;
use App\Services\Product\ProductService;
use App\Services\Order\OrderService;
use App\Data\Order\Requests\StoreRequest;
use App\Data\Order\Responses\IndexResponse;
use App\Data\Order\Responses\ShowResponse;
use App\Data\Order\Requests\UpdateRequest;
use App\Enums\OrderStatusEnum;

class OrderController extends Controller
{
    public function __construct(public OrderService $orderService)
    {
    }

    public function index(): \Illuminate\Contracts\Support\Responsable
    {
        $orders = $this->orderService->paginate(['user']);

        return Inertia::render('Orders/Index', [
            'data' => IndexResponse::collect($orders),
        ]);
    }

    public function create(ProductService $productService, UserService $userService): \Illuminate\Contracts\Support\Responsable
    {
        $statuses = collect(OrderStatusEnum::cases())
            ->map(static fn(OrderStatusEnum $item) => ['key' => $item->value, 'label' => $item->getLabel()])
            ->all();

        return Inertia::render('Orders/Form', [
            'users' => $userService->get(),
            'products' => $productService->get(),
            'statuses' => $statuses,
        ]);
    }

    public function store(StoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->orderService->create($request);

        return to_route('orders.index');
    }

    public function edit(string $id, ProductService $productService, UserService $userService): \Illuminate\Contracts\Support\Responsable
    {
        $order = $this->orderService->find($id, ['product', 'user']);
        $statuses = collect(OrderStatusEnum::cases())
            ->map(static fn(OrderStatusEnum $item) => ['key' => $item->value, 'label' => $item->getLabel()])
            ->all();

        return Inertia::render('Orders/Form', [
            'order' => ShowResponse::from($order),
            'users' => $userService->get(),
            'products' => $productService->get(),
            'statuses' => $statuses,
        ]);
    }

    public function update(UpdateRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->orderService->update($request);

        return to_route('orders.index');
    }

    public function destroy(string $id): \Illuminate\Http\RedirectResponse
    {
        $this->orderService->delete($id);

        return back();
    }
}
