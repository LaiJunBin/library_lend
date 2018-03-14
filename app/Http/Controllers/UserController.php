<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\RegisterUser;
Use App\User;
use Hash;
Use App\Jobs\SendSignUpMailJob;
use App\Services\BindingService;
use App\ForgetUser;

class UserController extends Controller
{
    
    public function signUp(){
        return view('user.signUp',BindingService::binding());
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
                'email',
                'regex:/@kpvs.ntpc.edu.tw$/'
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
            'url' => url('user/verification/'.$input['name']."/".$input['verification']),
            'title' => '恭喜註冊 圖書館借用系統 成功',
            'template' => 'email.signUpEmail'
        ];
        SendSignUpMailJob::dispatch($mail_binding);

        return redirect('/')->with('signUp','ok');
    }

    public function signIn(){
        return view('user.signIn',BindingService::binding());
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

        return view('user.updatePassword',BindingService::binding());
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


    public function forgetPassword(){ 
        return view('user.forget',BindingService::binding());
    }

    public function forgetPasswordProcess(){
        $input = request()->all();
        
        $rules = [
            'name'=>[
                'required',
                'max:10',
            ],
            'email'=>[
                'required',
                'max:150',
                'email',
                'regex:/@kpvs.ntpc.edu.tw$/'
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
            return redirect('/user/forgetPassword')->withErrors($validator)->withInput();
        }
        $user_query = User::where(['email'=>$input['email'],'name'=>$input['name']])->first();
        if($user_query == null){
            return redirect('/user/forgetPassword')->withErrors('查無此帳戶')->withInput();
        }
        $input['verification'] = str_random(60);
        $input['password'] = Hash::make($input['password']);
        ForgetUser::create($input);

        $mail_binding = [
            'name' => $input['name'],
            'email' => $input['email'],
            'url' => url('user/forgetPassword/verification/'.$input['name']."/".$input['verification']),
            'title' => '重設 圖書館借用系統 密碼',
            'template' => 'email.forgetUserEmail'
        ];
        SendSignUpMailJob::dispatch($mail_binding);

        return redirect('/')->with(['forgetUser'=>'ok']);
    }

    public function forgetPasswordVerification($user,$code){
        $forget_result = ForgetUser::where(['verification'=>$code])->first();
        if($forget_result != null){
            $user_result = User::where(['email'=>$forget_result->email])->first();
            if($user_result != null){
                $user_result->update([
                    'password' => $forget_result->password
                ]);
                $forget_result->delete();
                return redirect('/')->with('forgetUserSuccess','ok');
            }
        }
        return redirect('/');
    }
}