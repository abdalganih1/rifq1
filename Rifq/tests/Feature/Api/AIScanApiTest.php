<?php

use App\Models\AIScan;
use App\Models\Animal;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\UploadedFile;
use function Pest\Laravel\{actingAs, getJson, postJson};

beforeEach(function () {
    Role::firstOrCreate(['name' => 'vet', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
});

describe('AI Scan API', function () {
    it('can list ai scans for an animal', function () {
        $user = User::factory()->create();
        $user->assignRole('vet');
        $animal = Animal::factory()->create();
        AIScan::factory()->count(3)->create(['animal_id' => $animal->id]);

        actingAs($user, 'sanctum')
            ->getJson("/api/animals/{$animal->uuid}/ai-scans")
            ->assertStatus(200);
    });

    it('can analyze media and create scan', function () {
        $user = User::factory()->create();
        $user->assignRole('vet');

        $file = UploadedFile::fake()->image('test.jpg');

        $response = actingAs($user, 'sanctum')
            ->postJson('/api/ai/analyze', [
                'media' => $file,
                'scan_type' => 'health_check',
            ]);

        $response->assertStatus(201)
            ->assertJsonStructure(['scan', 'analysis']);
    });

    it('validates media file is required', function () {
        $user = User::factory()->create();
        $user->assignRole('vet');

        actingAs($user, 'sanctum')
            ->postJson('/api/ai/analyze', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['media']);
    });

    it('can show a specific ai scan', function () {
        $user = User::factory()->create();
        $user->assignRole('vet');
        $scan = AIScan::factory()->create();

        actingAs($user, 'sanctum')
            ->getJson("/api/animals/{$scan->animal->uuid}/ai-scans/{$scan->id}")
            ->assertStatus(200);
    });

    it('can list my ai scans', function () {
        $user = User::factory()->create();
        $user->assignRole('vet');
        AIScan::factory()->count(3)->create(['user_id' => $user->id]);

        actingAs($user, 'sanctum')
            ->getJson('/api/ai/my-scans')
            ->assertStatus(200);
    });
});
