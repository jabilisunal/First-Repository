<?php

namespace App\Billings\Contracts;

use App\Models\Customer;

interface PaymentGatewayInterface
{
    /**
     * @param string $method
     * @param mixed $data
     * @param mixed $extra
     * @return object
     */
    public static function create(string $method, mixed $data, mixed $extra): mixed;

    /**
     * @param array $data
     * @return array
     */
    public static function createOrder(array $data): array;

    /**
     * @param Customer $customer
     * @param $payment
     * @param array $data
     * @return mixed
     */
    public static function approveOrder(Customer $customer, $payment, array $data): array;
}