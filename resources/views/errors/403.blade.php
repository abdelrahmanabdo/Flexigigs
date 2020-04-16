@extends('layouts.home')
@section('title', 'Categories')
@section('bodyClass', 'inner')
@section('search')
    @include('parts.search')
@endsection
@section('content')
<div class="page-header alt mb-0">
    <div class="container-fluid">
        <div class="not-found">
            <h1>@lang('general.error_reaction')</h1>
            <p>@lang('general.error_desc_403')</p>
            <span>@lang('general.error_status_403')</span>
            <img src="{{asset('images/404.png')}}">
            <a href="{{route('home')}}" class="btn btn-primary">@lang('general.error_go_home')</a>
        </div>
    </div>
</div>
@endsection