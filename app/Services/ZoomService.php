<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ZoomService
{
    protected $accessToken;

    public function __construct()
    {
        $this->accessToken = $this->getAccessToken();
    }

    private function getAccessToken()
    {
        // Tenta recuperar o token de acesso do cache
        $accessToken = Cache::get('zoom_access_token');

        if (!$accessToken) {
            // Se o token não estiver em cache, gera um novo
            $accessToken = $this->generateAccessToken();

            // Armazena o token em cache por 1 hora
            Cache::put('zoom_access_token', $accessToken, now()->addHours(1));
        }

        return $accessToken;
    }

    private function generateAccessToken()
    {
        $response = Http::withBasicAuth(config('zoom.client_id'), config('zoom.client_secret'))
            ->asForm()
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => config('zoom.account_id'),
            ]);

        if ($response->successful()) {
            return $response->json()['access_token'];
        } else {
            throw new \Exception('Failed to obtain access token from Zoom: ' . $response->body());
        }
    }

    public function createMeeting($data)
    {
        $response = Http::withToken($this->accessToken)
            ->post('https://api.zoom.us/v2/users/me/meetings', $data);

        if (!$response->successful()) {
            throw new \Exception('Zoom API Error: ' . $response->body());
        }

        return $response->json();
    }
}