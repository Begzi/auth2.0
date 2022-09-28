<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        
    ];
    public function oauthAuthCode()
    {
        return $this->belongsToMany(OauthAuthCode::class);
    }
    public function oauthAuthToken()
    {
        return $this->belongsToMany(OauthAuthToken::class);
    }
}
