<?php

namespace Tests\Feature\Properties;

use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class ListPropertiesCommandTest extends TestCase
{
    /**
     * @test
     **/
    public function itPrintsAllPropertyTitlesAcrossAllPages()
    {
        Http::fakeSequence()
            ->push([
                'content' => [
                    ['title' => 'Casa Bonita', 'public_id' => 'BONITA-ID'],
                    ['title' => 'Departamento Azul', 'public_id' => 'AZUL-ID'],
                ],
                'pagination' => [
                    'limit' => 2,
                    'page' => 1,
                    'total' => 4,
                    'next_page' => 'https://api.stagingeb.com/v1/properties?page=2',
                ],
            ], 200)
            ->push([
                'content' => [
                    ['title' => 'Loft Centro', 'public_id' => 'LOFT-ID'],
                    ['title' => 'Casa en la Playa', 'public_id' => 'CASA-ID'],
                ],
                'pagination' => [
                    'limit' => 2,
                    'page' => 2,
                    'total' => 4,
                    'next_page' => null,
                ],
            ], 200);

        $this->artisan('easybroker:list-properties')
            ->expectsOutput('Casa Bonita')
            ->expectsOutput('Departamento Azul')
            ->expectsOutput('Loft Centro')
            ->expectsOutput('Casa en la Playa')
            ->assertExitCode(0);
    }

    /**
     * @test
     **/
    public function itFailsWhenTheApiReturnsAnError()
    {
        Http::fake([
            'api.stagingeb.com/v1/properties*' => Http::response(
                ['message' => 'Internal Server Error'],
                500
            )
        ]);

        $this->expectException(RuntimeException::class);
        $this->artisan('easybroker:list-properties');
    }

    /**
     * @test
     **/
    public function itFailsWhenTheApiKeyIsInvalid()
    {
        Http::fake([
            'api.stagingeb.com/v1/properties*' => Http::response(
                ['message' => 'Unauthorized'],
                401
            ),
        ]);

        $this->expectException(RuntimeException::class);
        $this->artisan('easybroker:list-properties');
    }
}
