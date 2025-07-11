<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testOpenRegisterPage()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function testRegisterNewUser()
    {

        $response = $this->post('/register', [
            'name' => 'New User',
            'email' => 'test@gmail.com',
            'password' => '123456789a',
            'password_confirmation' => '123456789a',
        ]);
        $response->assertRedirect('/admin/users');

    }

    public static function registrationDataProvider(): array
    {
        return [
            ['Ivan', 'ivan@gmail.com', '123456789', '123456789', true, []],
            ['', 'ivan@gmail.com', '123456789', '123456789', false, ['name']],
            ['Ivan', '', '123456789', '123456789', false, ['email']],
            ['Ivan', 'ivan@', '123456789', '123456789', false, ['email']],
            ['Petr', 'petr12@gmail.com', '12345678910', '12345678910', false, ['email']],
            ['Ivan', 'ivan@gmail.com', '', '', false, ['password']],
            ['Ivan', 'ivan@gmail.com', '1234', '1234', false, ['password']],
            ['Ivan', 'ivan@gmail.com', '12345678', '1234', false, ['password']],
        ];
    }

    #[DataProvider('registrationDataProvider')]
    public function testRegistration(string $name, string $email, string $password, string $passwordConfirm, bool $isCheck, array $errors)
    {
        User::factory()->create([
            'email' => 'petr12@gmail.com',
        ]);

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'password_confirmation' => $passwordConfirm,
        ];

        $response = $this->post('/register', $data);
        $response->assertStatus(302);

        if ($isCheck === true) {
            $response->assertRedirect('/admin/users');
            $this->assertDatabaseHas('users', [
                'email' => $email,
            ]);
        } else {
            $response->assertSessionHasErrors($errors);
        }
    }
}
