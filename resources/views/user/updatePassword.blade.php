@extends('user.layout') 
@section('title','更改密碼') 

 
@section('content')
    @include('components.validatorErrorMessage')
    <form action="{{ url('user/update-password') }}" method="post">
        {{csrf_field()}}
        {{method_field('put')}}
        <label for="username">輸入舊密碼：</label>
        <input class="form-control" type="password" name="old_password" placeholder="請輸入舊密碼">
        <label for="password">輸入新密碼：</label>
        <input class="form-control" type="password" name="password" placeholder="請輸入新密碼">
        <label for="password">再次輸入新密碼：</label>
        <input class="form-control" type="password" name="password_confirmation" placeholder="再次輸入新密碼">
        <button type="submit" class="btn btn-success">確認修改</button>
    </form>
@endsection