<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LibraryLendController extends Controller
{
    public function index(){
        $binding = [];
        if(session()->has('user_name')){
            $binding = [
                'breadcrumb' => ['MyHome'],
                'navMenu' => [
                    ['url'=>'user/update-password','title'=>'修改密碼'],
                    'divider',
                    ['url'=>'user/sign-out','title'=>'登出'],
                ],
                'user_name' => '使用者：'.session('user_name')
            ];
        }else{
            $binding = [
                'breadcrumb' => ['首頁'],
                'navMenu' => [
                    ['url'=>'user/sign-in','title'=>'登入'],
                    ['url'=>'user/sign-up','title'=>'註冊']
                ]
            ];
        }
        return view('library_lend.index',$binding);
    }
}
