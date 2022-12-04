<?php

namespace Domain\Cart;

use Domain\Cart\Contracts\CartIdentityStorageContract;
use Domain\Cart\Models\Cart;
use Domain\Cart\Models\CartItem;
use Domain\Product\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Support\ValueObjects\Price;

class CartManager
{
    public function __construct(
        protected CartIdentityStorageContract $identityStorage
    ) {
    }


    private function cachKey(): string
    {
        return str('cart_' . $this->identityStorage->get())
            ->slug('-')
            ->value();
    }


    private function forgetCach()
    {
        Cache::forget($this->cachKey());
    }


    private function cach()
    {

    }


    private function storageData(string $id)
    {
        $data = [
            'storage_id' => $id
        ];

        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        }

        return $data;
    }


    private function stringedOptionValues(array $optionValues = []): string
    {
        sort($optionValues);

        return implode(';', $optionValues);
    }





    public function quantity(CartItem $item, int $quantity = 1): void
    {
        $item->update([
            'quantity' => $quantity,
        ]);

        $this->forgetCach();
    }


    public function delete(CartItem $item): void
    {
        $item->delete();

        $this->forgetCach();
    }


    public function truncate(): void
    {
        $this->get()?->delete();

        $this->forgetCach();
    }


    public function cartItems(): \Illuminate\Support\Collection
    {
        return $this->get()?->cartItems ?? collect([]);
    }

    public function items(): \Illuminate\Support\Collection
    {
        if (!$this->get()){
            return collect([]);
        }

        return CartItem::query()
            ->with(['product', 'optionValues.option'])
            ->whereBelongsTo($this->get())
            ->get();
    }




    public function count(): int
    {
        return $this->cartItems()->sum(function ($item) {
            return $item->quantity;
        });
    }


    public function amount(): Price
    {
        return Price::make(
            $this->cartItems()->sum(function ($item) {
                return $item->amount->raw();
            })
        );
    }


    public function get()
    {
        return Cache::remember($this->cachKey(), now()->addHour(), function (){
            return Cart::query()
                ->with('cartItems')
                ->where('storage_id', $this->identityStorage->get())
                ->when(auth()->check(), fn(Builder $query) => $query->orWhere(
                    'user_id',
                    auth()->id()
                ))
                ->first() ?? false;
        });
    }


    public function add(Product $product, int $quantity = 1, array $optionValues): Model|Builder
    {
        $cart = Cart::query()
            ->updateOrCreate(
                [
                    'storage_id' => $this->identityStorage->get()
                ],
                $this->storageData($this->identityStorage->get())
            );


        $cartItem = $cart->cartItems()
            ->updateOrCreate(
                [
                    'product_id' => $product->getKey(),
                    'string_option_values' => $this->stringedOptionValues($optionValues),
                ],
                [
                    'price' => $product->price,
                    'quantity' => DB::raw("quantity + $quantity"),
                    'string_option_values' => $this->stringedOptionValues($optionValues),
                ]
            );

        $cartItem->optionValues()->sync($optionValues);

        $this->forgetCach();

        return $cart;
    }


}
