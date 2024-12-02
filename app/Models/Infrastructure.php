<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Infrastructure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'image',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'image' => 'array',
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    public function sportObjects(): BelongsToMany
    {
        return $this->belongsToMany(SportObject::class, 'infrastructure_and_objects', 'infrastructure_id', 'sportObject_id');
    }
}
