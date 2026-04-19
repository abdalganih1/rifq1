<?php

use App\Models\Animal;
use App\Models\Governorate;
use App\Models\IndependentTeam;
use App\Models\Organization;
use App\Models\User;
use Spatie\Permission\Models\Role;
use function Pest\Laravel\{actingAs, getJson};

beforeEach(function () {
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
    Role::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
});

describe('Lookup API', function () {
    it('can list governorates publicly', function () {
        Governorate::factory()->count(3)->create();

        getJson('/api/governorates')
            ->assertStatus(200);
    });

    it('can list teams publicly', function () {
        $gov = Governorate::create(['name' => 'بغداد']);
        IndependentTeam::factory()->count(2)->create(['governorate_id' => $gov->id]);

        getJson('/api/teams')
            ->assertStatus(200);
    });

    it('can filter teams by governorate', function () {
        $gov = Governorate::create(['name' => 'البصرة']);
        IndependentTeam::factory()->create(['governorate_id' => $gov->id]);
        Governorate::create(['name' => 'نينوى']);

        getJson("/api/teams?governorate_id={$gov->id}")
            ->assertStatus(200);
    });

    it('can list organizations publicly', function () {
        Organization::factory()->count(3)->create();

        getJson('/api/organizations')
            ->assertStatus(200);
    });

    it('can get dashboard stats when authenticated', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        Animal::factory()->count(5)->create();

        actingAs($user, 'sanctum')
            ->getJson('/api/dashboard-stats')
            ->assertStatus(200)
            ->assertJsonStructure([
                'total_animals',
                'adopted_animals',
                'available_for_adoption',
                'total_teams',
                'total_governorates',
                'total_organizations',
                'pending_adoption_requests',
            ]);
    });

    it('requires authentication for dashboard stats', function () {
        getJson('/api/dashboard-stats')->assertStatus(401);
    });
});
