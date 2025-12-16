<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnpointContact;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EnpointContactController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EnpointContact $request)
    {
        $keyApp = config('recaptcha.api_key');
        $urlVerify = config('recaptcha.url_verify');
        
        $googleURL = $urlVerify.'?key='.$keyApp;
        $googleResponse = Http::post($googleURL,
            $request->input('recaptcha_request')
        );

        $resultRecapcha = $googleResponse->json();

        if ($resultRecapcha['tokenProperties']['action'] !== 'submit') {
            return response()->json([
                'status' => false,
                'message' => 'Acción inválida detectada en reCAPTCHA.',
            ], 422);
        }

        if ($resultRecapcha['riskAnalysis']['score'] < 0.5) {
            return response()->json([
                'status' => false,
                'message' => 'Nuestro servidor se esta encendiendo o se detecto actividad sospechosa. Intentelo nuevamente',
            ], 422);
        }

        // save customer 
        $customer = Customer::create([
            'first_name' => $request->input('name'),
            'email' => $request->input('email'),
            'description' => $request->input('message'),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Contacto recibido exitosamente.',
            'customer_id' => $customer->id,
        ], 201);

        Log::info('RECAPTCHA RESPONSE: ', $resultRecapcha);
    }
}
