<?php

namespace App\Controllers;

use Midtrans\Config;
use Midtrans\Transaction;
use App\Models\TransactionModel;

class PaymentController extends BaseController
{
    public function __construct()
    {
        // Initialize Midtrans Configuration
        $midtrans = new \Config\Midtrans();
        Config::$serverKey = $midtrans->serverKey;
        Config::$isProduction = $midtrans->isProduction;
    }

    // Charge payment
    public function charge()
    {
        $data = $this->request->getPost();

        // Set payment details
        $params = [
            'transaction_details' => [
                'order_id' => rand(),
                'gross_amount' => $data['amount'],
            ],
            'customer_details' => [
                'first_name' => $data['first_name'],
                'email' => $data['email'],
            ],
        ];

        try {
            $charge = \Midtrans\Snap::createTransaction($params);
            return $this->respond(['status' => 'success', 'redirect_url' => $charge->redirect_url]);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }

    // Payment notification handler
    public function notification()
    {
        $notification = new \Midtrans\Notification();

        $transaction = $notification->transaction_status;
        $order_id = $notification->order_id;
        $fraud_status = $notification->fraud_status;

        // Process transaction status
        if ($transaction == 'capture') {
            if ($fraud_status == 'accept') {
                // Payment success
                // Update transaction status in the database
            }
        } else if ($transaction == 'settlement') {
            // Payment success
            // Update transaction status in the database
        } else if ($transaction == 'pending') {
            // Payment pending
        } else if ($transaction == 'deny') {
            // Payment failed
        }

        return $this->respond(['status' => 'success']);
    }
}
