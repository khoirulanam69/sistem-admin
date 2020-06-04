@extends('../templates/main')

@section('title', 'Submenu Management')

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
        <h1 class="h3 mb-0 text-gray-800">Submenu Management</h1>
    </div>

    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#exampleModal">
        Add Submenu
    </button>

    @section('modal-title', 'Add New Submenu')
    @section('input-modal')
        <form action="{{ url('/menu/submenu') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label class="col-sm-2 col-form-label">Menu</label>
                <div class="col-sm-10">
                    <select name="menu_id" class="custom-select">
                        <option selected>Select Menu</option>
                            @foreach ($usermenu as $um)
                                <option value="{{ $um->id }}">{{ $um->menu }}</option>
                            @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="title" class="col-sm-2 col-form-label">Title</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="title" name="title" placeholder="Input title">
                </div>
            </div>
            <div class="form-group row">
                <label for="icon" class="col-sm-2 col-form-label">Icon</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="icon" name="icon" placeholder="Input icon">
                </div>
            </div>
            <div class="form-group row">
                <label for="url" class="col-sm-2 col-form-label">Url</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="url" name="url" placeholder="Input url">
                </div>
            </div>
            <input type="checkbox" name="is_active" id="is_active" value="1" class="mr-2" checked>active?
            <div class="modal-footer mt-2">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
    @endsection

    <div class="row">
        <div class="col-lg">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Title</th>
                        <th scope="col">Icon</th>
                        <th scope="col">Url</th>
                        <th scope="col">Is_active</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                @php($i = 1)
                @foreach ($usersubmenu as $submenu)
                <tbody>
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $submenu->menu }}</td>
                        <td>{{ $submenu->title }}</td>
                        <td>{{ $submenu->icon }}</td>
                        <td>{{ $submenu->url }}</td>
                        <td>{{ $submenu->is_active }}</td>
                        <td>
                            <a href=""><span class="badge badge-warning">Edit</span></a>
                            <form action="{{ '/menu/submenu/'.$submenu->id }}" method="POST" style="display: inline">
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
