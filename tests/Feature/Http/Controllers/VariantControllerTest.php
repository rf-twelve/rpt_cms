<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VariantController
 */
class VariantControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->get(route('variant.index'));

        $response->assertOk();
        $response->assertViewIs('variant.index');
    }
}
