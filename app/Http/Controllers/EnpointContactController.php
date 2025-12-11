<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnpointContact;
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

        Log::info('RECAPTCHA RESPONSE: ', $resultRecapcha);
    }
}
