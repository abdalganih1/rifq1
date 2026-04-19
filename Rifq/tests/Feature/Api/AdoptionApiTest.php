<?php

use App\Models\AdoptionRequest;
use App\Models\Animal;
use App\Models\User;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\{actingAs, getJson, postJson};

beforeEach(function () {
    Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
});

describe('Adoption Listing', function () {
    it('can list available animals for adoption', function () {
        Animal::factory()->count(3)->create(['status' => 'available_for_adoption']);
        Animal::factory()->create(['status' => 'Adopted']);

        $user = User::factory()->create();
        $user->assignRole('citizen');

        $response = actingAs($user, 'sanctum')
            ->getJson('/api/adoptions');

        $response->assertStatus(200);
    });

    it('can show an animal for adoption', function () {
        $animal = Animal::factory()->create(['status' => 'available_for_adoption']);
        $user = User::factory()->create();
        $user->assignRole('citizen');

        actingAs($user, 'sanctum')
            ->getJson("/api/adoptions/{$animal->id}")
            ->assertStatus(200);
    });
});

describe('Adoption Request', function () {
    it('can submit an adoption request', function () {
        $animal = Animal::factory()->create(['status' => 'available_for_adoption']);
        $user = User::factory()->create();
        $user->assignRole('citizen');

        $response = actingAs($user, 'sanctum')
            ->postJson("/api/adoptions/{$animal->id}/request", [
                'request_message' => 'أرغب بتبني هذا الحيوان',
            ]);

        $response->assertStatus(201);
        expect(AdoptionRequest::where('animal_id', $animal->id)
            ->where('adopter_id', $user->id)
            ->exists())->toBeTrue();
    });

    it('prevents duplicate adoption requests', function () {
        $animal = Animal::factory()->create(['status' => 'available_for_adoption']);
        $user = User::factory()->create();
        $user->assignRole('citizen');

        AdoptionRequest::create([
            'animal_id' => $animal->id,
            'adopter_id' => $user->id,
            'status' => 'pending',
            'request_message' => 'طلب أول',
            'request_date' => now(),
        ]);

        actingAs($user, 'sanctum')
            ->postJson("/api/adoptions/{$animal->id}/request", [
                'request_message' => 'طلب ثاني',
            ])->assertStatus(409);
    });

    it('validates request message is required', function () {
        $animal = Animal::factory()->create(['status' => 'available_for_adoption']);
        $user = User::factory()->create();
        $user->assignRole('citizen');

        actingAs($user, 'sanctum')
            ->postJson("/api/adoptions/{$animal->id}/request", [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['request_message']);
    });

    it('can list my adoption requests', function () {
        $user = User::factory()->create();
        $user->assignRole('citizen');
        $animal = Animal::factory()->create();
        AdoptionRequest::factory()->count(3)->create(['adopter_id' => $user->id, 'animal_id' => $animal->id]);

        actingAs($user, 'sanctum')
            ->getJson('/api/adoptions/my-requests')
            ->assertStatus(200);
    });

    it('can cancel a pending adoption request', function () {
        $user = User::factory()->create();
        $user->assignRole('citizen');
        $animal = Animal::factory()->create();
        $adoptionRequest = AdoptionRequest::create([
            'animal_id' => $animal->id,
            'adopter_id' => $user->id,
            'status' => 'pending',
            'request_message' => 'أرغب بالتبني',
            'request_date' => now(),
        ]);

        actingAs($user, 'sanctum')
            ->postJson("/api/adoptions/requests/{$adoptionRequest->id}/cancel")
            ->assertStatus(200);

        expect($adoptionRequest->fresh()->status)->toBe('cancelled');
    });

    it('cannot cancel another users request', function () {
        $owner = User::factory()->create();
        $owner->assignRole('citizen');
        $otherUser = User::factory()->create();
        $otherUser->assignRole('citizen');
        $animal = Animal::factory()->create();

        $adoptionRequest = AdoptionRequest::create([
            'animal_id' => $animal->id,
            'adopter_id' => $owner->id,
            'status' => 'pending',
            'request_message' => 'test',
            'request_date' => now(),
        ]);

        actingAs($otherUser, 'sanctum')
            ->postJson("/api/adoptions/requests/{$adoptionRequest->id}/cancel")
            ->assertStatus(403);
    });
});
