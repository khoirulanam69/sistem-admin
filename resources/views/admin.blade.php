@extends('templates.main')

@section('title', 'Admin')

@section('menu')
    @foreach ($usermenu as $um)
        <!-- Divider -->
        <hr class="sidebar-divider">
        <!-- Heading -->
        <div class="sidebar-heading">
            {{ $um->menu }}
        </div>
        @foreach ($usersubmenu as $usm)                   
            @if ($um->id == $usm->menu_id)                    
                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                <a class="nav-link" href="{{ url($usm->url) }}">
                    <i class="{{ $usm->icon }}"></i>
                    <span>{{ $usm->title }}</span></a>
                </li>
            @endif
        @endforeach
    @endforeach
@endsection
@section('dropdown-user')
    @foreach ($user as $u)
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $u->name }}</span>
        <img class="img-profile rounded-circle" src="{{ asset('storage/'.$u->image) }}">
    @endforeach
@endsection
@section('container')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>         
        </div>
@endsection