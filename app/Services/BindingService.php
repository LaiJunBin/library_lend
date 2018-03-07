<?php

namespace App\Services;
use Illuminate\Support\Facades\Route;
use App\User;

class BindingService
{
    static function binding(){
        $currentPath= Route::getFacadeRoot()->current()->uri();
        $breadcrumb = [];
        $paths = array_filter(explode('/',$currentPath),function($value){
            return $value != '';
        });
        $pathObj = [
            '' => ['title'=> '首頁','url' => '/'],
            'user' => ['title'=> '使用者','url' => '#'],
            'sign-up' => ['title'=> '註冊','url' => '/sign-up'],
            'sign-in' => ['title'=> '登入','url' => '/sign-in'],
            'update-password' => ['title'=> '修改密碼','url' => '/update-password'],
            'lend' => ['title'=> '借用申請','url' => '/lend'],
            'records' => ['title'=> '申請紀錄','url' => '/records'],
            'verification' => ['title'=>'審核申請','url'=>'/verification'],
        ];
        if(count(array_filter($paths,function($x) use($pathObj){
            return in_array($x,array_keys($pathObj));
        }))!=0){
            array_unshift($breadcrumb,$pathObj['']);
            for($i = 0 ; $i < count($paths) ; $i++){
                if(in_array($paths[$i],array_keys($pathObj))){
                    if($i == count($paths)-1)
                        array_push($breadcrumb,$pathObj[$paths[$i]]['title']);
                    else
                        array_push($breadcrumb,$pathObj[$paths[$i]]);
                }
            }
        }else{
            $breadcrumb = ['首頁'];
        }
        if(session()->has('user_name')){
            
            $binding = [
                'navMenu' => [
                    ['url'=>'lend/','title'=>'借用申請'],
                    ['url'=>'lend/records','title'=>'申請紀錄'],
                    ['url'=>'user/update-password','title'=>'修改密碼'],
                    'divider',
                    ['url'=>'user/sign-out','title'=>'登出'],
                ],
                'user_name' => '使用者：'.session('user_name'),
                'user_type' => User::where('email',session('user_email'))->first()->only('type')['type']
            ];
        }else{
            $binding = [
                'navMenu' => [
                    ['url'=>'user/sign-in','title'=>'登入'],
                    ['url'=>'user/sign-up','title'=>'註冊']
                ]
            ];
        }
        $binding['breadcrumb'] = $breadcrumb;
        return $binding;
    }
}