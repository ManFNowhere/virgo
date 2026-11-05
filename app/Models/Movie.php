<?php

namespace App\Models;
use App\Models\Genre;
use App\Models\Watched;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movie extends Model
{
    use HasFactory;
    protected $guarded = ['id'];


    public function genre(): HasMany
    {
        return $this->hasMany(Genre::class);
    }

    public function watched(): HasMany
    {
        return $this->hasMany(Watched::class);
    }
}
