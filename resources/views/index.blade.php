@extends('layouts.index')
@section('title')
    Users | Bengkel APP
@endsection
@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Users</h1>
        <p class="mb-4">Menampilkan semua data yang terkait dengan Users</a>.</p>


        <!-- Create -->
        <a href="{{ route('users.create') }}" class="btn btn-primary mb-4" type="button">
            <i class="fas fa-plus fa-sm mr-2"></i>
            <span>Tambah Data </span>
        </a>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Users</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="users-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        function DeleteData(id) {
            const haveTo = confirm('Delete Data ?');
            if (haveTo) {
                window.location = `{{ route('users.delete') }}?id=${id}`;
            }
        }
        $(function () {
            $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("index") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'role', name: 'role' },
                    {
                        data: null,
                        render: function (data) {
                            return `
                                            <a href='{{ route('users.update')}}?id=${data?.id}' class='btn btn-primary'>Update</a>
                                            <a href='javascript:DeleteData(${data?.id})' class='btn btn-danger'>Delete</a>
                                        `
                        }
                    }
                ]
            });
        });
    </script>
@endsection