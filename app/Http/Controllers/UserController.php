<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\RegisterUser;
Use App\User;
use Hash;
Use App\Jobs\SendSignUpMailJob;
use Illuminate\Support\Facades\Route;

class UserController extends Controller
{
    
    public function signUp(){
        $binding = [
            'navMenu' => [
                ['url'=>'user/sign-in','title'=>'登入'],
                ['url'=>'user/sign-up','title'=>'註冊']
            ],
            'breadcrumb' =>[
                ['url'=>'/','title'=>'首頁'],
                '註冊'
            ]
        ];
        return view('user.signUp',$binding);
    }
    public function signUpProcess(){
        $input = request()->all();
        
        $rules = [
            'name'=>[
                'required',
                'max:10',
            ],
            'email'=>[
                'required',
                'max:150',
                'email'
            ],
            'password'=>[
                'required',
                'min:6',
                'max:191',
                'same:password_confirmation',
            ],
            'password_confirmation'=>[
                'required',
                'min:6',
                'max:191'
            ],
        ];
        
        $validator = Validator::make($input,$rules);

        if($validator->fails()){
            return redirect('/user/sign-up')->withErrors($validator)->withInput();
        }
        $input['password'] = Hash::make($input['password']);
        $input['verification'] = str_random(60);
        RegisterUser::create($input);

        $mail_binding = [
            'name' => $input['name'],
            'email' => $input['email'],
            'url' => url('user/verification/'.$input['name']."/".$input['verification'])
        ];

        SendSignUpMailJob::dispatch($mail_binding);

        return redirect('user')->with('signUp','ok');
    }

    public function signIn(){
        $binding = [
            'navMenu' => [
                ['url'=>'user/sign-in','title'=>'登入'],
                ['url'=>'user/sign-up','title'=>'註冊']
            ],
            'breadcrumb' =>[
                ['url'=>'/','title'=>'首頁'],
                '登入'
            ]
        ];
        return view('user.signIn',$binding);
    }

    public function signInProcess(){
        $input = request()->all();
        
        $rules = [
            'email'=>[
                'required',
                'max:150',
                'email'
            ],
            'password'=>[
                'required',
                'min:6',
                'max:191'
            ],
        ];
        
        $validator = Validator::make($input,$rules);

        if($validator->fails()){
            return redirect('/user/sign-in')->withErrors($validator)->withInput();
        }
        
        $query = User::where(['email' => $input['email']])->first();
        if($query != null){
            $is_password_correct = Hash::check($input['password'],$query->password);
            
            if($is_password_correct){
                session()->put('user_name',$query->name);
                session()->put('user_email',$query->email);
                return redirect('/');
            }else{
                return redirect('user/sign-in')->withErrors('密碼錯誤!')->withInput();
            }
        }else{
            $query = RegisterUser::where('email',$input['email'])->first();
            if($query != null){
                return redirect('user/sign-in')->withErrors('這個帳戶還沒被驗證，請到信箱收驗證信!')->withInput();
            }else{
                return redirect('user/sign-in')->withErrors('帳戶不存在')->withInput();
            }
        }
        
    }

    public function signOut(){
        session()->forget('user_name');
        session()->forget('user_email');
        return redirect('/');
    }

    public function updatePassword(){
        $binding = [
            'navMenu' => [
                ['url'=>'user/update-password','title'=>'修改密碼'],
                'divider',
                ['url'=>'user/sign-out','title'=>'登出'],
            ],
            'user_name' => '使用者：'.session('user_name'),
            'breadcrumb' =>[
                ['url'=>'/','title'=>'首頁'],
                '修改密碼'
            ]
        ];
        //取得當前路由
        // $currentPath= Route::getFacadeRoot()->current()->uri();

        return view('user.updatePassword',$binding);
    }

    public function updatePasswordProcess(){
        $input = request()->all();
        
        $rules = [
            'old_password'=>[
                'required',
                'min:6',
                'max:191'
            ],
            'password'=>[
                'required',
                'min:6',
                'max:191',
                'same:password_confirmation',
            ],
            'password_confirmation'=>[
                'required',
                'min:6',
                'max:191'
            ],
        ];
        
        $validator = Validator::make($input,$rules);
        if($validator->fails()){
            return redirect('/user/update-password')->withErrors($validator);
        }
        $user_email = session('user_email');
        $old_password = $input['old_password'];
        $user = User::where('email',$user_email)->first();
        $is_password_correct = Hash::check($old_password,$user->password);
        if($is_password_correct){
            $user->update([
                'password'=>Hash::make($input['password'])
            ]);
        }else{
            return redirect('user/update-password')->withErrors('舊密碼錯誤!');
        }
        return redirect('/')->with('updatePasswordSuccess','OK');
    }

}