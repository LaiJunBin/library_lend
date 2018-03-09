@extends('user.layout') 
@section('title','圖書館借用系統') 

@section('content')
    @include('components.successModal')
    <span style="color:red">*</span>
    <span class="glyphicon glyphicon-stop" style="color:#fff388;"></span>
    <span style="font-size:20px;">  代表當天有被借用，點擊可看詳細資訊。</span>
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
                    
                    下個月
                    <span class="glyphicon glyphicon-chevron-right"></span>
                </a>
            </td>
        </tr>
    </table>
    <table class="table">
        <tr bgcolor="#FFF0F5" style="margin:10px;">
            @foreach ($week as $w)
                <th style="text-align:center;">{{$w}}</td>
            @endforeach
        </tr>
            @while ($current_day <= $max_day)
                <tr style="text-align:center;">
                    @foreach ($week as $value)
                        @if ($week_day['d'.$current_day] == $value)
                            @php
                                $switch = false;
                                foreach($day['d'.$current_day] as $item){
                                    $switch = ($item['verification']=='可使用')?true:$switch;
                                }
                            @endphp
                            @if (count($day['d'.$current_day])==0 || !$switch)
                                <td style="border:1px solid #333;">{{$current_day}}</td>
                            @else
                            {{-- {{dd($day[$current_day])}} --}}
                                <td style="border:1px solid #333;background-color:#fff388;">
                                    <a href="#" style="display:block;text-decoration:none;color:#000;" data-id="{{$current_day}}">{{$current_day}}</a>
                                </td>
                            @endif
                            @php ($current_day++)
                        @else
                            <td></td>
                        @endif
                        @if ($current_day>$max_day)
                            @break;
                        @endif
                    @endforeach
                </tr>
            @endwhile
    </table>
    @include('components.dateMoreModal',['data'=>json_encode($day)])
@endsection

