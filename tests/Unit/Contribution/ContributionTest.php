<?php

namespace Tests\Unit\Contribution;

use Tests\TestCase;
use App\Models\Contribution;


class ContributionTest extends TestCase
{
    protected $contribution;

    protected function setUp() : void {
        parent::setUp();
        $this->contribution = Contribution::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(Contribution::class, $this->contribution);
    }
   
}