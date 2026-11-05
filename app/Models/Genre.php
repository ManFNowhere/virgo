<?php

namespace App\Models;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Genre extends Model
{
    use HasFactory;

    protected $guarded = ['id'];




    public function movie(): HasMany
    {
        return $this->hasMany(Movie::class);
    }
}
