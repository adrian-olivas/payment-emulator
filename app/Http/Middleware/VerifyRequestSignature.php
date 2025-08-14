<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyRequestSignature
{
   public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('X-Signature');
        if (!$signature) {
            return response()->json(['error' => 'Signature missing'], 401);
        }

        $secretKey = env('PAYMENT_API_SECRET_KEY', 'your-default-secret-key');
        $payload = $request->getContent();
        $expectedSignature = hash_hmac('sha256', $payload, $secretKey);
         
    \Log::info('--- Signature Debug ---');
    \Log::info('Received Payload: ' . $payload);
    \Log::info('Secret Key Used: ' . $secretKey);
    \Log::info('Received Signature: ' . $signature);
    \Log::info('Expected Signature: ' . $expectedSignature);
    // --------------------------------

        if (!hash_equals($expectedSignature, $signature)) {
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        return $next($request);
    }
}
