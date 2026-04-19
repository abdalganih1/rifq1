<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AIScan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'animal_id',
        'user_id',
        'scan_type',
        'media_url',
        'ai_prediction',
        'confidence_score',
        'scan_date',
    ];

    protected $casts = [
        'confidence_score' => 'decimal:2',
        'scan_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
