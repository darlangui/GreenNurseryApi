<?php

namespace Tests\Feature;

use App\Http\Controllers\FreightController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FreightControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testFreightColletion(): void
    {
        $controller = new FreightController();
        $response = $controller->index(); 
        // Realize as asserções
        $this->assertEquals(200, $response->status());
    }
}
