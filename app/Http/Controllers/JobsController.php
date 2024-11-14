<?php

namespace App\Http\Controllers;

use App\Mail\JobNotificationEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    // Jobs Page
    public function index(Request $request) {

        $categories = Category::where('status',1)->get();
        $jobTypes = JobType::where('status',1)->get();

        $jobs = Job::where('status',1);

        // Search through Keywords
        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere('title','like','%'.$request->keyword.'%');
                $query->orWhere('keywords','like','%'.$request->keyword.'%');
            });
        }

        // Search through Location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location',$request->location);
        }

        // Search through Category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id',$request->category);
        }

        $jobTypeArray = [];
        // Search through Job Type
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',',$request->jobType);

            $jobs = $jobs->whereIn('job_type_id',$jobTypeArray);
        }

        // Search through Experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience',$request->experience);
        }

        $jobs = $jobs->with(['jobType','category']);

        if ($request->sort == '0') {
            $jobs = $jobs->orderBy('created_at','ASC');
        } else {
            $jobs = $jobs->orderBy('created_at','DESC');
        }
        
        $jobs = $jobs ->paginate(6);

        return view('front.jobs',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray,
        ]);
    }

    // Job Details Page
    public function detail($id) {

        $job = Job::where([
            'id' => $id,
            'status' => 1,
        ])->with(['jobType','category'])->first();

        if ($job == null) {
            abort(404);
        }

        $count = 0;

        if (Auth::user()) {

            $count = SavedJob::where([
                'user_id' => Auth::user()->id,
                'job_id' => $id,
            ])->count();
        }

        // Fetch Applicants

        $applications = JobApplication::where('job_id',$id)->with('user')->get();

        return view('front.jobDetail',['job' => $job,
                                        'count' => $count,
                                        'applications' => $applications
                                    ]);
    }

    // Apply Job Function
    public function applyJob(Request $request) {
        $id = $request->id;

        $job = Job::where('id',$id)->first();

        // If Job not found in DB
        if ($job == null) {
            $message = 'Job does not exist!';

            session()->flash('error',$message);
            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        // User can't apply on their own Job
        $employer_id = $job->user_id;

        if ($employer_id == Auth::user()->id) {
            $message = 'You cannot apply on your own Job!';

            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        // User can't apply for the job twice
        $jobApplicationCount = JobApplication::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id,
        ])->count();

        if ($jobApplicationCount > 0) {
            $message = 'You have already applied for this job!';

            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $application = new JobApplication();
        $application->job_id = $id;
        $application->user_id = Auth::user()->id;
        $application->employer_id = $employer_id;
        $application->applied_date = now();
        $application->save();

        // Send Notification Email to Employer
        $employer = User::where('id',$employer_id)->first();

        $mailData = [
            'employer' => $employer,
            'user' => Auth::user(),
            'job' => $job,
        ];

        Mail::to($employer->email)->send(new JobNotificationEmail($mailData));

        $message = 'You have successfully applied for this Job!';

        session()->flash('success', $message);
        return response()->json([
            'status' => false,
            'message' => $message,
        ]);
    }

    // Save Job Function
    public function saveTheJob(Request $request) {
        $id = $request->id;

        $job = Job::find($id);

        if ($job == null) {
            session()->flash('error','Job not found!');
            return response()->json([
                'status' => false,
            ]);
        }

        // Check if User already saved the job
        $count = SavedJob::where([
            'user_id' => Auth::user()->id,
            'job_id' => $id,
        ])->count();

        if ($count > 0) {
            $message = 'You have already saved this Job!';

            session()->flash('error', $message);
            return response()->json([
                'status' => false,
                'message' => $message,
            ]);
        }

        $savedJob = new SavedJob;
        $savedJob->job_id = $id;
        $savedJob->user_id = Auth::user()->id;
        $savedJob->save();

        $message = 'Job saved successfully!';

        session()->flash('success', $message);
        return response()->json([
            'status' => false,
            'message' => $message,
        ]);
    }
}
