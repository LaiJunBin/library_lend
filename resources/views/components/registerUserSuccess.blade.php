@extends('components.modal')
@section('modalID','registerUserSuccess')
@section('modalTitle','認證完成!')
@section('modalBody')
    <p>現在可以使用註冊的帳號登入了!</p>
    <a href="{{ url('user/sign-in') }}"><button class="btn btn-success">按我登入</button></a>
@endsection