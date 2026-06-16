<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ManagementReportType extends Model
{
    use HasFactory;

    protected $table = 'management_report_types';

    protected $fillable = [
            'type'
        ];

    public function managementReports(): HasMany
    {
        return $this->hasMany(ManagementReport::class, 'management_report_type_id');
    }
}

