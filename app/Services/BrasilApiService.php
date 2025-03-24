<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class BrasilApiService
{
    protected $baseUrl = 'https://brasilapi.com.br/api';

    public function getCnpjInfo(string $cnpj)
    {
        $cacheKey = 'cnpj_' . $cnpj;

        return Cache::remember($cacheKey, 3600, function () use ($cnpj) {
            $response = Http::get("{$this->baseUrl}/cnpj/v1/{$cnpj}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }
}
