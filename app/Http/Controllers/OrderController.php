<?php

namespace App\Http\Controllers;

use Domain\Order\Models\DeliveryType;
use Domain\Order\Models\PaymentMethod;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OrderController extends Controller
{
    public function index(): Factory|View|Application
    {
        $items = cart()->items();

        if ($items->isEmpty()) {
            throw new \DomainException('Корзина пуста');
        }

        return view('order.index', [
            'items' => $items,
            'payments' => PaymentMethod::query()->get(),
            'deliveries' => DeliveryType::query()->get(),
        ]);
    }


    public function handle()
    {
        return redirect()
            ->route('home');
    }
}
