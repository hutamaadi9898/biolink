<?php

use App\Models\User;

describe('Authentication Pages', function () {
    beforeEach(function () {
        $this->user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);
    });

    describe('Login Page', function () {
        it('displays login form correctly', function () {
            $page = visit('/login');

            $page->assertSee('Masuk ke Akun Anda')
                ->assertSee('Email')
                ->assertSee('Password')
                ->assertSee('Masuk')
                ->assertSee('Lupa password?')
                ->assertSee('Belum punya akun?')
                ->assertNoJavascriptErrors();
        });

        it('allows user to login with valid credentials', function () {
            $page = visit('/login');

            $page->fill('email', 'test@example.com')
                ->fill('password', 'password123')
                ->click('Masuk')
                ->assertPathIs('/dashboard')
                ->assertNoJavascriptErrors();
        });

        it('shows validation errors for invalid login', function () {
            $page = visit('/login');

            $page->fill('email', 'wrong@example.com')
                ->fill('password', 'wrongpassword')
                ->click('Masuk')
                ->assertSee('These credentials do not match our records.')
                ->assertPathIs('/login')
                ->assertNoJavascriptErrors();
        });

        it('shows Google login option', function () {
            $page = visit('/login');

            $page->assertSee('Lanjutkan dengan Google')
                ->assertVisible('a[href="/auth/google"]')
                ->assertNoJavascriptErrors();
        });

        it('navigates to registration page', function () {
            $page = visit('/login');

            $page->click('Daftar sekarang')
                ->assertPathIs('/register');
        });

        it('navigates to forgot password page', function () {
            $page = visit('/login');

            $page->click('Lupa password?')
                ->assertPathIs('/forgot-password');
        });
    });

    describe('Registration Page', function () {
        it('displays registration form correctly', function () {
            $page = visit('/register');

            $page->assertSee('Buat Akun Baru')
                ->assertSee('Name')
                ->assertSee('Email')
                ->assertSee('Password')
                ->assertSee('Confirm Password')
                ->assertSee('Daftar')
                ->assertSee('Sudah punya akun?')
                ->assertNoJavascriptErrors();
        });

        it('allows user to register with valid data', function () {
            $page = visit('/register');

            $page->fill('name', 'John Doe')
                ->fill('email', 'newuser@example.com')
                ->fill('password', 'password123')
                ->fill('password_confirmation', 'password123')
                ->click('Daftar')
                ->assertPathIs('/dashboard')
                ->assertNoJavascriptErrors();

            $this->assertDatabaseHas('users', [
                'email' => 'newuser@example.com',
                'name' => 'John Doe',
            ]);
        });

        it('shows validation errors for invalid registration', function () {
            $page = visit('/register');

            $page->fill('name', '')
                ->fill('email', 'invalid-email')
                ->fill('password', '123')
                ->fill('password_confirmation', '456')
                ->click('Daftar')
                ->assertSee('The name field is required.')
                ->assertSee('The email field must be a valid email address.')
                ->assertSee('The password field must be at least 8 characters.')
                ->assertSee('The password field confirmation does not match.')
                ->assertPathIs('/register')
                ->assertNoJavascriptErrors();
        });

        it('shows Google registration option', function () {
            $page = visit('/register');

            $page->assertSee('Lanjutkan dengan Google')
                ->assertVisible('a[href="/auth/google"]')
                ->assertNoJavascriptErrors();
        });

        it('navigates to login page', function () {
            $page = visit('/register');

            $page->click('Masuk')
                ->assertPathIs('/login');
        });
    });

    describe('Forgot Password Page', function () {
        it('displays forgot password form correctly', function () {
            $page = visit('/forgot-password');

            $page->assertSee('Lupa Password')
                ->assertSee('Masukkan email Anda untuk reset password')
                ->assertSee('Email')
                ->assertSee('Kirim Link Reset')
                ->assertSee('Kembali ke login')
                ->assertNoJavascriptErrors();
        });

        it('shows success message for valid email', function () {
            $page = visit('/forgot-password');

            $page->fill('email', 'test@example.com')
                ->click('Kirim Link Reset')
                ->assertSee('We have emailed your password reset link!')
                ->assertNoJavascriptErrors();
        });

        it('shows validation error for invalid email', function () {
            $page = visit('/forgot-password');

            $page->fill('email', 'invalid-email')
                ->click('Kirim Link Reset')
                ->assertSee('The email field must be a valid email address.')
                ->assertNoJavascriptErrors();
        });

        it('navigates back to login page', function () {
            $page = visit('/forgot-password');

            $page->click('Kembali ke login')
                ->assertPathIs('/login');
        });
    });
});
