<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $fillable = [
        'role_id',
        'organization_id',
        'first_name',
        'last_name',
        'username',
        'gender',
        'national_id',
        'birth_date',
        'email',
        'password',
        'phone_number',
        'specialization',
        'academic_level',
        'governorate_id',
        'independent_team_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
        ];
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }

    public function independentTeam(): BelongsTo
    {
        return $this->belongsTo(IndependentTeam::class);
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'vet_id');
    }

    public function adoptionRequests(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'adopter_id');
    }

    public function aiScans(): HasMany
    {
        return $this->hasMany(AIScan::class);
    }

    public function ownedAnimals(): HasMany
    {
        return $this->hasMany(Animal::class, 'owner_id');
    }

    public function createdAnimals(): HasMany
    {
        return $this->hasMany(Animal::class, 'created_by');
    }

    public function getNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isDataEntry(): bool
    {
        return $this->hasRole('data_entry');
    }

    public function isVet(): bool
    {
        return $this->hasRole('vet');
    }

    public function isCitizen(): bool
    {
        return $this->hasRole('citizen');
    }
}
