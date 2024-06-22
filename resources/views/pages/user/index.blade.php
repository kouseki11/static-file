@extends('layout.master')
@section('navbar-sidebar')
    @include('component._navbar')
    @include('component._sidebar')
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <form action="{{ route('user.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name, role, or email"
                            value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>

            <div class="d-flex justify-content-lg-end mb-3">
                <a class="btn btn-success" href="{{ route('user.create') }}">Add User</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="my_table">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-nowrap" style="width:50px">No</th>
                            <th class="text-nowrap">Name</th>
                            <th class="text-nowrap">Email</th>
                            <th class="text-nowrap" style="width: 100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user as $item)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $item->name }}</td>
                                <td class="text-nowrap">{{ $item->email }}</td>
                                <td class="text-nowrap">
                                    <div class="d-flex">
                                        <a href="{{ route('user.edit', $item->id) }}" class="btn btn-warning me-2">Edit</a>
                                        <form action="{{ route('user.destroy', $item->id) }}" method="post"
                                            id="delete_form{{ $item->id }}">
                                            @csrf
                                            @method('delete')
                                            <button type="button" class="btn btn-danger"
                                                onclick="delete_item('delete_form{{ $item->id }}')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $user->links() }}
            </div>
        </div>
    </div>
    <script>
        function delete_item(form) {
            let cf = confirm('Yakin Menghapus Data ?')
            if (cf) {
                document.getElementById(form).submit();
            }
        }
    </script>
@endsection
