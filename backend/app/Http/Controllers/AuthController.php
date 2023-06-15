<?php
namespace App\Http\Controllers;

use App\Models\password_reset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Mail;
use Str;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'sendResetPasswordLink','ResetPassword']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Email or password dose not matched'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            // dd($validator);
            return response()->json($validator->errors(), 422);
        }
        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));
        return response()->json([
            'message' => 'User successfully registered',
            'access_token' => auth()->attempt($validator->validated()),
            'user' => $user,
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile()
    {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
        ]);
    }

    protected function sendResetPasswordLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail === null) {
            return response()->json(['error' => 'Please enter valid email id, No user found !!'], 400); // user doesn't exist
        }
        $token = Str::random(64);

        password_reset::updateOrCreate(['email' => $request->email], [
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);
        $user = User::where([['email', '=', $request->email]])->first();
        Mail::send('email.forgetPassword', ['token' => $token, 'name' => $user->name], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return response()->json(['message' => 'We have e-mailed your password reset link'], 200);
    }

    protected function ResetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|confirmed|min:6',
        ]);
        if ($validator->fails()) {
            // dd($validator);
            return response()->json($validator->errors(), 422);
        }

        $check_token = password_reset::where('token',$request->reset_token)->first();

        if($check_token === null)
        {
            return response()->json(['error' => 'Invalid or Expired token!!'], 400);
        }

        $check_user =  User::where('email',$check_token['email'])->first();

        if($check_user === null)
        {
            return response()->json(['error' => 'No user found for this request!!'], 400);
        }
         $passUpdated = User::where('email',$check_token['email'])->update(['password' => bcrypt($request->password)]);

         if($passUpdated)
         {
             $check_token->delete();
            return response()->json(['message' => 'Password updated successfully'], 200);
         }
    }
}
