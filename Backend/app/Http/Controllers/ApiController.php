<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use Illuminate\Support\Facades\Hash;


class ApiController extends Controller
{
    function loginn(Request $req){
        if($req->uname=="tanvir" && $req->pass=="1234"){
            $key = Str::random(67);
            $token = new Token();
            $token->token_key = $key;
            $token->user_id = 1;
            $token->created_at = new Datetime();
            $token->save();
            return response()->json(["token"=>$key],200);
        }
        return response()->json(["msg"=>"Invalid Username password"]);
    }

    function register(Request $req)
    {
        $user= new User;
        $user->name= $req->input('name');
        $user->email= $req->input('email');
        $user->phone= $req->input('phone');
        $user->address= $req->input('address');
        $user->password= Hash::make($req->input('password'));
        $user->save();
        return $user;
    }

    function login(Request $req)
    {
        $user= User::where('email',$req->email)->first();
        if (!$user || !Hash::check($req->password,$user->password))
        {
            return ["error"=>"Email or Password in not matched"];
        }
        return $user;
    }
}
