<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'participation'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'id');
    }
}
