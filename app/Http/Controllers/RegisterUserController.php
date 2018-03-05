<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RegisterUser;
use App\User;

class RegisterUserController extends Controller
{
    public function verification($user,$code){
        $query = RegisterUser::where(['name'=>$user,'verification'=>$code])->first();
        if($query != null){
            User::create($query->toarray());
            $query->delete();
            return redirect('/')->with('registerUserSuccess','T');
        }
        return redirect('/');
    }
}
