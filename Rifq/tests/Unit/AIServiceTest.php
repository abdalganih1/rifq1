<?php

use App\Services\AIService;
use Illuminate\Http\UploadedFile;

describe('AIService', function () {
    beforeEach(function () {
        $this->service = new AIService();
    });

    it('analyzes image file successfully', function () {
        $file = UploadedFile::fake()->image('test.jpg');

        $result = $this->service->analyzeMedia($file);

        expect($result['success'])->toBeTrue();
        expect($result['media_type'])->toBe('image');
        expect($result['analysis'])->toHaveKeys([
            'health', 'behavior', 'identification', 'confidence_score', 'timestamp',
        ]);
    });

    it('returns health analysis with score and status', function () {
        $file = UploadedFile::fake()->image('test.jpg');
        $result = $this->service->analyzeMedia($file);

        $health = $result['analysis']['health'];
        expect($health)->toHaveKeys(['score', 'status', 'status_ar', 'recommendations']);
        expect($health['score'])->toBeInt();
        expect($health['score'])->toBeGreaterThanOrEqual(1);
        expect($health['score'])->toBeLessThanOrEqual(10);
    });

    it('returns behavioral traits', function () {
        $file = UploadedFile::fake()->image('test.jpg');
        $result = $this->service->analyzeMedia($file);

        $behavior = $result['analysis']['behavior'];
        expect($behavior)->toHaveKeys(['traits', 'traits_ar', 'summary']);
        expect($behavior['traits'])->not->toBeEmpty();
    });

    it('returns identification data', function () {
        $file = UploadedFile::fake()->image('test.jpg');
        $result = $this->service->analyzeMedia($file);

        $identification = $result['analysis']['identification'];
        expect($identification)->toHaveKeys([
            'detected_species', 'detected_species_ar', 'detected_breed',
            'estimated_age', 'estimated_gender',
        ]);
    });

    it('returns confidence score between 70 and 95', function () {
        $file = UploadedFile::fake()->image('test.jpg');
        $result = $this->service->analyzeMedia($file);

        $score = $result['analysis']['confidence_score'];
        expect($score)->toBeGreaterThanOrEqual(70);
        expect($score)->toBeLessThanOrEqual(95);
    });

    it('rejects unsupported file types', function () {
        $file = UploadedFile::fake()->create('test.pdf', 100, 'application/pdf');

        $result = $this->service->analyzeMedia($file);

        expect($result['success'])->toBeFalse();
        expect($result)->toHaveKey('error');
    });

    it('uses provided type hint for species', function () {
        $file = UploadedFile::fake()->image('test.jpg');
        $result = $this->service->analyzeMedia($file, 'cat');

        expect($result['analysis']['identification']['detected_species'])->toBe('cat');
    });
});
