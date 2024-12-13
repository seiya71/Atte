<?php

namespace Tests\Feature;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HelloTest extends TestCase
{
    public function testHello()
    {
        $this->assertTrue(true);

        $arr = [];
        $this->assertEmpty($arr);

        $txt = "Hello World";
        $this->assertEquals('Hello World', $txt);

        $n = random_int(0, 100);
        $this->assertLessThan(100, $n);

        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get('/');
        $response->dump();
        $response->assertStatus(200);

        $response = $this->get('/no_route');
        $response->assertStatus(404);

        User::factory()->create([
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>'test12345'
        ]);
        $this->assertDatabaseHas('users',[
            'name'=>'aaa',
            'email'=>'bbb@ccc.com',
            'password'=>'test12345'
        ]);
    }
}
