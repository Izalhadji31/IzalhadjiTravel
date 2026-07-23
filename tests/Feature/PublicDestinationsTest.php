<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicDestinationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_destinasi_links_on_listing_page_resolve_to_existing_detail_pages(): void
    {
        $response = $this->get(route('public.destinasi'));

        $response->assertOk();
        $response->assertSee('Danau Kelimutu');
        $response->assertSee('Benteng Lohayong');
        $response->assertSee('Bukit Fatima');
        $response->assertSee('Pulau Komodo');

        $this->get(route('public.destinasi.detail', ['slug' => 'benteng-lohayong']))->assertOk();
        $this->get(route('public.destinasi.detail', ['slug' => 'bukit-fatima']))->assertOk();
        $this->get(route('public.destinasi.detail', ['slug' => 'pulau-komodo']))->assertOk();
        $this->get(route('public.destinasi.detail', ['slug' => 'taman-laut-17-pulau']))->assertOk();
        $this->get(route('public.destinasi.detail', ['slug' => 'bunker-jepang-rane']))->assertOk();
        $this->get(route('public.destinasi.detail', ['slug' => 'kampung-adat-kawa']))->assertOk();
    }
}
