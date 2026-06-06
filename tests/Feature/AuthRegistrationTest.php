<?php

namespace Tests\Feature;

use App\Models\NguoiDung;
use App\Models\PendingRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed database with Roles/PhanQuyen because user needs phanquyen role 2 when verifying
        $this->artisan('db:seed', ['--class' => 'PhanQuyenSeeder']);
    }

    public function test_user_can_register_initially()
    {
        Mail::shouldReceive('send')
            ->once()
            ->with(
                'emails.verify-email',
                \Mockery::on(function ($data) {
                    return $data['hoten'] === 'Test User' && isset($data['verifyUrl']);
                }),
                \Mockery::type('closure')
            );

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'address' => '123 Gym St',
            'phone' => '0987654321',
        ]);

        $response->assertRedirect(route('email.notice'));
        $this->assertEquals('test@example.com', session('pending_email'));

        // Assert pending registration was created
        $this->assertDatabaseHas('pending_registrations', [
            'email' => 'test@example.com',
            'hoten' => 'Test User',
        ]);
    }

    public function test_user_can_re_register_overwriting_pending_status()
    {
        Mail::shouldReceive('send')
            ->once()
            ->with(
                'emails.verify-email',
                \Mockery::on(function ($data) {
                    return $data['hoten'] === 'New User Name';
                }),
                \Mockery::type('closure')
            );

        // Create an existing pending registration
        PendingRegistration::create([
            'hoten' => 'Old User Name',
            'email' => 'test@example.com',
            'password' => bcrypt('oldpass'),
            'diachi' => 'old address',
            'sdt' => '0123456789',
            'token' => 'oldtoken123',
        ]);

        // Register again with new details but same email
        $response = $this->post('/register', [
            'name' => 'New User Name',
            'email' => 'test@example.com',
            'password' => 'NewPass123!',
            'password_confirmation' => 'NewPass123!',
            'address' => 'new address',
            'phone' => '0987654321',
        ]);

        $response->assertRedirect(route('email.notice'));

        // Assert old pending was deleted and new pending was created
        $this->assertDatabaseMissing('pending_registrations', [
            'hoten' => 'Old User Name',
            'token' => 'oldtoken123',
        ]);
        $this->assertDatabaseHas('pending_registrations', [
            'email' => 'test@example.com',
            'hoten' => 'New User Name',
        ]);
    }

    public function test_failed_mail_rolls_back_database_creation()
    {
        // Force Mail to throw exception
        Mail::shouldReceive('send')
            ->andThrow(new \Exception('SMTP Connection Error'));

        $response = $this->post('/register', [
            'name' => 'Test User Fail',
            'email' => 'fail@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'address' => '123 Gym St',
            'phone' => '0987654321',
        ]);

        // Should redirect back with input and errors
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertStringContainsString('Không thể gửi email xác thực', session('error'));

        // Assert database does NOT contain the pending registration because transaction rolled back!
        $this->assertDatabaseMissing('pending_registrations', [
            'email' => 'fail@example.com',
        ]);
    }
}
