<?php

namespace App\Features\Properties\Data;

class Property
{
    private string $title;
    private string $publicId;

    public function __construct(
        string $title,
        string $publicId
    ) {
        $this->title = $title;
        $this->publicId = $publicId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getPublicId(): string
    {
        return $this->publicId;
    }
}
