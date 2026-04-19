<?php

use App\Models\Animal;
use App\Models\IndependentTeam;
use App\Models\Governorate;
use App\Models\User;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\{getJson, postJson, putJson, deleteJson, actingAs};

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'data_entry', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'vet', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
});

describe('Public Animal Endpoints', function () {
    it('can view a public animal by uuid', function () {
        $animal = Animal::factory()->create(['data_entered_status' => true]);

        getJson("/api/animals/public/{$animal->uuid}")
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', $animal->uuid);
    });

    it('returns 404 for non-existent animal', function () {
        getJson('/api/animals/public/non-existent-uuid')
            ->assertStatus(404);
    });

    it('can scan animal by qr hash', function () {
        $animal = Animal::factory()->create(['data_entered_status' => true]);

        getJson("/api/scan/{$animal->qr_code_hash}")
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', $animal->uuid);
    });

    it('can scan animal by uuid as fallback', function () {
        $animal = Animal::factory()->create(['data_entered_status' => true]);

        getJson("/api/scan/{$animal->uuid}")
            ->assertStatus(200);
    });
});

describe('Authenticated Animal Endpoints', function () {
    it('can list animals', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        Animal::factory()->count(3)->create();

        actingAs($user, 'sanctum')
            ->getJson('/api/animals')
            ->assertStatus(200)
            ->assertJsonStructure(['data']);
    });

    it('can filter animals by search', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $animal = Animal::factory()->create(['animal_type' => 'كلب']);
        Animal::factory()->create(['animal_type' => 'قطة']);

        actingAs($user, 'sanctum')
            ->getJson('/api/animals?search=' . urlencode('كلب'))
            ->assertStatus(200);
    });

    it('can create an animal', function () {
        $user = User::factory()->create();
        $user->assignRole('data_entry');

        $response = actingAs($user, 'sanctum')
            ->postJson('/api/animals', [
                'animal_type' => 'كلب',
                'gender' => 'Male',
                'estimated_age' => '3',
                'color' => 'بني',
            ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.animal_type', 'كلب');

        expect(Animal::where('animal_type', 'كلب')->exists())->toBeTrue();
    });

    it('validates required fields when creating animal', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');

        actingAs($user, 'sanctum')
            ->postJson('/api/animals', [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['animal_type', 'gender']);
    });

    it('can show an animal by uuid', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $animal = Animal::factory()->create();

        actingAs($user, 'sanctum')
            ->getJson("/api/animals/{$animal->uuid}")
            ->assertStatus(200)
            ->assertJsonPath('data.uuid', $animal->uuid);
    });

    it('can update an animal', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $animal = Animal::factory()->create(['animal_type' => 'كلب']);

        actingAs($user, 'sanctum')
            ->putJson("/api/animals/{$animal->uuid}", [
                'animal_type' => 'قطة',
            ])->assertStatus(200);

        expect($animal->fresh()->animal_type)->toBe('قطة');
    });

    it('can delete an animal', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        $animal = Animal::factory()->create();

        actingAs($user, 'sanctum')
            ->deleteJson("/api/animals/{$animal->uuid}")
            ->assertStatus(200);

        expect(Animal::find($animal->id))->toBeNull();
        expect(Animal::withTrashed()->find($animal->id))->not->toBeNull();
    });

    it('requires authentication for animal management', function () {
        getJson('/api/animals')->assertStatus(401);
        postJson('/api/animals', [])->assertStatus(401);
    });
});

describe('Animal Pagination', function () {
    it('respects per_page parameter', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        Animal::factory()->count(25)->create();

        $response = actingAs($user, 'sanctum')
            ->getJson('/api/animals?per_page=5');

        $response->assertStatus(200);
        expect($response->json('data'))->toHaveCount(5);
    });
});
