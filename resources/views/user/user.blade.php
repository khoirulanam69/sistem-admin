@extends('templates.main')

@section('title', 'User')

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
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
    </div>
    @foreach ($user as $u)
        <div class="card" style="width: 18rem;">
            <img class="card-img-top" src="{{ asset('assets/img/'.$u->image) }}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">{{ $u->name }}</h5>
                <p class="card-text">{{ $u->email }}</p>
                <p class="card-text">Member since {{ date('d M Y', $u->date_created) }}</p>
            </div>
        </div>
    @endforeach
@endsection
