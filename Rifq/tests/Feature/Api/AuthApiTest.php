<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\{postJson, getJson, actingAs};

beforeEach(function () {
    Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'vet', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'data_entry', 'guard_name' => 'web']);
});

describe('Registration', function () {
    it('can register a new user', function () {
        $response = postJson('/api/auth/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'device_name' => 'test-device',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'user' => ['id', 'first_name', 'last_name', 'email', 'roles'],
                'token',
                'token_type',
            ]);

        expect(User::where('email', 'test@example.com')->exists())->toBeTrue();
    });

    it('assigns citizen role on registration', function () {
        postJson('/api/auth/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'device_name' => 'test-device',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        expect($user->hasRole('citizen'))->toBeTrue();
    });

    it('validates required fields on registration', function () {
        postJson('/api/auth/register', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password', 'device_name']);
    });

    it('validates email uniqueness on registration', function () {
        User::factory()->create(['email' => 'taken@example.com']);

        postJson('/api/auth/register', [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'taken@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'device_name' => 'test-device',
        ])->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    });
});

describe('Login', function () {
    it('can login with valid credentials', function () {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole('citizen');

        $response = postJson('/api/auth/login', [
            'email' => 'login@example.com',
            'password' => 'password123',
            'device_name' => 'test-device',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'user' => ['id', 'email', 'roles'],
                'token',
                'token_type',
            ]);
    });

    it('fails with invalid credentials', function () {
        $user = User::factory()->create([
            'email' => 'login@example.com',
            'password' => bcrypt('password123'),
        ]);

        postJson('/api/auth/login', [
            'email' => 'login@example.com',
            'password' => 'wrongpassword',
            'device_name' => 'test-device',
        ])->assertStatus(422);
    });

    it('validates required fields on login', function () {
        postJson('/api/auth/login', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password', 'device_name']);
    });
});

describe('Authenticated User', function () {
    it('can get current user profile', function () {
        $user = User::factory()->create();
        $user->assignRole('citizen');

        getJson('/api/auth/me', [
            'Authorization' => 'Bearer ' . $user->createToken('test')->plainTextToken,
        ])->assertStatus(200)
            ->assertJsonStructure(['id', 'first_name', 'last_name', 'email', 'roles']);
    });

    it('can update profile', function () {
        $user = User::factory()->create();
        $user->assignRole('citizen');

        $response = actingAs($user, 'sanctum')
            ->putJson('/api/auth/profile', [
                'first_name' => 'Updated',
                'phone_number' => '+9647700000001',
            ]);

        $response->assertStatus(200);
        expect($user->fresh()->first_name)->toBe('Updated');
    });

    it('can logout', function () {
        $user = User::factory()->create();
        $user->assignRole('citizen');
        $token = $user->createToken('test-device');

        postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token->plainTextToken,
        ])->assertStatus(200);

        expect($user->fresh()->tokens)->toHaveCount(0);
    });

    it('can change password', function () {
        $user = User::factory()->create(['password' => bcrypt('oldpassword')]);
        $user->assignRole('citizen');

        actingAs($user, 'sanctum')
            ->putJson('/api/auth/password', [
                'current_password' => 'oldpassword',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ])->assertStatus(200);
    });

    it('rejects unauthenticated requests', function () {
        getJson('/api/auth/me')->assertStatus(401);
    });
});
