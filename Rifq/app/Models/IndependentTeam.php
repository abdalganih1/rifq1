<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndependentTeam extends Model
{
    protected $fillable = ['name', 'governorate_id', 'contact_phone'];

    public function governorate(): BelongsTo
    {
        return $this->belongsTo(Governorate::class);
    }

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getPrefixAttribute(): string
    {
        return strtoupper(substr($this->name, 0, 3));
    }
}
