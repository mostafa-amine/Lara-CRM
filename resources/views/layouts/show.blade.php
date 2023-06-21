@extends('layouts.MainLayout')

@section('content')
<div class="row pe-3 mb-3">
    <div class="col-12 pe-0">
        @yield('heading')
    </div>
</div>
<div>
    @yield('subnav')
    <div class="mt-3">
        @yield('subcontent')
    </div>
</div>
@endsection