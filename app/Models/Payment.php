<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'reference_id',
        'bank_name',
        'payment_method',
        'proof',
    ];

    // In the Payment model
    public function hire()
    {
        return $this->belongsTo(Hire::class);
    }

    // Relationship with User (Employer)
    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }

    // Relationship with User (Freelancer)
    public function freelancer() {
        return $this->belongsTo(User::class, 'freelancer_id');
    }
}
