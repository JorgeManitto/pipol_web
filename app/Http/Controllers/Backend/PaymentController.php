<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class PaymentController extends Controller
{
        public function generarLink()
    {
        // dd(config('services.mercadopago.token'));
       MercadoPagoConfig::setAccessToken(config('services.mercadopago.token'));

    $client = new PreferenceClient();
    // dd($client);
    try {
    $preference = $client->create([
        "items" => [
            [
                "title" => "Producto de prueba",
                "quantity" => 1,
                "unit_price" => 1500
            ]
        ],
        // "back_urls" => [
        //     "success" => route('mp.success'),
        //     "failure" => route('mp.failure'),
        //     "pending" => route('mp.pending'),
        // ],
        // "auto_return" => "approved",
    ]);

    } catch (\MercadoPago\Exceptions\MPApiException $e) {
        dd($e->getApiResponse()); // Esto te muestra el error real
    }

    return $preference->init_point; // Link de pago
    }
}
