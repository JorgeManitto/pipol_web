<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Account;
use Stripe\AccountLink;

class StripeConnectController extends Controller
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    /**
     * Create a Stripe Connect account and redirect to onboarding
     */
    public function connect()
    {
        $user = Auth::user();

        // If they already have an account, just create a new onboarding link
        if (!$user->stripe_account_id) {
            $account = Account::create([
                'type'         => 'express',
                'country'      => 'US', // or detect from $user->country
                'email'        => $user->email,
                'capabilities' => [
                    'card_payments' => ['requested' => true],
                    'transfers'     => ['requested' => true],
                ],
            ]);

            $user->stripe_account_id = $account->id;
            $user->save();
        }

        $accountLink = AccountLink::create([
            'account'     => $user->stripe_account_id,
            'refresh_url' => route('stripe.connect.refresh'),
            'return_url'  => route('stripe.connect.callback'),
            'type'        => 'account_onboarding',
        ]);

        return redirect($accountLink->url);
    }

    /**
     * User returns after completing onboarding
     */
    public function callback()
    {
        $user = Auth::user();
        // Verify the account status
        $account = Account::retrieve($user->stripe_account_id);

        if ($account->charges_enabled && $account->payouts_enabled) {
            $user->stripe_connect_status = 'active';
            $user->save();

            return redirect()->route('profile.edit')
                ->with('success', '¡Tu cuenta de Stripe fue conectada exitosamente!');
        }

        return redirect()->route('profile.edit')
            ->with('error', 'Tu cuenta de Stripe aún no está completamente verificada. Intentá de nuevo.');
        // $user = Auth::user();
        // // $account = Account::retrieve($user->stripe_account_id);
        // // dd($account);

        // if ($user->stripe_connect_status === 'active') {
        //     return redirect()->route('profile.edit')
        //         ->with('success', '¡Tu cuenta de Stripe fue conectada exitosamente!');
        // }

        // return redirect()->route('profile.edit')
        //     ->with('success', 'Tu cuenta de Stripe está siendo verificada. Esto puede tomar unos minutos.');
    }

    /**
     * If the link expires, regenerate
     */
    public function refresh()
    {
        return $this->connect();
    }

    /**
     * Disconnect Stripe account
     */
    public function disconnect()
    {
        $user = Auth::user();
        $user->stripe_account_id = null;
        $user->stripe_connect_status = null;
        $user->save();

        return redirect()->route('profile.edit')
            ->with('success', 'Tu cuenta de Stripe fue desconectada.');
    }
}