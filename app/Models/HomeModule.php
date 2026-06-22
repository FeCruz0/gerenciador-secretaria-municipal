<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeModule extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'title',
        'is_enabled',
        'order',
        'organ_id'
    ];

    protected static function booted()
    {
        static::addGlobalScope(new \App\Scopes\OrganScope);
    }

    public function organ()
    {
        return $this->belongsTo(Organ::class);
    }

    protected $casts = [
        'is_enabled' => 'boolean',
        'order' => 'integer',
    ];
}
