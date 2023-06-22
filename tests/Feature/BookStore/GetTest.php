<?php

namespace Tests\Feature\BookStore;

use App\Models\User;
use Database\Seeders\Tests\TestBookStoreSeeder;
use Database\Seeders\Tests\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GetTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed(TestUserSeeder::class);
        $this->seed(TestBookStoreSeeder::class);
        $this->actingAs(User::find(1));
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
    }

    public function testFindAll()
    {
        $this->get('/api/book-stores')
        ->assertStatus(200);
    }

    public function testFindById()
    {
        $this->get('/api/book-stores/1')
        ->assertStatus(200)
        ->assertJsonStructure([
            'result' => [
                'id',
                'name',
                'isbn',
                'value'
            ]
        ]);
    }
}
