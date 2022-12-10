<?php

namespace Domain\Order\Processes;

use Domain\Exceptions\OrderProcessException;
use Domain\Order\Contracts\OrderProcessContract;
use Domain\Order\Models\Order;

class CheckProductQuantities implements OrderProcessContract
{

    public function handle(Order $order, $next)
    {
        foreach (cart()->items() as $item){
            if($item->product->quantity < $item->quantity){
                throw new OrderProcessException('не хватает товара');
            }
        }

        return $next($order);
    }
}
