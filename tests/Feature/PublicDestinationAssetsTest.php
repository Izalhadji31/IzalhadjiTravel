<?php

namespace Tests\Feature;

use Tests\TestCase;

class PublicDestinationAssetsTest extends TestCase
{
    public function test_destination_detail_uses_local_asset_images(): void
    {
        $response = $this->get('/public/destinasi/danau-kelimutu');

        $response->assertOk();
        $response->assertSee('images/destinations');
    }
}
