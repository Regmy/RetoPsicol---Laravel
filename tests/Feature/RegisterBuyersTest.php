<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterBuyersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_buyer_can_be_registered (){

        $this->withoutExceptionHandling();

        // 1. Request
        $this->post( '/api/buyer/', [
            'name'      => 'Juan',
            'document'  => 123456,
            'email'     => 'juan@gmail.com',
        ]);

        // 2. Verify DB
        $this->assertDatabaseHas('buyers', [
            'name'      => 'Juan',
            'document'  => 123456,
            'email'     => 'juan@gmail.com',
        ]);

        // 3. Verify Json
       /*  $this->assertJsonFragment([
            'id'        => 1,
            ''
        ]); */
    }
}
