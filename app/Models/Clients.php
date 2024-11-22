<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'user_id', 
        'valid_id', 
        'selfie_with_id', 
        'business_permit', 
        'dti_registration', 
        'sec_registration', 
    ];    

    // Define the relationship with the User model
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}