@extends('user.layout') 
@section('title','圖書館借用系統') 

@section('content')
    @include('components.successModal')
    <table class="table">
        <tr>
            <td style="text-align:left;">
                <a href="{{url('date/'.$prevMouth)}}">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    上個月
                </a>
            </td>
            <td style="text-align:center;">{{$currentMourh}}</td>
            <td style="text-align:right;">
                <a href="{{url('date/'.$nextMouth)}}">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    下個月
                </a>
            </td>
        </tr>
    </table>
    <table class="table">
        <tr>
            @foreach ($week as $w)
                <th style="text-align:center;">{{$w}}</td>
            @endforeach
        </tr>
            @while ($current_day <= $max_day)
                <tr style="text-align:center;">
                    @while (list($key,$value) = each($week))
                        @if ($week_day[$current_day] == $value)
                            <td style="border:1px solid #333;">{{$current_day}}</td>
                            @php ($current_day++)
                        @else
                            <td></td>
                        @endif
                        @if ($current_day>$max_day)
                            @break;
                        @endif
                    @endwhile
                    @php (reset($week))
                </tr>
            @endwhile
    </table>
@endsection

