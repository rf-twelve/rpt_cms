<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AuditTrailController
 */
class AuditTrailControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->get(route('audit-trail.index'));

        $response->assertOk();
        $response->assertViewIs('audit.index');
    }
}
