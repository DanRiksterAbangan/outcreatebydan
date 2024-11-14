<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelancers extends Model
{
    use HasFactory;

    protected $table = 'freelancers';

    protected $fillable = [
        'user_id', 'valid_id', 'selfie_with_id', 'diploma', 'certificate'
    ];
}
