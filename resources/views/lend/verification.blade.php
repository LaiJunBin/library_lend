@extends('user.layout') 
@section('title','審核申請') 


@section('content')
    @forelse ($records as $record)
        <div class="panel panel-{{ $record['color'] }}">
            <div class="panel-heading">
                <h3 class="panel-title">{{$record['created_at'].' 時申請'}}</h3>
            </div>
            <div class="panel-body">
                <table width="100%">
                    <tr>
                        <td>
                            借用老師： {{$record['teacher']}} <br>
                            @if (trim($record['unit'])!= '')
                                申請單位： {{$record['unit']}} <br>
                            @endif
                            借用日期： {{$record['date']}} <br>
                            借用時段： {{$record['lendTime']}}
                        </td>
                        <td width="50%">
                            <form action="{{url('lend/verification/'.$record['id'])}}" method="post">
                                {{csrf_field()}}
                                {{method_field('put')}}
                                <textarea name="response" class="form-control" cols="30" rows="3"></textarea>
                                <button style="width:100%;margin:10px;" name="solution" value="T" type="submit" class="btn btn-success">同意</button>
                                <button style="width:100%;margin:10px;" name="solution" value="X" type="submit" class="btn btn-danger">不同意</button>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">借用目的： <pre>{{$record['purpose']}}</pre> <br></td>
                    </tr>
                </table>
            </div>
        </div>
        @empty
        <div class="alert alert-warning" role="alert">沒有任何申請紀錄</div>
    @endforelse
    

@endsection