<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dekanat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama','desc'
    ];

    public function paroki(): HasMany
    {
       return $this->hasMany(Paroki::class);
    }
}
