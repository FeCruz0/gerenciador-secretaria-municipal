<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConservationUnitType extends Model
{
    use HasFactory;

    protected $table = 'conservation_unit_types';

    protected $fillable = [
            'type'
        ];

    public function conservations(): HasMany
    {
        return $this->hasMany(ConservationUnit::class);
    }
}
