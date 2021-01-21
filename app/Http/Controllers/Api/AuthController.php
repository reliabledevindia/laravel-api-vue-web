<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

     /**
     * User Authentication by email and password.
     * @return Response @user Data json
     */
    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email',
            'password'  => 'required|min:8',
        ]);
        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => 'Email and Password field is required'
            ], 422);
        }
        $credentials = $request->only('email', 'password');       
        if ($token = $this->guard()->attempt($credentials)) {
              $user = Auth::user();
              $response['message'] = trans('flash.success.account_successfully_login');
              $response['data']['token_type'] = 'Bearer';
              $response['data']['access_token'] = $token;
              $response['data']['user_id'] = trim($user['id']);
              $response['data']['slug'] = trim($user['slug']);
              $response['data']['username'] = trim($user['username']);
              $response['data']['name'] = trim($user['name']);
              $response['data']['email'] = trim($user['email']);
              $response['data']['created_at'] = trim($user['created_at']);
                return response()->json(['status' => 'success','data'=>$response], 200)->header('Authorization', $token);
        }
        return response()->json(['error' => 'login_error'], 401);
    }

    /**
     * User Authentication destroy Logout User.
     * @return Response 
     */
    public function logout()
    {
        $this->guard()->logout();

        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }

    /**
     * Check user is authenticate and return auth user data.
     * @return Response 
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }

    /**
     * Refresh token dynamically in website background.
     * @return Response 
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }

    /**
     * set Auth Gaurd for Api.
     */
    private function guard()
    {
        return Auth::guard();
    }
}