@extends('layouts.dashbroad')
@section('title', $page_title)
@section('page_title', $page_title)
@section('nav_sectiton')
<a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
@endsection
@php
$active_sidebar="home";
$active_page="home";
@endphp
@section('content')
<div class="card shadow mb-4">
    {{-- <div class="card-header py-2">
        
    </div> --}}
    <div class="card-body">
     
    </div>
</div>
@endsection
@push('scripts')

@endpush