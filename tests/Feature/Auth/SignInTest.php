<?php

namespace Tests\Feature\Auth;

use Database\Seeders\Tests\TestUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withHeaders([
            'Accept' => 'application/json'
        ]);
        $this->seed(TestUserSeeder::class);
    }

    /**
     * Test login with valid credentials and expect a successful login.
     *
     * @dataProvider validLoginProviderData
     * @return void
     */
    public function testLoginSuccess(string $email, string $password)
    {
        $response = $this->post('/api/auth/signin', [
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertStatus(200);
    }

    /**
     * Test login with invalid credentials and expect an unauthorized response.
     *
     * @dataProvider unauthorizedLoginProviderData
     * @return void
     */
    public function testLoginUnauthorized(string $email, string $password)
    {
        $response = $this->post('/api/auth/signin', [
            'email' => $email,
            'password' => $password,
        ]);
        $response->assertStatus(422);
        $response->assertJsonStructure([
            'errors' => [
                'email',
                'password'
            ]
        ]);
    }

    /**
     * Test login with incomplete information and expect a validation error response.
     *
     * @dataProvider incompleteLoginProviderData
     * @return void
     */
    public function testLoginIncomplete(array $data)
    {
        $response = $this->post('/api/auth/signin', $data);
        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors'
            ]);
    }

    /**
     * Data provider for valid login scenarios.
     *
     * @return array
     */
    public function validLoginProviderData()
    {
        return [
            'complete-1' => [
                'email' => 'teste1@gmail.com',
                'password' => 'teste123456',
            ],
            'complete-2' => [
                'email' => 'teste2@gmail.com',
                'password' => 'teste123456',
            ]
        ];
    }

    /**
     * Data provider for unauthorized login scenarios.
     *
     * @return array
     */
    public function unauthorizedLoginProviderData()
    {
        return [
            'wrong-password' => [
                'email' => 'teste1@gmail.com',
                'password' => 'teste12345',
            ],
            'wrong-email' => [
                'email' => 'weqweqw@gmail.com',
                'password' => 'teste123456',
            ]
        ];
    }

    /**
     * Data provider for incomplete login scenarios.
     *
     * @return array
     */
    public function incompleteLoginProviderData()
    {
        return [
            'incomplete-without-password' => [
                [
                    'email' => 'teste2@gmail.com',
                    'password' => '',
                ]
            ],
            'incomplete-without-email' => [
                [
                    'email' => '',
                    'password' => 'teste12345',
                ]
            ],
            'empty' => [[]]
        ];
    }
}
