<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','address','latitude','longitude',
        'paroki_id','foto','website'
    ];

    public function paroki(): BelongsTo
    {
        return $this->belongsTo(Paroki::class,'paroki_id');
    }
}
