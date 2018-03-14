@extends('user.layout') 
@section('title','忘記密碼') 

 
@section('content')
    @include('components.validatorErrorMessage')
    <span style="color:red">*重設後會先寄送認證信至信箱，認證後才生效。</span>
    <form action="{{ url('user/forgetPassword') }}" method="post">
        {{csrf_field()}}
        <label for="username">請輸入姓名：</label>
        <input class="form-control" type="text" name="name" placeholder="請輸入姓名" value="{{old('name')}}">
        <label for="username">請輸入信箱：</label>
        <input class="form-control" type="text" name="email" placeholder="請輸入信箱" value="{{old('email')}}">
        <label for="password">請輸入新密碼：</label>
        <input class="form-control" type="password" name="password" placeholder="請輸入密碼">
        <label for="password2">再次輸入新密碼：</label>
        <input class="form-control" type="password" name="password_confirmation" placeholder="再次輸入密碼">
        <button type="submit" class="btn btn-success">重設密碼</button>
    </form>
@endsection