<?php

namespace App\Http\Controllers\freelancer;

use App\Http\Controllers\Controller;
use App\Models\Freelancers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreelancerController extends Controller
{

    // Freelancer Dashboard
    public function freelancerDashboard() {
        $user = Auth::user(); 

        return view ('freelancer.freelancer-dashboard', compact('user'));
    }

    // Freelancer Verify Now Page
    public function verifyNow() {
        return view ('freelancer.verify-now');
    }

    // Freelancer Upload Credentials
    public function verifyCredentials(Request $request) {
        $user = Auth::user();
    
        // Use firstOrNew instead of firstOrCreate
        $freelancer = Freelancers::firstOrNew(['user_id' => $user->id]);
    
        $request->validate([
            'valid_id' => 'nullable|mimes:png,jpg,jpeg,webp',
            'selfie_with_id' => 'nullable|mimes:png,jpg,jpeg,webp',
            'diploma' => 'nullable|mimes:png,jpg,jpeg,webp',
            'certificate' => 'nullable|mimes:png,jpg,jpeg,webp',
        ]);
    
        $uploadedFiles = [];
    
        foreach (['valid_id', 'selfie_with_id', 'diploma', 'certificate'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $filename = time().'_'.$fileField.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('/freelancers/'), $filename);
    
                // Set the file path in the freelancer model instance
                $freelancer->$fileField = '/freelancers/' . $filename;
                $uploadedFiles[$fileField] = $filename;
            }
        }
    
        // Save the instance to persist all updates at once
        $freelancer->save();
    
        if (count($uploadedFiles) > 0) {
            session()->flash('success', 'Credentials Updated Successfully!');
            return response()->json([
                'status' => true,
                'errors' => [],
                'uploaded_files' => $uploadedFiles
            ]);
        } else {
            session()->flash('error', 'No credentials uploaded!');
            return response()->json([
                'status' => false,
                'errors' => ['No files uploaded.'],
            ]);
        }
    }
}
