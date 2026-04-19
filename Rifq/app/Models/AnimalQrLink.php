<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AnimalQrLink extends Model
{
    protected $fillable = ['animal_id', 'qr_identifier', 'qr_image_path'];

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class);
    }
}
