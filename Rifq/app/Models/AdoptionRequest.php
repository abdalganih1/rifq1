<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdoptionRequest extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'animal_id',
        'adopter_id',
        'status',
        'request_message',
        'rejection_reason',
        'request_date',
        'decision_date',
    ];

    protected $casts = [
        'request_date' => 'datetime',
        'decision_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function adopter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adopter_id');
    }
}
