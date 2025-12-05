<?php

namespace App\Features\Properties\Services;

use App\Features\Properties\Contracts\PropertiesProvider;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class EasyBrokerClient implements PropertiesProvider
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.easybroker.base_url');
        $this->apiKey = config('services.easybroker.key');
    }

    public function firstPage(int $limit = 50): array
    {
        return $this->request("{$this->baseUrl}/v1/properties", [
            'limit' => $limit,
        ]);
    }

    public function fromUrl(string $url): array
    {
        return $this->request($url);
    }

    private function request(string $url, array $params = []): array
    {
        $response = Http::withHeaders([
            'X-Authorization' => $this->apiKey,
        ])->get($url, $params);

        if (!$response->successful()) {
            throw new RuntimeException("EasyBroker API error: {$response->status()} {$response->body()}");
        }

        return $response->json();
    }
}
