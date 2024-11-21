<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientVerificationController extends Controller
{
    // All Client Verification Request
    public function inex() {
        return view('admin.client-verifications.list')
    }
}
