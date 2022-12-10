<?php

namespace Domain\Order\States;

class PendingOrderState extends OrderState
{
    protected array $allowedTransitions = [
        PaidOrderState::class,
        CanceledOrderState::class
    ];

    public function canBeChanged(): bool
    {
        return true;
    }

    public function value(): string
    {
        return 'pending';
    }

    public function humenValue(): string
    {
        return 'В ожидании';
    }
}
