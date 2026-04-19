<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class AIService
{
    protected array $healthConditions = [
        'healthy' => 'سليم',
        'injured' => 'مصاب',
        'sick' => 'مريض',
        'malnourished' => 'يعاني من سوء التغذية',
        'needs_vaccination' => 'يحتاج تطعيم',
    ];

    protected array $behavioralTraits = [
        'friendly' => 'ودود',
        'aggressive' => 'عدواني',
        'fearful' => 'خائف',
        'playful' => 'مرح',
        'calm' => 'هادئ',
        'anxious' => 'قلق',
    ];

    public function analyzeMedia(UploadedFile $file, ?string $type = null): array
    {
        $mimeType = $file->getMimeType();
        $isImage = Str::startsWith($mimeType, 'image/');
        $isVideo = Str::startsWith($mimeType, 'video/');

        if (!$isImage && !$isVideo) {
            return [
                'success' => false,
                'error' => 'نوع الملف غير مدعوم. يرجى رفع صورة أو فيديو.',
            ];
        }

        $healthScore = rand(1, 10);
        $healthStatus = $this->getRandomHealthStatus($healthScore);
        
        $behavioralTraits = $this->getRandomBehavioralTraits();
        
        $detectedSpecies = $this->guessSpecies($type);
        
        $detectedBreed = $this->guessBreed($detectedSpecies);

        return [
            'success' => true,
            'media_type' => $isImage ? 'image' : 'video',
            'analysis' => [
                'health' => [
                    'score' => $healthScore,
                    'status' => $healthStatus,
                    'status_ar' => $this->healthConditions[$healthStatus] ?? $healthStatus,
                    'recommendations' => $this->getHealthRecommendations($healthScore),
                ],
                'behavior' => [
                    'traits' => $behavioralTraits,
                    'traits_ar' => array_map(fn($t) => $this->behavioralTraits[$t] ?? $t, $behavioralTraits),
                    'summary' => $this->getBehaviorSummary($behavioralTraits),
                ],
                'identification' => [
                    'detected_species' => $detectedSpecies,
                    'detected_species_ar' => $this->getSpeciesArabic($detectedSpecies),
                    'detected_breed' => $detectedBreed,
                    'estimated_age' => rand(1, 10) . ' سنوات',
                    'estimated_gender' => rand(0, 1) ? 'male' : 'female',
                ],
                'confidence_score' => rand(70, 95),
                'timestamp' => now()->toIso8601String(),
            ],
        ];
    }

    protected function getRandomHealthStatus(int $score): string
    {
        if ($score >= 8) return 'healthy';
        if ($score >= 6) return 'needs_vaccination';
        if ($score >= 4) return 'malnourished';
        if ($score >= 2) return 'sick';
        return 'injured';
    }

    protected function getRandomBehavioralTraits(): array
    {
        $traits = array_keys($this->behavioralTraits);
        $count = rand(1, 3);
        shuffle($traits);
        return array_slice($traits, 0, $count);
    }

    protected function guessSpecies(?string $type): string
    {
        if ($type) return $type;
        return rand(0, 1) ? 'dog' : 'cat';
    }

    protected function guessBreed(string $species): string
    {
        $dogBreeds = ['German Shepherd', 'Labrador', 'Poodle', 'Bulldog', 'Beagle', 'Mixed'];
        $catBreeds = ['Persian', 'Siamese', 'Maine Coon', 'British Shorthair', 'Mixed'];
        
        if ($species === 'dog') return $dogBreeds[array_rand($dogBreeds)];
        if ($species === 'cat') return $catBreeds[array_rand($catBreeds)];
        
        return 'Mixed';
    }

    protected function getHealthRecommendations(int $score): array
    {
        $recommendations = [];
        
        if ($score < 5) {
            $recommendations[] = 'يحتاج الحيوان إلى فحص بيطري عاجل';
        }
        
        if ($score < 7) {
            $recommendations[] = 'يُنصح بإجراء تحاليل دم شاملة';
        }
        
        if ($score < 8) {
            $recommendations[] = 'يحتاج إلى تطعيمات أساسية';
        }
        
        $recommendations[] = 'توفير بيئة هادئة وآمنة';
        $recommendations[] = 'تقديم طعام صحي ومياه نظيفة';
        
        return $recommendations;
    }

    protected function getBehaviorSummary(array $traits): string
    {
        $summary = 'الحيوان يبدو ';
        
        $arTraits = array_map(fn($t) => $this->behavioralTraits[$t] ?? $t, $traits);
        
        if (count($arTraits) === 1) {
            return $summary . $arTraits[0] . '.';
        }
        
        $last = array_pop($arTraits);
        return $summary . implode('، ', $arTraits) . ' و' . $last . '.';
    }

    protected function getSpeciesArabic(string $species): string
    {
        return match ($species) {
            'dog' => 'كلب',
            'cat' => 'قطة',
            'bird' => 'طائر',
            'rabbit' => 'أرنب',
            default => $species,
        };
    }
}
