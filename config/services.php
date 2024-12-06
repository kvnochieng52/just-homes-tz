<?php

use Illuminate\Support\Facades\File;
use Firebase\JWT\JWT;

function generateAppleClientSecret($keyId, $teamId, $clientId, $privateKey)
{
    $now = time();
    $expirationTime = $now + 15777000; // 6 months

    $payload = [
        'iss' => $teamId,
        'iat' => $now,
        'exp' => $expirationTime,
        'aud' => 'https://appleid.apple.com',
        'sub' => $clientId,
    ];

    return JWT::encode($payload, $privateKey, 'ES256', $keyId);
}

return [

    'apple' => [
        'client_id' => env('APPLE_CLIENT_ID'), // Your Service ID
        'team_id' => env('APPLE_TEAM_ID'), // Your Team ID
        'key_id' => env('APPLE_KEY_ID'), // Your Key ID
        'client_secret' => generateAppleClientSecret(
            env('APPLE_KEY_ID'),
            env('APPLE_TEAM_ID'),
            env('APPLE_CLIENT_ID'),
            file_get_contents(public_path(env('APPLE_PRIVATE_KEY_PATH'))) // Load private key from public folder
        ),
        'redirect' => 'https://justhomes.co.ke/auth/apple', // Redirect URI
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => 'https://justhomes.co.ke/login/google/callback',
    ],

    'facebook' => [
        'client_id' => '',
        'client_secret' => '',
        'redirect' => 'http://localhost:8000/login/facebook/callback',
    ],


];
