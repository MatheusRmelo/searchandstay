<?php

namespace Tests\Feature\BookStore;

use App\Models\User;
use Database\Seeders\Tests\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp() : void
    {
        parent::setUp();
        $this->seed(TestUserSeeder::class);
        $this->actingAs(User::find(1));
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
    }

    /**
     * @dataProvider correctlyData
     */
    public function testSuccessStore(array $data)
    {
        $this->post('/api/book-stores', $data)
        ->assertStatus(201);
    }

    /**
     * @dataProvider incompleteData
     */
    public function testIncompleteStore(array $data)
    {
        $this->post('/api/book-stores', $data)
        ->assertStatus(422);
    }

   /**
     * @dataProvider invalidData
     */
    public function testInvalidStore(array $data)
    {
        $this->post('/api/book-stores', $data)
        ->assertStatus(422);
    }

    public function correctlyData()
    {
        return [
            'complete' => [[
                'name' => 'Book Test 1',
                'isbn' => 9783161484100,
                'value' => 30.99,
            ]],
        ];
    }

    public function incompleteData()
    {
        return [
            'without-name' => [[
                'isbn' => 9783161484100,
                'value' => 30.99,
            ]],
            'without-isbn' => [[
                'name' => 'Book Test 1',
                'value' => 30.99,
            ]],
            'without-value' => [[
                'name' => 'Book Test 1',
                'isbn' => 9783161484100,
            ]],
            'empty' => [[]],
        ];
    }

    public function invalidData()
    {
        return [
            'isbn-string' => [[
                'name' => 'Book Test 1',
                'isbn' => 'ewqewq',
                'value' => 30.99,
            ]],
            'value-string' => [[
                'name' => 'Book Test 1',
                'isbn' => 9783161484100,
                'value' => 'eqewq',
            ]],
            'isbn-short' => [[
                'name' => 'Book Test 1',
                'isbn' => 978316148,
                'value' => 30.99,
            ]],
            'isbn-bigger' => [[
                'name' => 'Book Test 1',
                'isbn' => 97831614841001,
                'value' => 30.99,
            ]],
        ];
    }
}
