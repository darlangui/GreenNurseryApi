<?php

namespace Tests\Feature;

use App\Http\Controllers\PursheseController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PursheseControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPursheseColletion(): void
    {
        $controller = new PursheseController();
        $response = $controller->index(); 
        // Realize as asserções
        $this->assertEquals(200, $response->status());
    }
}
