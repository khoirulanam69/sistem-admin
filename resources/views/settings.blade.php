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
            <h1 class="h3 mb-0 text-gray-800">{{__('settings.title')}}</h1>
        </div>
        <form action="{{ url('/settings') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-sm">
                <ul class="list-group list-group-flush">
                    <div class="row">
                        <div class="col-sm-2 d-flex">
                            <i class="fas fa-fw fa-2x fa-language"></i>
                            <label class="font-weight-bold ml-3" style="font-size: 20px">{{ __('settings.lang') }}</label>
                        </div>
                        <div class="col-sm-6 mt-1 ml-5">
                            <div class="form-group form-check d-inline mr-4">
                                <input type="checkbox" class="form-check-input" id="en" name="en" checked>
                                <label class="form-check-label" for="exampleCheck1">English</label>
                            </div>
                            <div class="form-group form-check d-inline">
                                <input type="checkbox" class="form-check-input" id="id" name="id">
                                <label class="form-check-label" for="exampleCheck1">Indonesian</label>
                            </div>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
    </form>
@endsection
