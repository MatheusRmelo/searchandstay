<?php

namespace Tests\Feature\BookStore;

use App\Models\User;
use Database\Seeders\Tests\TestBookStoreSeeder;
use Database\Seeders\Tests\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTest extends TestCase
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

    public function testSuccessUpdate()
    {
        $this->delete('/api/book-stores/1')
        ->assertStatus(204);
        //$this->assertDatabaseMissing('book_stores', ['id' => 1]);
    }

    public function testNotExists()
    {
        $this->delete('/api/book-stores/1423')
        ->assertStatus(404);
    }
}
