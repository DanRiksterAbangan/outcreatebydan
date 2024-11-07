<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

class AccountController extends Controller
{
    // User Registration Page
    public function registration() {
        return view('front.account.registration');
    }

    // Client Registration Page
    public function clientRegistration() {
        return view('front.account.clientRegistration');
    }

    // Freelancer Registration Page
    public function freelancerRegistration() {
        return view('front.account.freelancerRegistration');
    }

    //  Client Register Method
    public function processRegistration(Request $request) {
        $validator = Validator::make($request->all(),[
            'firstName' => 'required',
            'midName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:confirmPassword',
            'confirmPassword' => 'required',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->firstName = $request->firstName;
            $user->midName = $request->midName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'You have registered sucessfully!');

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

    //  Freelancer Register Method
    public function processFreelancerRegistration(Request $request) {
        $validator = Validator::make($request->all(),[
            'firstName' => 'required',
            'midName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|same:confirmPassword',
            'confirmPassword' => 'required',
        ]);

        if ($validator->passes()) {
            
            $user = new User();
            $user->firstName = $request->firstName;
            $user->midName = $request->midName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role(config('auth.defaults.freelancer'));
            $user->save();

            session()->flash('success', 'You have registered sucessfully!');

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

    // User Login Page
    public function login() {

        return view('front.account.login');

    }

    // User Login Method
    public function authenticate(Request $request) {

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.myJobs');
            } else {
                return redirect()->route('account.login')->with('error', 'Invalid credentials.');
            }

        } else {
            return redirect()->route('account.login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }

    }

    // User Profile Page
    public function profile() {

        $id = Auth::user()->id;

        $user = User::where('id', $id)->first();

        return view('front.account.profile', [
            'user' => $user
        ]);

    }

    // USer Profile Page Update Method
    public function updateProfile(Request $request) {

        $id = Auth::user()->id;

        $validator = Validator::make($request->all(),[
            'firstName' => 'required',
            'midName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->firstName = $request->firstName;
            $user->midName = $request->midName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->save();

            session()->flash('success','Profile Updated Successfully!');

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

    // User Logout
    public function logout() {

        Auth::logout();
        return redirect()->route('account.login');

    }

    // Update Profile Picutre
    public function updateProfilePic(Request $request) {

        $id = Auth::user()->id;
         
        $validator = Validator::make($request->all(),[
            'image' => 'required|image'
        ]);

        if ($validator->passes()) {

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $imageName = $id.'-'.time().'.'.$ext;
            $image->move(public_path('/profile_pic/'), $imageName);

            // Create a small thumbnail
            $sourcePath = public_path('/profile_pic/'.$imageName);
            $manager = new ImageManager(Driver::class);
            $image = $manager->read($sourcePath);

            $image->cover(150, 150);
            $image->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));

            // Delete Old Profile Picture
            File::delete(public_path('/profile_pic/thumb/'.Auth::user()->image));
            File::delete(public_path('/profile_pic/'.Auth::user()->image));

            User::where('id',$id)->update(['image' => $imageName]);

            session()->flash('success','Profile Picture Updated Successfully!');

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

    // Create Job
    public function createJob() {

        $categories = Category::orderBy('name','ASC')->where('status',1)->get();

        $jobTypes = JobType::orderBy('name','ASC')->where('status',1)->get();

        return view('front.account.job.create',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
        ]);
    }

    // Save Job after Creation
    public function saveJob(Request $request) {

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'salary' => 'required',
            'location' => 'required|min:5|max:70',
            'description' => 'required',
            'company_name' => 'required|min:5|max:70',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {
            
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;
            $job->save();

            session()->flash('success', 'Job added successfully!');

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

    // Posted Jobs
    public function myJobs() {

        $jobs = Job::where('user_id',Auth::user()->id)->with('jobType')->orderBy('created_at','DESC')->paginate(10);

        return view('front.account.job.my-jobs',[
            'jobs' => $jobs
        ]);
    }

    // Edit Posted Jobs
    public function editJob(Request $request, $id) {

        $categories = Category::orderBy('name','ASC')->where('status',1)->get();
        $jobTypes = JobType::orderBy('name','ASC')->where('status',1)->get();

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $id,
        ])->first();

        if ($job == null) {
            abort(404);
        }

        return view('front.account.job.edit',[
            'categories' => $categories,
            'jobTypes' => $jobTypes,
            'job' => $job,
        ]);
    }

    public function updateJob(Request $request, $id) {

        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'salary' => 'required',
            'location' => 'required|min:5|max:70',
            'description' => 'required',
            'company_name' => 'required|min:5|max:70',
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->passes()) {
            
            $job = Job::find($id);
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->jobType;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benefits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experience = $request->experience;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->website;
            $job->save();

            session()->flash('success', 'Job Updated Successfully!');

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

    public function deleteJob(Request $request) {

        $job = Job::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId
        ])->first();

        if ($job == null) {
            session()->flash('error', 'Job Not Found!');
            return response()->json([
                'status' => true
            ]);
        }

        Job::where('id',$request->jobId)->delete();
        session()->flash('success', 'Job Deleted Successfully!');
            return response()->json([
                'status' => true,
            ]);
    }
}
