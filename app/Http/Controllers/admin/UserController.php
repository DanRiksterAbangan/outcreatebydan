<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Admin Dashboard - All Users
    public function index() {
        $users = User::orderBy('created_at','DESC')->paginate(10);
        return view('admin.users.list',[
            'users' => $users
        ]);
    }

    // Admin Function - Open Edit User Page
    public function edit($id) {
        $user = User::findOrFail($id);

        $roles = User::select('role')->distinct()->pluck('role'); // Get unique roles

        return view('admin.users.edit',[
            'user' => $user,
            'roles' => $roles,
        ]);
    }

    // Admin Function - Save Edited User Page
    public function update($id, Request $request) {

        $validator = Validator::make($request->all(),[
            'firstName' => 'required',
            'midName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'role' => 'required', 
        ]);

        if ($validator->passes()) {

            $user = User::find($id);
            $user->firstName = $request->firstName;
            $user->midName = $request->midName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->designation = $request->designation;
            $user->mobile = $request->mobile;
            $user->role = $request->role; 
            $user->save();

            session()->flash('success','User Profile Updated Successfully!');

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

    // Admin Function - Delete User
    public function destroy(Request $request) {
        $id = $request->id;

        $user = User::find($id);

        if ($user == null) {
            session()->flash('error','User Not Found!');
            return response()->json([
                'status' => false,
            ]);
        }

        $user->delete();
        session()->flash('success','User Deleted Successfully!');
            return response()->json([
                'status' => true,
            ]);
    }

    // Admin Create User
    public function create() {
        $roles = User::select('role')->distinct()->pluck('role'); 
        $user = new User(); // Create an empty User instance
    
        return view('admin.users.create', compact('roles', 'user'));
    }
    

    //  Admin Process User Registration
    public function processRegister(Request $request) {
        $roles = User::select('role')->distinct()->pluck('role')->toArray(); // Get unique roles as an array
    
        $validator = Validator::make($request->all(),[
            'firstName' => 'required',
            'midName' => 'required',
            'lastName' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:' . implode(',', $roles), // Allow only roles from the database
            'password' => 'required|min:6|same:confirmPassword',
            'confirmPassword' => 'required',
        ]);
    
        if ($validator->passes()) {
            $user = new User();
            $user->firstName = $request->firstName;
            $user->midName = $request->midName;
            $user->lastName = $request->lastName;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->save();
    
            session()->flash('success', 'User Created Successfully!');
    
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
    
    
}
