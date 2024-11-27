<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentsController extends Controller
{
    // List All Payments
    public function list(Request $request)
    {
        $query = Payment::with(['hire', 'employer', 'freelancer']); // Include relationships

        // Apply sorting
        if ($request->has('sort')) {
            if ($request->sort == '2') {
                $query->where('isPaid', true); // Paid Payments
            } elseif ($request->sort == '1') {
                $query->orderBy('payment_date', 'desc'); // Latest Payments
            } elseif ($request->sort == '0') {
                $query->orderBy('payment_date', 'asc'); // Earliest Payments
            }
        }

        // Apply keyword search
        if ($request->has('keyword')) {
            $query->whereHas('employer', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        }

        $payments = $query->paginate(10); // Paginate results
        return view('admin.payments.list', compact('payments'));
    }

    // Edit Payment Page
    public function edit($id)
    {
        $payment = Payment::with(['hire', 'employer', 'freelancer'])->findOrFail($id);

        return view('admin.payments.edit', compact('payment'));
    }


    
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
    
        // Check if 'proof' file is uploaded and update its path
        if ($request->hasFile('proof')) {
            // Delete old proof file if exists
            if ($payment->proof && Storage::exists('public/' . $payment->proof)) {
                Storage::delete('public/' . $payment->proof);
            }
    
            // Store the new proof file in 'public/storage/payments' with a generated filename
            $proofPath = $request->file('proof')->store('payments', 'public');  // This automatically generates a file name and stores in 'storage/app/public/payments'
    
            // Save the relative path to the database (no 'public' prefix)
            $payment->proof = $proofPath; // The path stored in DB will be 'payments/filename.jpg'
        }
    
        // Update the payment status
        $payment->isPaid = $request->isPaid;
    
        // Save the updated payment record
        $payment->save();
    
        // Return a success response with a flash message
        session()->flash('success', 'Payment updated successfully!');
        return response()->json([
            'status' => true,
            'errors' => []
        ]);
    }
    
    
}
