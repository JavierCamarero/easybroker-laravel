<?php

namespace App\Features\Properties\Contracts;

interface PropertiesProvider
{
    public function firstPage(int $limit = 50): array;
    public function fromUrl(string $url): array;
}
