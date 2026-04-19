<?php

namespace App\Services;

use App\Models\Animal;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeService
{
    public function generateHash(): string
    {
        return Str::uuid()->toString();
    }

    public function generateQRCode(string $hash, int $size = 300): string
    {
        $url = config('app.url') . '/animal/' . $hash;
        
        return QrCode::size($size)
            ->format('svg')
            ->generate($url);
    }

    public function generateQRCodePng(string $hash, int $size = 300): string
    {
        $url = config('app.url') . '/animal/' . $hash;
        
        return QrCode::size($size)
            ->format('png')
            ->generate($url);
    }

    public function verifyHash(string $hash): ?Animal
    {
        return Animal::where('qr_code_hash', $hash)->first();
    }

    public function assignQRCodeToAnimal(Animal $animal): void
    {
        if (empty($animal->qr_code_hash)) {
            $animal->qr_code_hash = $this->generateHash();
            $animal->save();
        }
    }

    public function getAnimalByHash(string $hash): ?Animal
    {
        return Animal::with(['organization', 'medicalRecords' => function ($query) {
            $query->orderBy('visit_date', 'desc')->limit(10);
        }])->where('qr_code_hash', $hash)->first();
    }
}
