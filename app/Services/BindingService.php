<?php

namespace App\Services;
use Illuminate\Support\Facades\Route;

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
        ];
        if(count($paths)!=0){
            array_unshift($breadcrumb,$pathObj['']);
            for($i = 0 ; $i < $paths ; $i++){
                if($i == $paths-1)
                    array_unshift($breadcrumb,$pathObj[$paths[$i]]['title']);
                else
                    array_unshift($breadcrumb,$pathObj[$paths[$i]]);
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
                'user_name' => '使用者：'.session('user_name')
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