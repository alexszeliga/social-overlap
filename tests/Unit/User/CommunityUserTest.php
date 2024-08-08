<?php

namespace Tests\Unit\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Community;
use App\Models\CommunityUser;

class CommunityUserTest extends TestCase
{
    protected $user;
    protected $community;
    protected $cu;

    protected function setUp() : void {
        parent::setUp();
        $this->cu = CommunityUser::factory()->create();
    }

    public function testBasicCreation() {
        $this->assertInstanceOf(CommunityUser::class, $this->cu);
    }
    
}