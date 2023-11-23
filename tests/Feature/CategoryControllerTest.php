<?php

namespace Tests\Feature;

use App\Http\Controllers\CategoryController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CategoryControllerTest extends TestCase
{

    use RefreshDatabase;

    public function testCategoryColletion(): void
    {
        $controller = new CategoryController();
        $response = $controller->index(); 
        // Realize as asserções
        $this->assertEquals(200, $response->status());
    }

}
