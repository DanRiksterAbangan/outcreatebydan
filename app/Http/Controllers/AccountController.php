<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordEmail;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
            'role' => 'required|in:user',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->firstName = $request->firstName;
            $user->midName = $request->midName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
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
            'role' => 'required|in:freelancer',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->firstName = $request->firstName;
            $user->midName = $request->midName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
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

    // Shows the Blocked Page if the user is Blocked
    public function blocked() {
        return view('front.blocked');
    }

    // User Login Method
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if ($validator->passes()) {
            // Attempt to log in the user
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Check if the user is active
                $user = Auth::user();
                if ($user->isActive == 0) {
                    Auth::logout(); // Log the user out immediately
                    return redirect()->route('account.blocked');
                }
    
                return redirect()->route('account.profile');
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
            $job->status = $request->status;
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

    public function myJobApplications() {
        $jobApplications = JobApplication::where('user_id',Auth::user()->id)
                            ->with(['job','job.jobType','job.applications'])
                            ->orderBy('created_at','DESC')
                            ->paginate(10);

        return view('front.account.job.my-job-applications',[
            'jobApplications' => $jobApplications,
        ]);
    }

    public function removeJobs(Request $request) {
        $jobApplication = JobApplication::where([
            'id' => $request->id, 
            'user_id' => Auth::user()->id,
        ])->first();

        if ($jobApplication == null) {
            session()->flash('error','Job Application not found!');

            return response()->json([
                'status' => false,
            ]);
        }

        JobApplication::find($request->id)->delete();

        session()->flash('success','Job Application removed successfully!');

        return response()->json([
            'status' => true,
        ]);
    }

    public function savedJobs() {

        $savedJobs = SavedJob::where([
            'user_id' => Auth::user()->id,])
            ->with(['job','job.jobType','job.applications'])
            ->orderBy('created_at','DESC')
            ->paginate(10);

        return view('front.account.job.saved-jobs',[
            'savedJobs' => $savedJobs,
        ]);
    }

    public function removeSavedJob(Request $request) {
        $savedJob = SavedJob::where([
            'id' => $request->id, 
            'user_id' => Auth::user()->id,
        ])->first();

        if ($savedJob == null) {
            session()->flash('error','No Jobs saved. Save a Job Now!');

            return response()->json([
                'status' => false,
            ]);
        }

        SavedJob::find($request->id)->delete();

        session()->flash('success','Saved Job removed successfully!');

        return response()->json([
            'status' => true,
        ]);
    }

    // User Profile Page
    public function accountPassword() {

        $id = Auth::user()->id;

        $user = User::where('id', $id)->first();

        return view('front.account.accountPassword', [
            'user' => $user
        ]);

    }

    public function updatePassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        };

        if (Hash::check($request->old_password,Auth::user()->password) == false) {
            session()->flash('error','Your Old Password is incorrect!');

            return response()->json([
                'status' => true,
            ]);
        }

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        session()->flash('success','Password updated successfully!');

        return response()->json([
            'status' => true,
        ]);
    }

    // Forgot Password Password
    public function forgotPassword() {
        return view('front.account.forgot-password');
    }

    public function processForgotPassword(Request $request) {
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.forgotPassword')->withInput()->withErrors($validator); 
        }

        $token = Str::random(10);

        \DB::table('password_reset_tokens')->where('email',$request->email)->delete();

        \DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Send Email Here
        $user = User::where('email',$request->email)->first();

        $mailData = [
            'token' => $token,
            'user' => $user,
            'subject' => 'Password Reset Request',
        ];

        Mail::to($request->email)->send(new ResetPasswordEmail($mailData));

        return redirect()->route('account.forgotPassword')->with('success','Password Reset email has been successfully sent to your email address!');
    }

    public function resetPassword($tokenString) {
        $token = \DB::table('password_reset_tokens')->where('token',$tokenString)->first();

        if ($token == null) {
            return redirect()->route('account.forgotPassword')->with('error','Invalid token!');
        }

        return view('front.account.reset-password',[
            'tokenString' => $tokenString,
        ]);
    }

    public function processResetPassword(Request $request) {
        $token = \DB::table('password_reset_tokens')->where('token',$request->token)->first();

        if ($token == null) {
            return redirect()->route('account.forgotPassword')->with('error','Invalid token!');
        }

        $validator = Validator::make($request->all(),[
            'new_password' => 'required|min:5',
            'confirm_new_password' => 'required|same:new_password',
        ]);

        if ($validator->fails()) {
            return redirect()->route('account.resetPassword',$request->token)->withErrors($validator); 
        }

        User::where('email',$token->email)->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('account.login')->with('success','You have successfully changed your password!');
    }
}
