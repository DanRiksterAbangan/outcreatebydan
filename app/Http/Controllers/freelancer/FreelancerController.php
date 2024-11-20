<?php

namespace App\Http\Controllers\freelancer;

use App\Http\Controllers\Controller;
use App\Models\Freelancers;
use App\Models\Hire;
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

    // Verify Credentials Function
    public function verifyCredentials(Request $request) {
        $user = Auth::user();
    
        // Use firstOrNew instead of firstOrCreate
        $freelancer = Freelancers::firstOrNew(['user_id' => $user->id]);
    
        $request->validate([
            'valid_id' => 'nullable|mimes:png,jpg,jpeg,webp',
            'selfie_with_id' => 'nullable|mimes:png,jpg,jpeg,webp',
            'diploma' => 'nullable|mimes:png,jpg,jpeg,webp',
            'certificate' => 'nullable|mimes:png,jpg,jpeg,webp',
            'resume' => 'nullable|mimes:pdf,doc,docx',
        ], [
            'valid_id.mimes' => 'Valid ID must be a file of type: png, jpg, jpeg, webp.',
            'selfie_with_id.mimes' => 'Selfie with Valid ID must be a file of type: png, jpg, jpeg, webp.',
            'diploma.mimes' => 'Diploma must be a file of type: png, jpg, jpeg, webp.',
            'certificate.mimes' => 'Certificate must be a file of type: png, jpg, jpeg, webp.',
            'resume.mimes' => 'Resume must be a file of type: pdf, doc, docx.',
        ]);
        
    
        $uploadedFiles = [];
        foreach (['valid_id', 'selfie_with_id', 'diploma', 'certificate', 'resume'] as $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $filePath = $file->storeAs(
                    'freelancers', // Directory within 'storage/app'
                    time() . '_' . $fileField . '.' . $file->getClientOriginalExtension(),
                    'public' // Store in the 'public' disk
                );
    
                // Set the file path in the freelancer model instance
                $freelancer->$fileField = '/storage/' . $filePath;
                $uploadedFiles[$fileField] = $filePath;
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

    // Show Hire Transaction Details
    public function hireDetails($id) {
        // Retrieve the hire details by ID
        $hire = Hire::with('freelancer', 'job')->findOrFail($id);
    
        // Pass the hire data to the view
        return view('freelancer.hire-details', compact('hire'));
    }
}
