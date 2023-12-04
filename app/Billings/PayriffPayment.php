<?php

namespace App\Billings;

use App\Billings\Contracts\PaymentGatewayInterface;
use App\Models\Customer;
use App\Models\Order;
use App\Models\PaymentSystem;
use App\Models\TransactionType;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use JsonException;

class PayriffPayment implements PaymentGatewayInterface
{
    /**
     * @const URL
     */
    public const URL = 'https://api.payriff.com/api/v2/';

    /**
     * @const NAME
     */
    public const NAME = 'payriff';

    /**
     * @const SECRET
     */
    //public const SECRET = '08CF84DA89EA4DD8B270C0F613F9D146';
    public const SECRET = '5E94CE2739FE4DC898631C2F97DD0ACF';

    /**
     * @const MERCHANT
     */
    // public const MERCHANT = 'ES1090827';
    public const MERCHANT = 'ES1090826';

    /**
     * @const DEFAULT
     */
    public const DEFAULT = [
        'CURRENCY' => 'AZN',
        'LANGUAGE' => 'AZ',
        'DESCRIPTION' => 'Trendshop order complete'
    ];

    /**
     * @const CODES
     */
    public const CODES = [
        'SUCCESS' => "00000",
        'WARNING' => "01000",
        'ERROR' => "15000",
        'INVALID_PARAMETERS' => "15400",
        'UNAUTHORIZED' => "14010",
        'TOKEN_NOT_PRESENT' => "14013",
        'INVALID_TOKEN' => "14014"
    ];

    /**
     * @param string $method
     * @param $data
     * @param $extra
     * @return object
     */
    public static function create(string $method, $data, $extra): object
    {
        return Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => self::SECRET
        ])->post(self::URL.$method, [
            'body' => $data,
            'merchant' => self::MERCHANT,
            'encryptionToken' => $extra['encryption_token']
        ])->object();
    }

    /**
     * @param array $data
     * @return array
     */
    public static function createOrder(array $data): array
    {
        $response = self::create('createOrder', [
            'amount' => $data['amount'],
            'currencyType' => self::DEFAULT['CURRENCY'],
            'description' => self::DEFAULT['DESCRIPTION'],
            'language' => self::DEFAULT['LANGUAGE'],
            'approveURL' => $data['approveURL'],
            'cancelURL' => $data['cancelURL'],
            'declineURL' => $data['declineURL']
        ], [
            'encryption_token' => time().mt_rand()
        ]);

        if ($response->code === self::CODES['SUCCESS']) {

            PaymentService::create(self::NAME, [
                'customer_id' => $data['customer_id'],
                'payment_system_id' => $data['payment_system_id'],
                'order_id' => $data['order_id'],
                'orderID' => $response->payload->orderId ?? NULL,
                'session_id' => $response->payload->sessionId ?? NULL,
                'payriff_transaction_id' => $response->payload->transactionId ?? NULL,
                'transaction_type' => $response->payload->transactionType ?? NULL,
                'purchase_amount' => $response->payload->purchaseAmount ?? NULL,
                'currency' => $response->payload->currency ?? NULL,
                'tran_date_time' => $response->payload->tranDateTime ?? NULL,
                'response_code' => $response->payload->responseCode ?? NULL,
                'response_description' => $response->payload->responseDescription ?? NULL,
                'brand' => $response->payload->brand ?? NULL,
                'order_status' => $response->payload->orderStatus ?? NULL,
                'approval_code' => $response->payload->approvalCode ?? NULL,
                'acq_fee' => $response->payload->acqFee ?? NULL,
                'order_description' => $response->payload->orderDescription ?? NULL,
                'approval_code_scr' => $response->payload->approvalCodeScr ?? NULL,
                'purchase_amount_scr' => $response->payload->purchaseAmountScr ?? NULL,
                'currency_scr' => $response->payload->currencyScr ?? NULL,
                'order_status_scr' => $response->payload->orderStatusScr ?? NULL,
                'card_registration_response' => $response->payload->cardRegistrationResponse ?? NULL,
                'rrn' => $response->payload->rrn ?? NULL,
                'pan' => $response->payload->pan ?? NULL,
                'card_holder_name' => $response->payload->cardHolderName ?? NULL,
                'card_uid' => $response->payload->cardUID ?? NULL,
            ]);

            return [
                'status' => true,
                'data' => [
                    'url' =>  $response->payload->paymentUrl
                ]
            ];
        }

        return [
            'status' => false,
            'message' => $response->message
        ];
    }

    /**
     * @throws JsonException
     */
    public static function approveOrder(Customer $customer, $payment, array $data): array
    {
        DB::beginTransaction();

        $updatePaymentService = PaymentService::update(self::NAME, $payment, [
            'payriff_transaction_id' => $data['transactionId'] ?? NULL,
            'transaction_type' => $data['transactionType'] ?? NULL,
            'purchase_amount' => $data['purchaseAmount'] ?? NULL,
            'currency' => $data['currency'] ?? NULL,
            'tran_date_time' => $data['tranDateTime'] ?? NULL,
            'response_code' => $data['responseCode'] ?? NULL,
            'response_description' => $data['responseDescription'] ?? NULL,
            'brand' => $data['brand'] ?? NULL,
            'order_status' => $data['orderStatus'] ?? NULL,
            'approval_code' => $data['approvalCode'] ?? NULL,
            'acq_fee' => $data['acqFee'] ?? NULL,
            'order_description' => $data['orderDescription'] ?? NULL,
            'approval_code_scr' => $data['approvalCodeScr'] ?? NULL,
            'purchase_amount_scr' => $data['purchaseAmountScr'] ?? NULL,
            'currency_scr' => $data['currencyScr'] ?? NULL,
            'order_status_scr' => $data['orderStatusScr'] ?? NULL,
            'card_registration_response' => $data['cardRegistration'] ? json_encode($data['cardRegistration'], JSON_THROW_ON_ERROR) : NULL,
            'rrn' => $data['RRN'] ?? NULL,
            'pan' => $data['PAN'] ?? NULL,
            'card_holder_name' => $data['CardHolderName'] ?? NULL,
            'card_uid' => $data['cardRegistration']['CardUID'] ?? NULL
        ]);

        if ($updatePaymentService) {

            $payment->fresh();

            $createPayment = PaymentService::createPayment([
                "order_id" => $payment->order_id,
                'customer_id' => $customer->id,
                'payment_system_id' => PaymentSystem::PAYRIFF,
                'payment_id' => $payment->id,
                'amount' => round((float) $payment->purchase_amount_scr, 2),
                'currency_id' =>  9,
                'pan' =>  $payment->pan,
                'card_type' =>  $payment->brand
            ]);

            if ($createPayment) {

                $createTransaction = PaymentService::createTransaction([
                    "order_id" =>$payment->order_id,
                    "customer_id" => $customer->id,
                    "payment_system_id" => PaymentSystem::PAYRIFF,
                    "currency_id" => 9,
                    "amount" => $createPayment->amount,
                    "status" => 1
                ]);

                if ($createTransaction) {

                    Order::find($payment->order_id)->update(['status' => 1, 'is_pay' => 1]);

                    DB::commit();

                    return [
                        'status' => true,
                        'message' => 'Complete transaction'
                    ];
                }

                DB::rollBack();

                return [
                    'status' => false,
                    'message' => 'An error occurred while creating the transaction'
                ];
            }

            DB::rollBack();

            return [
                'status' => false,
                'message' => 'An error occurred while creating the payment'
            ];
        }

        DB::rollBack();

        return [
            'status' => false,
            'message' => 'Payment callback data is invalid'
        ];
    }
}