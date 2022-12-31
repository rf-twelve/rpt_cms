<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AccountController
 */
class AccountControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_displays_view()
    {
        $response = $this->get(route('account.index'));

        $response->assertOk();
        $response->assertViewIs('account.index');
    }
}
