<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organ extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'sigla',
        'slug',
        'theme_color_hex',
        'logo_path',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function parent()
    {
        return $this->belongsTo(Organ::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Organ::class, 'parent_id');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function biddings()
    {
        return $this->hasMany(Bidding::class);
    }

    public function banners()
    {
        return $this->hasMany(Banner::class);
    }

    public function faqs()
    {
        return $this->hasMany(FAQ::class);
    }

    public function shortcutWebs()
    {
        return $this->hasMany(ShortcutWeb::class);
    }

    public function homeModules()
    {
        return $this->hasMany(HomeModule::class);
    }

    public function departaments()
    {
        return $this->hasMany(Departament::class);
    }
}
