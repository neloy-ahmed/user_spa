<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;


class OneController extends Controller
{   
    public function register(Request $request)
    {

        // return response()->json([ 'user' => $request->email]);
        // return response([ 'user' => var_dump($request->name)]);
        // var_dump($request->name);
        // return response()->json(['re'=>$request]);
        $validatedData = $request->validate([
            'name' => 'required|max:60',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials']);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }

    public function logout (Request $request) {
        // dd($request);
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    public function update(Request $request, User $user)
    {
        
        $user->update($request->all());

        return response([ 'user' => new UserResource($user), 'message' => 'Updated successfully'], 200);
    }

}
