@extends('templates.main')

@section('title', 'Settings')

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
                        @if ($menu->id == $submenu->menu_id)
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
        <img class="img-profile rounded-circle" src="{{ asset('storage/'.$u->image) }}">
    @endforeach
@endsection
@section('container')
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">{{__('settings.title')}}</h1>
        </div>
        <form action="{{ url('/settings') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-sm">
                <ul class="list-group list-group-flush">
                    <div class="row">
                        <div class="input-group mb-3">
                            <div class="col-sm-2">
                                    <label class="input-group-text" for="lang">Language</label>
                            </div>
                            <div class="col-sm-6">
                                <select class="custom-select" id="lang" name="lang">
                                    {{-- <option value="en">English</option> --}}
                                    <option value="id">Indonesian</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-8 text-right">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </form>
@endsection
