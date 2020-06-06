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
        <img class="img-profile rounded-circle" src="{{ asset('storage/'.$u->image) }}">
    @endforeach
@endsection
@section('container')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Menu Management</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
        Add Menu
    </button>

    @section('modal-title', 'Add New Menu')
    @section('input-modal')
        <form action="{{ url('/menu') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="menu" class="col-sm-2 col-form-label">Menu</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="menu" name="menu" placeholder="Input menu">
                </div>
            </div>
            <div class="modal-footer mt-2">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    @endsection

    <div class="row">
        <div class="col-lg-8">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                @php($i = 1)
                @foreach ($menus as $menu)
                <tbody>
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $menu->menu }}</td>
                        <td>
                            <a href="{{ url('/menu/'.$menu->id) }}"><span class="badge badge-warning">Edit</span></a>
                            <form action="{{ '/menu/'. $menu->id }}" method="post" style="display: inline">
                                @csrf
                                @method('delete')
                                <button type="submit" style="background: transparent; border: none; color: white"><span class="badge badge-danger">Delete</span></button>
                            </form>
                        </td>
                    </tr>
                    @php($i++)
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
