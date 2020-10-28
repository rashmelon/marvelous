<?php

namespace Tests\Feature\Models;

use App\Models\Brand;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SourceTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testBelongsToBrand()
    {
        $this->assertInstanceOf(
            Brand::class,
            Source::factory()->create()->brand
        );
    }
}
