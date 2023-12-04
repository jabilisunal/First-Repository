<?php

namespace App\Traits\Payment;

use App\Billings\PayriffPayment;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JsonException;
use Symfony\Component\HttpFoundation\Response;

trait Payriff {

    /**
     * @param array $data
     * @return array
     */
    public function createPayriff(array $data): array
    {
        $approveURL = route('payriff.callback', app()->getLocale());
        $cancelURL  = route('payment.cancel', app()->getLocale());
        $declineURL = route('payment.decline', app()->getLocale());

        return PayriffPayment::createOrder([
            'customer_id' => $data['customer_id'],
            'order_id' => $data['order_id'],
            'payment_system_id' => $data['payment_system_id'],
            'amount' => $data['amount'],
            'approveURL' => $approveURL,
            'cancelURL'  => $cancelURL,
            'declineURL' => $declineURL
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws JsonException
     */
    public function callbackPayriff(Request $request): JsonResponse
    {
        $data = json_decode(json_encode($request->all(), JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);

        if ($data['code'] === PayriffPayment::CODES['SUCCESS']) {

            $payload = $data['payload'];

            $payriffPayment = \App\Models\PayriffPayment::where([
                'orderID' => $payload['orderID'],
                'session_id' => $payload['sessionId']
            ])->whereNull('response_code')->first();

            if ($payriffPayment) {

                if ($customer = Customer::find($payriffPayment->user_id)) {

                    $approveOrder = PayriffPayment::approveOrder($customer, $payriffPayment, $payload);

                    if ($approveOrder['status']) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Payment completed successfully'
                        ], Response::HTTP_OK);
                    }

                    return response()->json([
                        'status' => false,
                        'message' => 'User not found'
                    ], Response::HTTP_UNPROCESSABLE_ENTITY);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'User not found'
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json([
                'status' => false,
                'message' => 'Transaction not found'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => false,
            'message' => 'An error occurred while making the payment.'
        ], Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}