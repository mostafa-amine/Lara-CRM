@extends('layouts.index')
@section('title', 'Users')
@section('heading')
<x-users.table-actions :roles="$roles" />
@endsection

@section('table')
<x-users.table :users="$users" />
@endsection

@push('scripts')
<script src="{{ asset('assets/js/plugins/jquery.table2excel.js') }}"></script>
@endpush
