<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Hire;
use Illuminate\Http\Request;

class HireController extends Controller
{
    // Admin All Hire Details
    public function index() {
        $hires = Hire::orderBy('created_at','DESC')
                        ->with('job','user','employer')
                        ->paginate(10);

        return view('admin.hires.hires-list',[
            'hires' => $hires,
        ]);
    }

    // Delete Job Application
    public function destroyJobApplication(Request $request) {
        $id = $request->id;

        $hire = Hire::find($id);

        if ($hire == null) {
            session()->flash('error','Hiring Transaction Not Found!');
            return response()->json([
                'status' => false,
            ]);
        }

        $hire->delete();
        session()->flash('success','Hiring Transaction Deleted Successfully!');
        return response()->json([
            'status' => true,
        ]);
    }

        // Hire Transactions
    // public function hireTransaction() {
    //     $user = Auth::user(); 

    //     return view ('freelancer.hire-transaction', compact('user'));
    // }
}
