<?php

use App\Models\Animal;
use App\Models\IndependentTeam;
use App\Models\Governorate;
use App\Models\MedicalRecord;
use App\Models\AdoptionRequest;
use App\Models\AIScan;
use App\Models\User;

describe('Animal Model', function () {
    it('generates uuid on creation', function () {
        $animal = Animal::factory()->create();
        expect($animal->uuid)->not->toBeNull();
        expect(strlen($animal->uuid))->toBe(36);
    });

    it('generates qr_code_hash on creation', function () {
        $animal = Animal::factory()->create();
        expect($animal->qr_code_hash)->not->toBeNull();
    });

    it('sets created_by from auth user', function () {
        $user = User::factory()->create();
        actingAs($user);

        $animal = Animal::factory()->create(['created_by' => null]);
        expect($animal->created_by)->toBe($user->id);
    });

    it('updates last_updated_by on save', function () {
        $user = User::factory()->create();
        actingAs($user);

        $animal = Animal::factory()->create();
        $animal->update(['color' => 'brown']);

        expect($animal->fresh()->last_updated_by)->toBe($user->id);
    });

    it('generates serial number correctly', function () {
        $gov = Governorate::create(['name' => 'Test']);
        $team = IndependentTeam::create(['name' => 'TestTeam', 'governorate_id' => $gov->id]);
        $animal = Animal::factory()->create([
            'independent_team_id' => $team->id,
            'species' => 'Dog',
        ]);

        $serial = $animal->generateSerialNumber();
        expect($serial)->toContain('RF-');
        expect($serial)->toContain('K9');
    });

    it('has correct relationships', function () {
        $animal = Animal::factory()->create();
        $animal->load([
            'organization', 'owner', 'independentTeam', 'creator',
            'updater', 'medicalRecords', 'adoptionRequests', 'aiScans', 'qrCodeLinks',
        ]);

        expect($animal)->toBeInstanceOf(Animal::class);
    });

    it('uses soft deletes', function () {
        $animal = Animal::factory()->create();
        $id = $animal->id;

        $animal->delete();
        expect(Animal::find($id))->toBeNull();
        expect(Animal::withTrashed()->find($id))->not->toBeNull();
    });

    it('returns image url attribute', function () {
        $animal = Animal::factory()->create(['image_path' => null]);
        expect($animal->image_url)->toBeNull();

        $animal = Animal::factory()->create(['image_path' => 'animals/test.jpg']);
        expect($animal->image_url)->toContain('animals/test.jpg');
    });
});
