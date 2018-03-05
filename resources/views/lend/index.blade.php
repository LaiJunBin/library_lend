@extends('user.layout') 
@section('title','借用申請') 


@section('content')
    @include('components.validatorErrorMessage')
    <span style="color:red">*為必填欄位</span>
    <button class="btn btn-info" id="writeExample">填寫範例</button>
        
    <form action="{{ url('lend/') }}" method="post">
        {{csrf_field()}}
        <label for="username">借用單位：</label>
        <input class="form-control" type="text" name="unit" placeholder="請輸入單位" value="{{old('unit')}}">
        <label for="timeGroup"><span style="color:red">*</span>借用時段</label><br>
        <input type="checkbox" class="timeGroup" name="time" value="am" checked><label for="time">整個上午(1~4)</label><br>
        <input type="checkbox" class="timeGroup" name="time" value="pm"><label for="time">整個下午(5~7)</label><br>
        <input type="checkbox" class="timeGroup" name="time" value="custom"><label for="time">自定義</label>
        <div id="customTimeGroup">
            <input type="checkbox" disabled name="customTime[]"  value="{{old('customTime[]')}}" value="1"><label for="custom">第一節(8:10~9:00)</label><br>
            <input type="checkbox" disabled name="customTime[]" value="2"><label for="custom">第二節(9:10~10:00)</label><br>
            <input type="checkbox" disabled name="customTime[]" value="3"><label for="custom">第三節(10:10~11:00)</label><br>
            <input type="checkbox" disabled name="customTime[]" value="4"><label for="custom">第四節(11:10~12:00)</label><br>
            <input type="checkbox" disabled name="customTime[]" value="noon"><label for="custom">午休時間(12:30~13:00)</label><br>
            <input type="checkbox" disabled name="customTime[]" value="5"><label for="custom">第五節(1:10~2:00)</label><br>
            <input type="checkbox" disabled name="customTime[]" value="6"><label for="custom">第六節(2:10~3:00)</label><br>
            <input type="checkbox" disabled name="customTime[]" value="7"><label for="custom">第七節(3:10~4:00)</label><br>
        </div>
        <br>
        <label for="date"><span style="color:red">*</span>借用日期：</label>
        <input class="form-control" type="date" name="date" value="{{old('date')}}">
        <label for="purpose"><span style="color:red">*</span>借用目的：</label>
        <textarea name="purpose" class="form-control" cols="30" rows="10">{{old('purpose')}}</textarea>
        <button type="submit" class="btn btn-success">送出申請</button>
        <script src="{{URL::asset('js/lendForm.js')}}"></script>
    </form>
    
    <div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="writeExampleModal">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    <h4 class="modal-title">申請借用填寫範例</h4>
                </div>
                <div class="modal-body" style="overflow:hidden;">
                    <img src="{{ url('images/lendExample.png') }}" style="width:100%;" alt="範例圖片">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">@yield('modalCloseBtnText','關閉視窗')</button>
                </div>
            </div>
        </div>
    </div>
@endsection