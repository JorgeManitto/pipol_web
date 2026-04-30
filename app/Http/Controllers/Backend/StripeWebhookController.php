<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Webhook;

class StripeWebhookController extends Controller
{
    public function handleConnect(Request $request)
    {
        \Log::info('Stripe webhook received', [
            'headers' => $request->headers->all(),
            'body_length' => strlen($request->getContent()),
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        \Log::info('Stripe signature header', ['sig' => $sigHeader]);

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.connect_webhook_secret')
            );
        } catch (\Exception $e) {
            \Log::error('Stripe webhook signature failed', [
                'error' => $e->getMessage(),
                'secret_starts_with' => substr(config('services.stripe.connect_webhook_secret'), 0, 10),
            ]);
            return response('Invalid signature', 400);
        }

        \Log::info('Stripe event parsed', [
            'type' => $event->type,
            'account_id' => $event->data->object->id ?? null,
        ]);

        if ($event->type === 'account.updated') {
            $account = $event->data->object;

            $user = User::where('stripe_connect_id', $account->id)->first();

            \Log::info('Stripe account.updated', [
                'stripe_connect_id' => $account->id,
                'charges_enabled' => $account->charges_enabled,
                'payouts_enabled' => $account->payouts_enabled,
                'user_found' => $user ? $user->id : 'NOT FOUND',
            ]);

            if ($user) {
                if ($account->charges_enabled && $account->payouts_enabled) {
                    $user->stripe_connect_status = 'active';
                } else {
                    $user->stripe_connect_status = 'pending';
                }
                $user->save();

                \Log::info('User stripe status updated', [
                    'user_id' => $user->id,
                    'new_status' => $user->stripe_connect_status,
                ]);
            }
        }

        return response('OK', 200);
    }
}