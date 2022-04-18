<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Participant extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'last_name',
        'ip_address',
        'participation'
    ];

    public function participation()
    {
        return $this->hasOne(Participation::class);
    }

    public function tracking()
    {
        return $this->hasOne(Tracking::class);
    }
}
