<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConservationUnit extends Model
{
    use HasFactory;

    protected $table = 'conservation_units';

    protected $fillable = [
            'title',
            'conservation_unit_type_id',
            'creation',
            'creation_link',
            'objective',
            'area',
            'localization',
            'address',
            'phone',
            'email',
            'opening_hours',
            'thumb',
            'thumb_description',
            'status'
        ];

    const PUBLISHED = 'PUBLISHED';

    public function coverages(): BelongsToMany
    {
        return $this->belongsToMany(Coverage::class);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(ConservationUnitType::class, 'type_id');
    }
}
