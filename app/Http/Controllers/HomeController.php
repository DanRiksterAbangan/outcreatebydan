<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
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
}
