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

// Update Payment
public function update(Request $request, $id)
{
    // Validate the request: required 'isPaid' and optionally, the files
    $request->validate([
        'isPaid' => 'required|boolean', // Validate the payment status
        'proof' => 'nullable|file|mimes:jpg,jpeg,png,gif', // Optional proof file validation (image)
    ]);

    // Find the payment record by ID, or fail if not found
    $payment = Payment::findOrFail($id);

    // Update the payment status
    $payment->isPaid = $request->isPaid;

    // Check if the 'proof' file is uploaded and handle it
    if ($request->hasFile('proof')) {
        // Check and delete the old proof file if it exists (optional)
        if ($payment->proof && Storage::exists('public/' . $payment->proof)) {
            Storage::delete('public/' . $payment->proof); // Delete old proof file from public storage
        }

        // Store the new proof file in 'payments' folder under public storage
        $file = $request->file('proof');
        $proofPath = $file->store('payments', 'public'); // Store the proof file

        // Save the path to the payment record
        $payment->proof = $proofPath;
    }

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
