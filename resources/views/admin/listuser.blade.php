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
    <h1 class="h3 mb-0 text-gray-800">List Users</h1>
</div>

<div class="row mb-3">
    <div class="col-sm-5">
        <form class="form-inline my-2 my-lg-0" action="{{ url('/admin/listuser/search') }}" method="GET">
            <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search with name" value="{{ old('search') }}" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
    </div>
</div>
<div class="row">
    <div class="col-sm-10">
        {{ $users->links() }}
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Is Active</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $users)
                <tr>
                    <th scope="row">{{ $users->id }}</th>
                    <td><?= $users->name ?></td>
                    <td><?= $users->email ?></td>
                    <td><?= date('d M Y', $users->date_created) ?></td>
                    @if ($users->email_verified_at != null)
                    <td>Actived</td>
                    @else
                    <td>Not Active</td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
