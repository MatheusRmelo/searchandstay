<?php

namespace Tests\Feature\BookStore;

use App\Models\User;
use Database\Seeders\Tests\TestBookStoreSeeder;
use Database\Seeders\Tests\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UpdateTest extends TestCase
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

    /**
     * @dataProvider correctlyData
     */
    public function testSuccessUpdate(array $data)
    {
        $this->put('/api/book-stores/1', $data)
        ->assertStatus(200);
        $validate = ['id' => 1];
        if(isset($data['name'])){
            $validate['name'] = $data['name'];
        }
        $this->assertDatabaseHas('book_stores', $validate);
    }

    /**
     * @dataProvider invalidData
     */
    public function testInvalidStore(array $data)
    {
        $this->put('/api/book-stores/1', $data)
        ->assertStatus(422);
    }

    public function correctlyData()
    {
        return [
            'complete' => [[
                'name' => 'Book Test Update',
                'isbn' => 97831614842120,
                'value' => 99.99,
            ]],
            'only-name' => [[
                'name' => 'Book Test Update',
            ]],
            'only-isbn' => [[
                'isbn' => 97831614842120,
                'value' => 99.99,
            ]],
            'only-value' => [[
                'value' => 99.99,
            ]],
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
        ];
    }
}
