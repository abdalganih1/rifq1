<?php

use App\Models\MedicalRecord;
use App\Models\Animal;
use App\Models\User;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\{actingAs, getJson, postJson, putJson, deleteJson};

beforeEach(function () {
    Role::firstOrCreate(['name' => 'vet', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
});

describe('Medical Records API', function () {
    it('can list medical records for an animal', function () {
        $user = User::factory()->create();
        $user->assignRole('vet');
        $animal = Animal::factory()->create();
        MedicalRecord::factory()->count(3)->create(['animal_id' => $animal->id]);

        actingAs($user, 'sanctum')
            ->getJson("/api/animals/{$animal->uuid}/medical-records")
            ->assertStatus(200);
    });

    it('can create a medical record', function () {
        $vet = User::factory()->create();
        $vet->assignRole('vet');
        $animal = Animal::factory()->create();

        $response = actingAs($vet, 'sanctum')
            ->postJson("/api/animals/{$animal->uuid}/medical-records", [
                'record_type' => 'Vaccination',
                'diagnosis' => 'تحليل روتيني',
                'treatment_given' => 'تطعيم شامل',
                'visit_date' => '2026-04-19',
                'notes' => 'الحيوان بحالة جيدة',
            ]);

        $response->assertStatus(201);
        expect(MedicalRecord::where('animal_id', $animal->id)
            ->where('vet_id', $vet->id)
            ->exists())->toBeTrue();
    });

    it('validates required fields for medical record', function () {
        $vet = User::factory()->create();
        $vet->assignRole('vet');
        $animal = Animal::factory()->create();

        actingAs($vet, 'sanctum')
            ->postJson("/api/animals/{$animal->uuid}/medical-records", [])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['record_type', 'visit_date']);
    });

    it('can show a medical record', function () {
        $vet = User::factory()->create();
        $vet->assignRole('vet');
        $record = MedicalRecord::factory()->create();

        actingAs($vet, 'sanctum')
            ->getJson("/api/animals/{$record->animal->uuid}/medical-records/{$record->id}")
            ->assertStatus(200);
    });

    it('can update a medical record', function () {
        $vet = User::factory()->create();
        $vet->assignRole('vet');
        $record = MedicalRecord::factory()->create(['record_type' => 'Vaccination']);

        actingAs($vet, 'sanctum')
            ->putJson("/api/animals/{$record->animal->uuid}/medical-records/{$record->id}", [
                'record_type' => 'Surgery',
            ])->assertStatus(200);

        expect($record->fresh()->record_type)->toBe('Surgery');
    });

    it('can delete a medical record', function () {
        $vet = User::factory()->create();
        $vet->assignRole('vet');
        $record = MedicalRecord::factory()->create();

        actingAs($vet, 'sanctum')
            ->deleteJson("/api/animals/{$record->animal->uuid}/medical-records/{$record->id}")
            ->assertStatus(200);

        expect(MedicalRecord::find($record->id))->toBeNull();
    });
});
