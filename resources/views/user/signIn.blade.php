@extends('user.layout') 
@section('title','登入') 

 
@section('content')
    @include('components.validatorErrorMessage')
    <form action="{{ url('user/sign-in') }}" method="post">
        {{csrf_field()}}
        <label for="username">請輸入信箱：</label>
        <input class="form-control" type="text" name="email" placeholder="請輸入信箱" value="{{old('email')}}">
        <label for="password">請輸入密碼：</label>
        <input class="form-control" type="password" name="password" placeholder="請輸入密碼">
        <button type="submit" class="btn btn-success">登入</button>
    </form>
@endsection