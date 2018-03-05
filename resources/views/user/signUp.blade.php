@extends('user.layout') 
@section('title','註冊') 

 
@section('content')
    @include('components.validatorErrorMessage')
    <form action="{{ url('user/sign-up') }}" method="post">
        {{csrf_field()}}
        <label for="name">請輸入姓名：</label>
        <input class="form-control" type="text" name="name" placeholder="請輸入姓名" value="{{old('name')}}">
        <label for="username">請輸入信箱：</label>
        <input class="form-control" type="text" name="email" placeholder="請輸入信箱" value="{{old('email')}}">
        <label for="password">請輸入密碼：</label>
        <input class="form-control" type="password" name="password" placeholder="請輸入密碼">
        <label for="password2">再次輸入密碼：</label>
        <input class="form-control" type="password" name="password_confirmation" placeholder="再次輸入密碼">
        <button type="submit" class="btn btn-success">註冊</button>
    </form>
@endsection