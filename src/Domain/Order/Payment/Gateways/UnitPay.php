<?php

namespace Domain\Order\Payment\Gateways;

use Domain\Order\Contracts\PaymentGateweyContract;
use Domain\Order\Payment\PaymentData;
use Illuminate\Http\JsonResponse;

class UnitPay implements PaymentGateweyContract
{

    public function paymentId(): string
    {
        // TODO: Implement paymentId() method.
    }

    public function configure(array $config): void
    {
        // TODO: Implement configure() method.
    }

    public function data(PaymentData $data): PaymentGateweyContract
    {
        // TODO: Implement data() method.
    }

    public function request(): mixed
    {
        // TODO: Implement request() method.
    }

    public function response(): JsonResponse
    {
        // TODO: Implement response() method.
    }

    public function url(): string
    {
        // TODO: Implement url() method.
    }

    public function validate(): bool
    {
        // TODO: Implement validate() method.
    }

    public function paid(): bool
    {
        // TODO: Implement paid() method.
    }

    public function errorMassage(): string
    {
        // TODO: Implement errorMassage() method.
    }
}