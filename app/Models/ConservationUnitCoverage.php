<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConservationUnitCoverage extends Model
{
    use HasFactory;
    protected $table = 'conservation_unit_coverage';

    protected $fillable = [
            'conservation_unit_id',
            'coverage_id'
        ];
}
