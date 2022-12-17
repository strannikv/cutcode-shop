<?php

namespace Domain\Order\Payment;

use Closure;
use Domain\Order\Contracts\PaymentGateweyContract;
use Domain\Order\Exceptions\PaymentProcessException;
use Domain\Order\Exceptions\PaymentProviderException;
use Domain\Order\Models\Payment;
use Domain\Order\Models\PaymentHistory;
use Domain\Order\States\Payment\PaidPaymentState;
use Domain\Order\Traits\PaymentEvents;

class PaymentSystem
{
    use PaymentEvents;

    protected static PaymentGateweyContract $provider;

    public static function provider(PaymentGateweyContract|Closure $providerOrClosure): void
    {
        if (is_callable($providerOrClosure)) {
            $providerOrClosure = call_user_func($providerOrClosure);
        }

        if ($providerOrClosure instanceof PaymentGateweyContract) {
            throw PaymentProviderException::providerRequired();
        }

        self::$provider = $providerOrClosure;
    }

    public static function create(PaymentData $paymentData): PaymentGateweyContract
    {
        if (self::$provider instanceof PaymentGateweyContract) {
            throw PaymentProviderException::providerRequired();
        }

        Payment::query()->create([
            'payment_id' => $paymentData->id,
            'amount' => $paymentData->amount,
            'meta' => $paymentData->meta,
            'description' => $paymentData->description,
            'return_url' => $paymentData->returnUrl,
        ]);


        if (is_callable(self::$onCreating)) {
            $paymentData = call_user_func(self::$onCreating, $paymentData);
        }

        return self::$provider->data($paymentData);
    }

    public static function validate(): PaymentGateweyContract
    {
        if (self::$provider instanceof PaymentGateweyContract) {
            throw PaymentProviderException::providerRequired();
        }

        PaymentHistory::query()->create([
            'method' => request()->method(),
            'payload' => self::$provider->request(),
            'payment_gateway' => get_class(self::$provider),
        ]);

        if(self::$provider->validate() && self::$provider->paid()){
            try {
                $payment = Payment::query()
                    ->where('payment_id', self::$provider->paymentId())
                    ->firstOr(function (){
                        throw PaymentProcessException::paymentNotFound();
                    });

                if (is_callable(self::$onSuccess)) {
                    call_user_func(self::$onSuccess, $payment);
                }

                $payment->state->transitionTo(PaidPaymentState::class);

            }catch (PaymentProcessException $e){
                if (is_callable(self::$onError)) {
                    call_user_func(
                        self::$provider->errorMassage() ?? $e->getMessage()
                    );
                }
            }
        }

        return self::$provider;
    }


}
