<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Orderly extends Model implements Auditable
{
    use HasFactory, SoftDeletes, AuditableTrait;

    protected $table = 'orderlies';

    protected $fillable = [
        'title',
        'admin_id',
        'time_id',
        'started_at',
        'ended_at',
        'vacancy',
        'location',
        'description',
        'type',
        'active'
    ];

    protected $dates = [
        'started_at',
        'ended_at'
    ];

    public function ordelyTime():BelongsTo
    {
        return $this->belongsTo(OrderlyTime::class, 'time_id');
    }

    public function admin():BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function watchman():BelongsToMany
    {
        return $this->belongsToMany(User::class)->withPivot('status', 'created_at');
    }
}