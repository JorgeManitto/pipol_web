<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use Stripe\{Stripe, Account, AccountLink};

class StripeConnectController extends Controller
{
    public function connect()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = auth()->user();

        if (!$user->stripe_connect_id) {
            $account = Account::create([
                'type'          => 'express',
                'country'       => $user->country_code ?? 'US',
                'email'         => $user->email,
                'business_type' => 'individual',
                'capabilities'  => [
                    'card_payments' => ['requested' => true],
                    'transfers'     => ['requested' => true],
                ],
                'metadata' => ['user_id' => $user->id],
            ]);
            $user->update(['stripe_connect_id' => $account->id]);
        }

        $link = AccountLink::create([
            'account'     => $user->stripe_connect_id,
            'refresh_url' => route('fraccional.stripe.refresh'),
            'return_url'  => route('fraccional.stripe.return'),
            'type'        => 'account_onboarding',
        ]);

        return redirect($link->url);
    }

    public function return()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $user = auth()->user();

        if ($user->stripe_connect_id) {
            $account = Account::retrieve($user->stripe_connect_id);
            $user->update([
                'stripe_charges_enabled' => $account->charges_enabled,
                'stripe_payouts_enabled' => $account->payouts_enabled,
                'stripe_account_status'  => $account->charges_enabled ? 'active' : 'pending',
            ]);
        }

        return redirect()->route('profile.edit')->with('success', 'Cuenta de pagos conectada.');
    }

    public function refresh() { return $this->connect(); }
}