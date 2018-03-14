@extends('layout') 
@section('brandUrl',url('/'))
@section('brandName','穀保家商圖書館借用系統') 


    @if (session()->has('user_name'))
        @section('dropdownHeader')
            {{ $user_name }}
            <span class="caret"></span>
        @endsection
        
        @section('dropdownItems')
            @foreach ( $navMenu as $item)
                @if ($item == 'divider')
                    <li class="divider"></li>
                @else
                    <li><a href="{{url($item['url'])}}">{{$item['title']}}</a></li>
                @endif
            @endforeach
        @endsection
    @else
        @section('navMenu')
            @foreach ( $navMenu as $item)
                <li><a href="{{url($item['url'])}}">{{$item['title']}}</a></li>
            @endforeach
        @endsection
    @endif


@section('breadcrumb')
    @foreach ($breadcrumb as $item)
        @if ($loop->last)
            <li class="active">{{ $item }}</li>
        @else
            <li><a href="{{ url($item['url']) }}">{{$item['title']}}</a></li>
        @endif
    @endforeach
@endsection

@if (session()->has('user_name') and $user_type == 'A')
    @section('navMenu')
        @section('navbarAlign','right')
        <li><a href="{{url('lend/preLend')}}">填表預借</a></li>
        <li><a href="{{url('lend/verification')}}">審核申請</a></li>
    @endsection  
@endif
