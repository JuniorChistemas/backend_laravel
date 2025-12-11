<?php

return [
    'api_key' => env('RECAPTCHA_API_KEY', ''),
    'url_verify' => env('RECAPTCHA_URL_VERIFY', 'https://recaptchaenterprise.googleapis.com/v1/projects/portfolio-junior-vercel/assessments'),
];
