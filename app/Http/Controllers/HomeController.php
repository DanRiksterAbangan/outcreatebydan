<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Psy\CodeCleaner\FunctionContextPass;

class HomeController extends Controller
{
    // Home Page
    public function index() {

        // Get categories (no pagination needed)
        $categories = Category::where('status', 1)->orderBy('name', 'ASC')->take(5)->get();
        $newCategories = Category::where('status', 1)->orderBy('name', 'ASC')->get();

        // Paginate featured jobs
        $featuredJobs = Job::where('status', 1)
                            ->orderBy('created_at', 'DESC')
                            ->with('jobType')
                            ->where('isFeatured', 1)
                            ->paginate(5);  // Use paginate instead of get()

        // Paginate latest jobs
        $latestJobs = Job::where('status', 1)
                            ->with('jobType')
                            ->orderBy('created_at', 'DESC')
                            ->paginate(5);  // Use paginate instead of get()

        return view('front.home', [
            'categories' => $categories,
            'featuredJobs' => $featuredJobs,
            'latestJobs' => $latestJobs,
            'newCategories' => $newCategories,
        ]);
    }

    // Shows the Blocked Page for the Blocked Account
    public function blocked() {
        return view('front.blocked');
    }

    // About Page
    public function about() {
        return view ('front.about');
    }

    // Contact Page
    public function contact() {
        return view ('front.contact');
    }

    // Process the Contact Message
    public function processContact(Request $request) {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required|string', // Corrected validation rule
        ]);
    
        if ($validator->passes()) {
    
            $contact = new Contact();
            $contact->name = $request->name;
            $contact->email = $request->email;
            $contact->subject = $request->subject;
            $contact->message = $request->message;
            $contact->save();
    
            session()->flash('success', 'Message sent successfully!');
    
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
    
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    // All Freelancers
    public function browseFreelancers() {
        return view('front.browse-freelancers');
    }
    
}
