<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OauthAuthToken extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'client_id',
        'token',
    ];
    public function oauthClient()
    {
        return $this->hasOne(OauthClient::class);
    }
}
