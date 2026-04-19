<?php

use App\Services\QRCodeService;
use App\Models\Animal;

describe('QRCodeService', function () {
    beforeEach(function () {
        $this->service = new QRCodeService();
    });

    it('generates unique hash', function () {
        $hash1 = $this->service->generateHash();
        $hash2 = $this->service->generateHash();

        expect($hash1)->not->toBe($hash2);
        expect(strlen($hash1))->toBe(36);
    });

    it('verifies hash and returns animal', function () {
        $animal = Animal::factory()->create();
        $found = $this->service->verifyHash($animal->qr_code_hash);

        expect($found)->not->toBeNull();
        expect($found->id)->toBe($animal->id);
    });

    it('returns null for invalid hash', function () {
        $found = $this->service->verifyHash('invalid-hash');
        expect($found)->toBeNull();
    });

    it('assigns qr code to animal', function () {
        $animal = Animal::factory()->create(['qr_code_hash' => null]);
        $this->service->assignQRCodeToAnimal($animal);

        expect($animal->fresh()->qr_code_hash)->not->toBeNull();
    });

    it('does not overwrite existing qr code hash', function () {
        $originalHash = 'original-hash-123';
        $animal = Animal::factory()->create(['qr_code_hash' => $originalHash]);
        $this->service->assignQRCodeToAnimal($animal);

        expect($animal->fresh()->qr_code_hash)->toBe($originalHash);
    });

    it('gets animal by hash with relationships', function () {
        $animal = Animal::factory()->create();
        $found = $this->service->getAnimalByHash($animal->qr_code_hash);

        expect($found)->not->toBeNull();
        expect($found->relationLoaded('organization'))->toBeTrue();
    });
});
