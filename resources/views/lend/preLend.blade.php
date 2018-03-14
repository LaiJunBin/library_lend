@extends('user.layout') 
@section('title','填表預借') 


@section('content')
    @include('components.validatorErrorMessage')
    
    <span style="color:red">*為必填欄位</span>
    <form action="{{ url('lend/preLend') }}" method="post">
        {{csrf_field()}}
        <label for="username">借用單位：</label>
        <input class="form-control" type="text" name="unit" placeholder="請輸入單位" value="{{old('unit')}}">
        <label for="username">借用老師：</label>
        <input class="form-control" type="text" name="teacher" placeholder="請輸入老師姓名" value="{{old('teacher')}}">
        <label for="timeGroup"><span style="color:red">*</span>借用時段</label><br>
        <input type="checkbox" class="timeGroup" name="time" value="am" checked><label for="time">整個上午(1~4)</label><br>
        <input type="checkbox" class="timeGroup" name="time" value="pm"><label for="time">整個下午(5~7)</label><br>
        <input type="checkbox" class="timeGroup" name="time" value="custom"><label for="time">自定義</label>
        <div id="customTimeGroup">
            <input type="checkbox" disabled name="customTime[]" value="1"><label for="custom">第一節(8:10~9:00)</label><br>
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
@endsection