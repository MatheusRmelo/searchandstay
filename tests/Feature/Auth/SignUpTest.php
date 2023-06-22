<?php

namespace Tests\Feature\Auth;

use Database\Seeders\Tests\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
    }

    /**
     * @dataProvider completeAndCorrectData
     */
    public function testRegisterCompleteCorrectly(string $name, string $email, string $password)
    {
        $response = $this->post('/api/auth/signup', [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertStatus(201);
    }

    /**
     * @dataProvider incompleteOrIncorrectData
     */
    public function testRegisterIncompleteOrIncorrectly(array $data)
    {
        $response = $this->post('/api/auth/signup', $data);

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors'
            ]);
    }

    public function testRegisterForbidden()
    {
        $this->seed(TestUserSeeder::class);
        $response = $this->post('/api/auth/signup', [
            'name' => 'Test 1',
            'email' => 'teste1@gmail.com',
            'password' => 'test123456',
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors'=>[
                'email'
            ]
        ]);
    }

    public function completeAndCorrectData()
    {
        return [
            'complete_1' => [
                'name' => 'Test 1',
                'email' => 'test1@gmail.com',
                'password' => 'test123456',
            ],
            'complete_2' => [
                'name' => 'Test 2',
                'email' => 'test2@gmail.com',
                'password' => 'test123456'
            ]
        ];
    }

    public function incompleteOrIncorrectData()
    {
        return [
            'without-name' => [[
                'email' => 'test1@gmail.com',
                'password' => 'test123456'
            ]],
            'without-password' => [[
                'email' => 'test2@gmail.com',
                'name' => 'Test 1'
            ]],
            'without-email' => [[
                'name' => 'Test 1',
                'password' => 'test12345',
            ]],
            'empty' => [[]],
            'invalid-email' => [[
                'name' => 'Test 1',
                'email' => 'invalid_email',
                'password' => 'test123456'
            ]],
            'password-minor-6' => [[
                'name' => 'Test 1',
                'email' => 'test1@gmail.com',
                'password' => 'short'
            ]],
        ];
    }
}
