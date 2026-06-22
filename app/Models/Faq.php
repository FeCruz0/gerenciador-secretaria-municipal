<?php

namespace App\Models;

use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Faq extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;
    use Filterable;

    protected $table = 'faqs';

    protected $fillable = [
        'departament_id',
        'question',
        'answer',
        'status',
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

    protected $dates = [
        'deleted_at'
    ];

    public function departament()
    {
        return $this->belongsTo(Departament::class);
    }

    /*public function newsFilter()
    {
        return $this->provideFilter(\App\ModelFilters\NewsFilter::class);
    }*/
}