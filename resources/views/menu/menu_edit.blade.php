@extends('../templates/main')

@section('title', 'Edit Profile')

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
        <img class="img-profile rounded-circle" src="{{ asset('img/'.$u->image) }}">
    @endforeach
@endsection
@section('container')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @foreach ($show as $show)
    <form enctype="multipart/form-data" action="{{ url('/menu/'.$show['id']) }}" method="POST">
        @method('patch')
        @csrf
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Menu Id</label>
            <div class="col-sm-5">
                <input type="text" class="form-control @error('menu') is-invalid @enderror" id="menu" name="menu" value="{{ $show['menu'] }}">
                @error('menu')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col-lg-5 offset-lg-2">
                <button type="submit" class="btn btn-primary">{{ __('edit.btn') }}</button>
            </div>
        </div>
    </form>
    @endforeach
@endsection
