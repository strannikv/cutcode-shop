<?php

namespace Domain\Order\States;

class PaidOrderState extends OrderState
{
    protected array $allowedTransitions = [
        CanceledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'paid';
    }

    public function humenValue(): string
    {
        return 'Оплачен';
    }
}
