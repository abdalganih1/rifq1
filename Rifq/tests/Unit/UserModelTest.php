<?php

use App\Models\User;
use App\Models\Role;
use Spatie\Permission\Models\Role as SpatieRole;

describe('User Model', function () {
    beforeEach(function () {
        SpatieRole::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'vet', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'data_entry', 'guard_name' => 'web']);
        SpatieRole::firstOrCreate(['name' => 'citizen', 'guard_name' => 'web']);
    });

    it('has full name accessor', function () {
        $user = User::factory()->create([
            'first_name' => 'Ahmed',
            'last_name' => 'Ali',
        ]);

        expect($user->full_name)->toBe('Ahmed Ali');
    });

    it('hides password and remember token', function () {
        $user = User::factory()->create();
        $array = $user->toArray();

        expect($array)->not->toHaveKey('password');
        expect($array)->not->toHaveKey('remember_token');
    });

    it('checks admin role', function () {
        $user = User::factory()->create();
        $user->assignRole('admin');
        expect($user->isAdmin())->toBeTrue();

        $user2 = User::factory()->create();
        $user2->assignRole('citizen');
        expect($user2->isAdmin())->toBeFalse();
    });

    it('checks vet role', function () {
        $user = User::factory()->create();
        $user->assignRole('vet');
        expect($user->isVet())->toBeTrue();
    });

    it('checks data_entry role', function () {
        $user = User::factory()->create();
        $user->assignRole('data_entry');
        expect($user->isDataEntry())->toBeTrue();
    });

    it('checks citizen role', function () {
        $user = User::factory()->create();
        $user->assignRole('citizen');
        expect($user->isCitizen())->toBeTrue();
    });

    it('casts password as hashed', function () {
        $user = User::factory()->create();
        expect(password_verify('password', $user->password))->toBeTrue();
    });

    it('has api tokens', function () {
        $user = User::factory()->create();
        $token = $user->createToken('test-device');

        expect($token->plainTextToken)->not->toBeEmpty();
        expect($user->tokens)->toHaveCount(1);
    });

    it('uses soft deletes', function () {
        $user = User::factory()->create();
        $id = $user->id;

        $user->delete();
        expect(User::find($id))->toBeNull();
        expect(User::withTrashed()->find($id))->not->toBeNull();
    });
});
