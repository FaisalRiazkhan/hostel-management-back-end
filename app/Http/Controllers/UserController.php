<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //Register User

    public function register(Request $request){
        try {
            $validateUser = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                'national_id_no' => 'required', 
                'email' => 'required|email',
                'password' =>'required|confirmed',
                'phone_number' => 'required|string|regex:/^[0-9]{11}$/|min:10'
            ]);
    
            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->messages()
                ], 422);
            }
    
            $newUser = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'national_id_no' => $request->national_id_no, 
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone_number' => $request->phone_number,
            ]);
            $user_role = Role::where('name', 'user')->first();
            // dd( $user_role);
            if($user_role){
                // Assign the role to the new user
                $newUser->assignRole($user_role);
                // dd('Role assigned successfully');
            } else {
                // If the role does not exist, you might want to handle this case accordingly
                return response()->json([
                    'status' => false,
                    'message' => 'Role not found',
                ], 404);
            }
            $token = $newUser->createToken($request->email)->plainTextToken;
            // dd($newUser);
            return response()->json([
                'token' => $token,
                'status' => "Success",
                'message' => 'User Registered Successfully',
                'user' => $newUser
            ], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 401);
        }
        // $user = user::with('roles', 'roles.permissions')->where('email', $request->email)->first();
        $user = User::with('roles.permissions')->where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'Failed',
                'message' => 'The provided credentials are incorrect'
            ], 401);
        }
    
        $token = $user->createToken($request->email)->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'status' => 'Success',
            'message' => 'Login successful',
            'user' => $user,
            'role' => $user->roles->pluck('name'),
            'permissions' => $user->roles->pluck('permissions')->flatten()->pluck('name'),
        ], 200);
        // dd($user->toArray());
        // if($user && Hash::check($request->password, $user->password)){
        //     $token = $user->createToken($request->email)->plainTextToken;
        //     return response()->json([
        //         'token' => $token,
        //         'status' => "Success",
        //         'message' => 'Login Successfully',
        //         'user' => $user,
        //         'role' => $user->roles->pluck('name'),
        //         // 'permission' => $user->roles->permissions->pluck('name'),
        //         // 'roles.permission' => $user->getPermissionNames()
        //     ], 200);
        // }
        // return response()->json([
        //     'status' => "Failed",
        //     'message' => 'The provided credentials are incorrect',
        // ], 401);
    }

    public function logout(){
        Auth::user()->tokens()->delete();
        return response()->json([
            'status' => "success",
            'message' => 'Logout successfully',
        ], 200);
    }
    // public function logged_user(){
    //     $loggedUser = auth()->user();
    //     // dd($loggedUser->get()->toArray());
    //     return response()->json([
    //         'user' => $loggedUser,
    //         'status' => "success",
    //         'message' => 'Logged user data',
    //     ], 200);
    // }
    public function logged_user() {
        $loggedUser = auth()->user();
    
        if (!$loggedUser) {
            return response()->json([
                'status' => 'Unauthorized',
                'message' => 'You are not logged in'
            ], 401);
        }
    
        $user = User::with('roles.permissions')->where('id', $loggedUser->id)->first();
    
        return response()->json([
            'user' => $user,
            'status' => 'success',
            'message' => 'Logged user data',
            'role' => $user->roles->pluck('name'),
            'permissions' => $user->roles->pluck('permissions')->flatten()->pluck('name'),
        ], 200);
    }
    public function change_password(request $request){
        $validateUser = Validator::make($request->all(), [
            'password' =>'required|confirmed',
        ]);
        if($validateUser->fails()){
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'errors' => $validateUser->errors()
            ], 401);
        }
        $loggedUser = auth()->user();
        $loggedUser->password = Hash::make($request->password);
        $loggedUser->save();
        return response()->json([
            'status' => "success",
            'message' => 'Password changed successfully',
        ], 200);
    }
    
}
