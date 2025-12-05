<?php

namespace Tests\Feature\Properties;

use Illuminate\Support\Facades\Http;
use RuntimeException;
use Tests\TestCase;

class ListPropertiesAPICommandTest extends TestCase
{
    /** @test */
    public function itReturnsAPageOfPropertiesAsJson()
    {
        Http::fake([
            'api.stagingeb.com/v1/properties*' => Http::response([
                'content' => [
                    [
                        'title' => 'Casa Bonita',
                        'public_id' => 'Casa Bonita Public',
                    ],
                    [
                        'title' => 'Loft Centro',
                        'public_id' => 'Loft Centro Public',
                    ],
                ],
                'pagination' => [
                    'limit' => 20,
                    'page' => 1,
                    'total' => 2,
                    'next_page' => null,
                ],
            ], 200),
        ]);

        $response = $this->getJson('/api/properties?page=1&limit=50');

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'title' => 'Casa Bonita',
                    ],
                    [
                        'title' => 'Loft Centro',
                    ],
                ]
            ]);
    }

    /** @test */
    public function itReturns500WhenTheUnderlyingApiFails()
    {
        Http::fake([
            'api.stagingeb.com/v1/properties*' => Http::response(
                ['message' => 'Internal Server Error'],
                500
            ),
        ]);

        $response = $this->getJson('/api/properties');

        $response->assertStatus(500);
    }
}
