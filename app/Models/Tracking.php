<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'participation_id',
        'tracking'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function participation()
    {
        return $this->belongsTo(Participation::class);
    }
}
