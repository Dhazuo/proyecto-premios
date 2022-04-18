<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    CONST AWARDS = array(
        'REFRIGERADOR ALGO',
        'COCINA ALGO',
        'SILLON ALGO',
        'CAMA ALGO'
    );
}
