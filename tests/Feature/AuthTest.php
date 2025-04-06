<?php

namespace Tests\Feature;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Source\Entity\User\Models\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверка, что пользователь может создать аккаунт
     *
     * @return void
     */
    public function test_can_register(): void
    {
        $formData = [
            'login' => 'fidan1',
            'email' => 'fidanrybalka2000@mail.ru',
            'password' => '12345678910',
            'policyagreed' => '1'
        ];

        $response = $this->post('/signup', $formData);
        $response->assertRedirect('/my');

        $this->assertTrue(DB::table('users')->where('email', '=', 'fidanrybalka2000@mail.ru')
            ->exists());
    }

    /**
     * Проверка, что не удастся создать пользователя с уже существующим email or login
     *
     * @return void
     */
    public function test_not_allowed_double_login_or_mail(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/signup', [
            'login' => $user->login,
            'password' => $user->password,
            'email' => 'testmail@mail.ru',
            'policyagreed' => '1'
        ]);

        $response->assertInvalid();

        $response = $this->post('/signup', [
            'login' => 'werfrwhy837hqwesadf3',
            'password' => $user->password,
            'email' => $user->email,
            'policyagreed' => '1'
        ]);

        $response->assertInvalid();
    }

    /**
     * Проверка, что пользователю уходит сообщение верификации и ссылка там корректная
     *
     * @return void
     */
    public function test_account_verified(): void
    {
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        Event::fake();
        event(new Registered($user));

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $this->actingAs($user)->get($verificationUrl);
        Event::assertDispatched(Registered::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }

    public function test_my_page_not_accessible_for_not_auth_user(): void
    {
        $response = $this->get('/my');
        $response->assertRedirect('/login');

        /**
         * @var User $user
         */
        $user = User::factory()->create();
        $user->markEmailAsVerified();
        $response = $this->actingAs($user)->get('/my');
        $response->assertOk();
    }

    public function test_password_norm(): void
    {
        $formData = [
            'login' => 'fidan1111',
            'password' => '11111',
            'policyagreed' => '1',
            'email' => 'example2000test@mail.ru',
        ];

        $response = $this->post('/signup', $formData);
        $response->assertInvalid(['password']);

        $formData['password'] = '111111111111';
        $response = $this->post('/signup', $formData);
        $response->assertRedirect('/my');
    }

    private function testUser(): array
    {
        return [
            'login' => 'fidan1',
            'email' => 'fidanrybalkatest2000@mail.ru',
            'password' => 'example111example',
            'policyagreed' => '1',
        ];
    }

    private function sendPostCreateUser(array $user): TestResponse
    {
        return $this->post('/signup', [
            'login' => $user['login'],
            'password' => $user['password'],
            'email' => $user['email'],
            'policyagreed' => $user['policyagreed'],
        ]);
    }
}
