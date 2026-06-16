<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnviromentalLicensing extends Model
{
    use HasFactory;

    protected $table = 'enviromental_licencing_file';

    protected $fillable = [
        'file_id',
        'title'
    ];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
