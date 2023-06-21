@extends('layouts.MainLayout')
@section('content')
<div class="mb-2">
    @yield('heading')
</div>
<div class="card">
    <div class="table-responsive">
        @yield('table')
    </div>
</div>
@endsection
