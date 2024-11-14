<?php

namespace App\Http\Controllers\freelancer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    // Freelancer Dashboard
    public function freelancerDashboard() {
        return view ('freelancer.freelancer-dashboard');
    }

    // Freelancer Verify Now
    public function verifyNow() {
        return view ('freelancer.verify-now');
    }
}
