<?php

namespace Tests\Feature;

use App\Http\Controllers\PlantController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlantControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testPlantColletion(): void
    {
        $controller = new PlantController();
        $response = $controller->index(); 
        // Realize as asserções
        $this->assertEquals(200, $response->status());
    }
}
