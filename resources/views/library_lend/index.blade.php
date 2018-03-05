@extends('user.layout') 
@section('title','圖書館借用系統') 

@section('content') 
    我是首頁
    @if (session()->has('signUp'))
        @include('components.signUpSuccess')
        {{session()->forget('signUp')}}
    @elseif(session()->has('registerUserSuccess'))
        @include('components.registerUserSuccess')
        {{session()->forget('registerUserSuccess')}}
    @elseif(session()->has('updatePasswordSuccess'))
        @include('components.updatePasswordSuccess')
        {{session()->forget('updatePasswordSuccess')}}
    @elseif(session()->has('lendSuccess'))
        @include('components.lendSuccess')
        {{session()->forget('lendSuccess')}}
    @endif
@endsection

