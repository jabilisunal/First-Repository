<?php

namespace App\Services;

use RuntimeException;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\MagnetPayment;
use App\Models\PayriffPayment;

class PaymentService {

    /**
     * @const PAYRIFF
     */
    public const PAYRIFF = 'payriff';

    /**
     * @param $name
     * @param $data
     * @return mixed
     */
    public static function create($name, $data): mixed
    {
        return match ($name) {
            self::PAYRIFF => self::createPayriff($data),
            default => throw new RuntimeException('Payment System Not Found'),
        };
    }

    /**
     * @param string $name
     * @param PayriffPayment $payment
     * @param array $data
     * @return bool
     */
    public static function update(string $name, PayriffPayment $payment, array $data): bool
    {
        return match ($name) {
            self::PAYRIFF => self::updatePayriff($payment, $data),
            default => throw new RuntimeException('Payment System Not Found'),
        };
    }

    /**
     * @param array $data
     * @return mixed
     */
    public static function createPayriff(array $data): mixed
    {
        return PayriffPayment::create($data);
    }

    /**
     * @param PayriffPayment $payriffPayment
     * @param array $data
     * @return bool
     */
    public static function updatePayriff(PayriffPayment $payriffPayment, array $data): bool
    {
        return $payriffPayment->update($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public static function createTransaction(array $data): mixed
    {
        return Transaction::create($data);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public static function createPayment(array $data): mixed
    {
        return Payment::create($data);
    }
}