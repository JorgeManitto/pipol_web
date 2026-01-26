<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use Stripe\Customer;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
        {
            $request->validate([
                'amount' => 'required|integer|min:1',
            ]);

            Stripe::setApiKey(config('services.stripe.secret'));

            $amountUsd = $request->amount; // 75
            $amountInCents = (int) round($amountUsd * 100);
            

            $mentorialId = $request->input('profesionalId');
            $mentor = User::find($mentorialId);
            if (!$mentor) {
                return response()->json([
                    'error' => 'Mentor not found.',
                ], 404);
            }

            if ($mentor->hourly_rate) {
                $amountUsd = $mentor->hourly_rate;
                $amountInCents = (int) round($amountUsd * 100);
            }else{
                return response()->json([
                    'error' => 'Mentor hourly rate not set.',
                ], 400);
            }


            try {
                $user = auth()->user();
                $customer = Customer::create([
                    'email' => $user->email,
                    'name'  => $user->name ?? null,
                ]);
                $paymentIntent = PaymentIntent::create([
                    'amount' => $amountInCents, // en centavos
                    'currency' => 'usd',
                    'automatic_payment_methods' => [
                        'enabled' => true,
                    ],
                    'description' => 'Payment for mentor session',
                    'customer' => $customer->id,
                ]);
              
                
                $transaction = new Transaction();
                $transaction->session_id = $request->idSession; // Asigna el ID de la sesión si aplica
                $transaction->payer_id = auth()->id();
                $transaction->receiver_id = $mentor->id;
                $transaction->gateway = 'stripe';
                $transaction->gateway_transaction_id = $paymentIntent->id;
                $transaction->currency = 'usd';
                $transaction->amount = $amountUsd;
                $transaction->status = 'paid';
                $transaction->paid_at = now();
                $transaction->save();

                return response()->json([
                    'clientSecret' => $paymentIntent->client_secret,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
}
