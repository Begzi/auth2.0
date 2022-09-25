<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'date',
        'user_id',
    ];

    public function favoriteLists()
    {
        return $this->hasMany(FavoriteList::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
