<?php
namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Fraccional\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Stripe\{Stripe, Webhook};

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $event = Webhook::constructEvent(
                $request->getContent(),
                $request->header('Stripe-Signature'),
                config('services.stripe.webhook_secret')
            );
        } catch (\Throwable $e) {
            return response('Invalid signature', 400);
        }

        match ($event->type) {
            'payment_intent.succeeded'      => $this->paid($event->data->object),
            'payment_intent.payment_failed' => $this->failed($event->data->object),
            'account.updated'               => $this->accountUpdated($event->data->object),
            'transfer.failed'               => $this->transferFailed($event->data->object),
            default => null,
        };

        return response('', 200);
    }

    protected function paid($pi): void
    {
        $tx = Transaction::where('stripe_payment_intent_id', $pi->id)->first();
        if (!$tx || $tx->status === 'held') return;

        $tx->update([
            'status'           => 'held',
            'stripe_charge_id' => $pi->latest_charge,
            'paid_at'          => now(),
        ]);

        $tx->contract->update(['status' => 'active']);
        $tx->engagement->update(['status' => 'active', 'activated_at' => now()]);
        
        \App\Services\Fraccional\ChatSystemMessenger::post($tx->engagement, 'payment_completed');

        // $tx->professional->notify(new ServiceActivated($tx));
    }

    protected function failed($pi): void
    {
        Transaction::where('stripe_payment_intent_id', $pi->id)
            ->update(['status' => 'failed']);
    }

    protected function accountUpdated($account): void
    {
        User::where('stripe_connect_id', $account->id)->update([
            'stripe_charges_enabled' => $account->charges_enabled,
            'stripe_payouts_enabled' => $account->payouts_enabled,
            'stripe_account_status'  => $account->charges_enabled ? 'active' : 'pending',
        ]);
    }
    protected function transferFailed($transfer): void
{
    $tx = Transaction::where('stripe_transfer_id', $transfer->id)->first();
    if (!$tx) return;

    $tx->update([
        'status'        => 'held', // volver al estado anterior
        'release_notes' => 'Transfer falló: ' . ($transfer->failure_message ?? 'unknown'),
    ]);
    // no olvidar agregar la notificación al admin
}
}