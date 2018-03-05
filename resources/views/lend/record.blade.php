@extends('user.layout') 
@section('title','申請紀錄') 


@section('content')
    @foreach ($records as $record)
        <div class="panel panel-{{ $record['color'] }}">
            <div class="panel-heading">
                <h3 class="panel-title">{{$record['created_at'].' 時申請'}}</h3>
            </div>
            <div class="panel-body">
                申請單位： {{$record['unit']}} <br>
                借用日期： {{$record['date']}} <br>
                借用時段： {{$record['lendTime']}} <br>
                借用目的： {{$record['purpose']}} <br>
                當前狀態： {{$record['verification']}}
                <form action="records/{{ $record['id'] }}/delete" method="post">
                    {{csrf_field()}}
                    {{method_field('delete')}}
                    <button type="submit" class="btn btn-danger">
                        @if ($record['verification']=='待審核')
                            取消申請
                        @else
                            刪除紀錄
                        @endif
                    </button>
                </form>
            </div>
        </div>
    @endforeach
    
    

@endsection