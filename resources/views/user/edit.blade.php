@extends('../templates/main')

@section('title', 'Menu Management')

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
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    @foreach ($user as $u)
        <form enctype="multipart/form-data" action="{{ url('/user/edit') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $u->email }}" readonly>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $u->name }}">
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-5">
                    <div class="row">
                        <div class="col-lg-4">
                            <img src="{{ asset('storage/'.$u->image) }}" class="img-thumbnail">
                        </div>
                        <div class="col-lg">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                                @error('image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 offset-lg-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </form>
    @endforeach
@endsection
