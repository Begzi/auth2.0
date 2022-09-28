<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthAuthCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'code',
    ];

    public function oauthClient()
    {
        return $this->hasOne(OauthClient::class);
    }
}

