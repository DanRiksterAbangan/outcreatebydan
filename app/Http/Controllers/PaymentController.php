<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Hire; // Include Hire model if needed
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function showPaymentForm($paymentId) {
        // Load the payment with the associated hire, freelancer, and employer
        $payment = Payment::with('hire', 'freelancer', 'employer')->find($paymentId);
    
        // Initialize $hireId to null
        $hireId = null;
    
        // Check if the payment exists and if the hire relationship is loaded correctly
        if ($payment && $payment->hire) {
            $hireId = $payment->hire->id;
        }
    
        // Pass the payment and hireId to the view
        return view('front.account.edit-hires.payment.form', compact('payment', 'hireId'));
    }    
    
    public function sendPayment(Request $request) {
        // Validate the incoming data
        $validated = $request->validate([
            'hire_id' => 'required|exists:hires,id', // Ensure the hire_id is valid
            'reference_id' => 'required|string|max:255',
            'payment_method' => 'required|integer',
            'amount_payable' => 'required|numeric',
            'employer_id' => 'required|exists:users,id', // Ensure employer_id exists in the users table
            'freelancer_id' => 'required|exists:users,id', // Ensure freelancer_id exists in the users table
            'bank_name' => 'nullable|string|max:255', // Optional, only required for Bank Transfer
        ]);
    
        // Create a new payment with the validated data
        $payment = new Payment();
        $payment->hire_id = $validated['hire_id']; // Save the hire_id
        $payment->employer_id = $validated['employer_id']; // Save the employer_id
        $payment->freelancer_id = $validated['freelancer_id']; // Save the freelancer_id
        $payment->reference_id = $validated['reference_id'];
        $payment->payment_method = $validated['payment_method'];
        $payment->amount_payable = $validated['amount_payable'];
    
        // Save bank_name only if the payment method is Bank Transfer (0)
        if ($validated['payment_method'] == 0 && $request->has('bank_name')) {
            $payment->bank_name = $validated['bank_name'];  // Save bank_name if method is Bank Transfer
        }
    
        // If a file was uploaded (proof of payment), handle it
        if ($request->hasFile('proof')) {
            $payment->proof = $request->file('proof')->store('payments');
        }
    
        $payment->save();
    
        // Redirect or return a response
        return redirect()->route('account.hires')->with('success', 'Payment submitted successfully!');
    }
    
}
