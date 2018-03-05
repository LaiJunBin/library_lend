@extends('layout') 
@section('brandUrl',url('/'))
@section('brandName','圖書館借用系統') 


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