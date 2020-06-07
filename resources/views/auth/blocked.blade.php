@extends('templates.main')

@section('title', '403')

@section('menu')
    @foreach ($roles as $role)
        @foreach ($role->menu as $menu)
            @if ($role->id == $role_id)
                <!-- Divider -->
                <hr class="sidebar-divider">
                <!-- Heading -->

                <div class="sidebar-heading">
                    {{ $menu->menu }}
                </div>

                @foreach ($menus as $m)
                    @foreach ($m->submenus as $submenu)
                        @if ($menu->id == $submenu->menu_id && $submenu->is_active == 1)
                        <!-- Nav Item - Dashboard -->
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ url($submenu->url) }}">
                                <i class="{{ $submenu->icon }}"></i>
                                <span>{{ $submenu->title }}</span></a>
                            </li>
                        @endif
                    @endforeach
                @endforeach
            @endif
        @endforeach
    @endforeach
@endsection
@section('dropdown-user')
    @foreach ($user as $u)
        <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ $u->name }}</span>
        <img class="img-profile rounded-circle" src="{{ asset('assets/img/'.$u->image) }}">
    @endforeach
@endsection
@section('container')
<div class="container-fluid">
    <!-- 404 Error Text -->
    <div class="text-center">
        <div class="error mx-auto" data-text="403">403</div>
        <p class="lead text-gray-800 mb-5">Page Forbidden</p>
        <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
        <a href="{{ url('/user') }}">&larr; Back to User</a>
    </div>
</div>
@endsection
