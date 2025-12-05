<?php

namespace App\Features\Properties\UseCases;

use App\Features\Properties\Contracts\PropertiesProvider;
use App\Features\Properties\Data\Property;

class ListAllProperties
{
    private PropertiesProvider $client;

    public function __construct(PropertiesProvider $client)
    {
        $this->client = $client;
    }

    public function execute(): array
    {
        $results = [];

        $response = $this->client->firstPage();
        $results = array_merge($results, $this->mapProperties($response['content'] ?? []));

        $nextPageUrl = $response['pagination']['next_page'] ?? null;

        while ($nextPageUrl) {
            $response = $this->client->fromUrl($nextPageUrl);
            $results = array_merge($results, $this->mapProperties($response['content'] ?? []));
            $nextPageUrl = $response['pagination']['next_page'] ?? null;
        }

        return $results;
    }

    private function mapProperties(array $items): array
    {
        return array_map(function ($item) {
            return new Property(
                $item['title'],
                $item['public_id'],
            );
        }, $items);
    }
}
