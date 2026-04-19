<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Animal extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'uuid',
        'serial_number',
        'data_entered_status',
        'qr_code_hash',
        'name',
        'species',
        'animal_type',
        'animal_type_en',
        'custom_animal_type',
        'breed',
        'breed_name',
        'breed_name_en',
        'gender',
        'estimated_age',
        'color',
        'color_en',
        'distinguishing_marks',
        'distinguishing_marks_en',
        'status',
        'location_found',
        'city_province',
        'city_province_en',
        'relocation_place',
        'relocation_place_en',
        'image_path',
        'medical_procedures',
        'parasite_treatments',
        'vaccinations_details',
        'medical_supervisor_info',
        'emergency_contact_phone',
        'organization_id',
        'owner_id',
        'independent_team_id',
        'created_by',
        'last_updated_by',
    ];

    protected $casts = [
        'data_entered_status' => 'boolean',
        'medical_procedures' => 'array',
        'parasite_treatments' => 'array',
        'vaccinations_details' => 'array',
        'medical_supervisor_info' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (Animal $animal) {
            if (empty($animal->uuid)) {
                $animal->uuid = Str::uuid()->toString();
            }
            if (auth()->check() && empty($animal->created_by)) {
                $animal->created_by = auth()->id();
            }
        });

        static::updating(function (Animal $animal) {
            if (auth()->check()) {
                $animal->last_updated_by = auth()->id();
            }
        });
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function independentTeam(): BelongsTo
    {
        return $this->belongsTo(IndependentTeam::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_updated_by');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function adoptionRequests(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class);
    }

    public function aiScans(): HasMany
    {
        return $this->hasMany(AIScan::class);
    }

    public function qrCodeLinks(): HasMany
    {
        return $this->hasMany(AnimalQrLink::class);
    }

    public function generateSerialNumber(): string
    {
        $team = $this->independentTeam;
        $prefix = $team ? $team->prefix : 'RQ';

        $animalCode = match (strtolower($this->species ?? '')) {
            'dog', 'كلب' => 'K9',
            'cat', 'قطة' => 'CAT',
            default => 'PET',
        };

        $count = static::where('independent_team_id', $this->independent_team_id)->count() + 1;
        $serial = "RF-{$prefix}-{$animalCode}-" . str_pad($count, 5, '0', STR_PAD_LEFT);
        $this->serial_number = $serial;
        $this->save();
        return $serial;
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image_path) {
            return asset('storage/' . $this->image_path);
        }
        return null;
    }
}
