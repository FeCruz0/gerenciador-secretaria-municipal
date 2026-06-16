<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileManagementReport extends Model
{
    use HasFactory;

    protected $table = 'file_management_reports';

    protected $fillable = [
        'management_report_id',
        'file_id',
    ];

    protected $dates = [
        'deleted_at'
    ];

}
