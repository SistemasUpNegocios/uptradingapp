<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;


$stripe = new StripeClient('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');

class TerminalController extends Controller
{
    public function connectionToken()
    {
        // This is your test secret API key.
        $stripe = new \Stripe\StripeClient('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');

        try {
            // The ConnectionToken's secret lets you connect to any Stripe Terminal reader
            // and take payments with your Stripe account.
            // Be sure to authenticate the endpoint for creating connection tokens.
            $connectionToken = $stripe->terminal->connectionTokens->create();
            echo json_encode(array('secret' => $connectionToken->secret));
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function capturePaymentIntent()
    {
        // This is your test secret API key.
        $stripe = new \Stripe\StripeClient('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');

        try {
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);

            $intent = $stripe->paymentIntents->capture($json_obj->payment_intent_id);

            echo json_encode($intent);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function createPaymentIntent()
    {
        $stripe = new \Stripe\StripeClient('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');

        try {
            $json_str = file_get_contents('php://input');
            $json_obj = json_decode($json_str);

            $intent = $stripe->paymentIntents->create([
                'amount' => $json_obj->amount,
                'currency' => 'usd',
                'payment_method_types' => [
                'card_present',
                ],
                'capture_method' => 'manual',
            ]);
            echo json_encode($intent);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function createLocation()
    {
        $stripe = new \Stripe\StripeClient('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');

        try {
            $location = $stripe->terminal->locations->create([
                'display_name' => 'Office NY',
                'address' => [
                'line1' => "42 Broadway Suite 12-517",
                'city' => "New York",
                'state' => "NY",
                'country' => "US",
                'postal_code' => "10004",
                ]
            ]);
            echo json_encode($location);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
