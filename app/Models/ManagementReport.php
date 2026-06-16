<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManagementReport extends Model
{
    use HasFactory;

    protected $table = 'management_reports';

    protected $fillable = [
        'management_report_type_id',
        'initial_date',
        'final_date',
        'status',
        'file_id'
        ];

    const PUBLISHED = 'PUBLISHED';

    public function managementReportType(): BelongsTo
    {
        return $this->belongsTo(ManagementReportType::class, 'management_report_type_id');
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
