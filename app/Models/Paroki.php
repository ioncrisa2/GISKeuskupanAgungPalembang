<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paroki extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','address','latitude','longitude',
        'dekanat_id','foto','website'
    ];

    public function dekanat(): BelongsTo
    {
        return $this->belongsTo(Dekanat::class,'dekanat_id');
    }

    public function stasi(): HasMany
    {
        return $this->hasMany(Stasi::class,'stasi_id');
    }
}
