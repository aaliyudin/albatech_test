<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Auth;

class UserController extends Controller
{
  public function register(Request $request)
  {
      $this->validate($request, [
          'email' => 'required|unique:users|email',
          'password' => 'required|min:6'
      ]);

      $email = $request->input('email');
      $password = Hash::make($request->input('password'));

      try {
        $user = User::create([
          'email' => $email,
          'password' => $password
        ]);
        return response()->json(
          [
            'status_code' => 201,
            'success' => true,
            'message' => 'Register Success',
            'data' => []
          ], 200);
      } catch (\Exception $e) {
        return response()->json(
          [
            'status_code' => 404,
            'success' => false,
            'message' => $e->getMessage(),
            'data' => []
          ], 200);
      }

  }

  public function login(Request $request)
  {
      $this->validate($request, [
          'email' => 'required|email',
          'password' => 'required|min:6'
      ]);

      $email = $request->input('email');
      $password = $request->input('password');

      $user = User::where('email', $email)->first();
      if (!$user) {
        return response()->json(
          [
            'status_code' => 401,
            'success' => true,
            'message' => 'Login Failed, incorect email',
            'data' => []
          ], 200);
      }

      $isValidPassword = Hash::check($password, $user->password);
      if (!$isValidPassword) {
        return response()->json(
          [
            'status_code' => 401,
            'success' => true,
            'message' => 'Login Failed, incorect password',
            'data' => []
          ], 200);
      }

      $generateToken = bin2hex(random_bytes(40));
      $user->update([
          'token' => $generateToken
      ]);

      $data = [
        'token' => $generateToken
      ];

      return response()->json(
        [
          'status_code' => 201,
          'success' => true,
          'message' => 'Login Success',
          'data' => $data
        ], 200);
  }

  public function logout()
  {
    $userLogout = User::find(Auth::user()->id);
    $userLogout->token = null;
    $userLogout->save();

    return response()->json(
      [
        'status_code' => 200,
        'success' => true,
        'message' => 'Logout Success',
        'data' => []
      ], 200);
  }
}
