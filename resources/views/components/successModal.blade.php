@if (session()->has('signUp'))
    @include('components.signUpSuccess')
    {{session()->forget('signUp')}}
@elseif(session()->has('registerUserSuccess'))
    @include('components.registerUserSuccess')
    {{session()->forget('registerUserSuccess')}}
@elseif(session()->has('updatePasswordSuccess'))
    @include('components.updatePasswordSuccess')
    {{session()->forget('updatePasswordSuccess')}}
@elseif(session()->has('lendSuccess'))
    @include('components.lendSuccess')
    {{session()->forget('lendSuccess')}}
@endif