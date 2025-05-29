@extends('layouts.index')
@section('title')
    Roles | Bengkel APP
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Roles</h1>
        <p class="mb-4">Menampilkan semua data yang terkait dengan Roles</a>.</p>

        <!-- Create -->
        <!-- @can('roles.create')
            <a href="{{ route('roles.create') }}" class="btn btn-primary mb-4" type="button">
                <i class="fas fa-plus fa-sm mr-2"></i>
                <span>Tambah Data </span>
            </a>
        @endcan -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Roles</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="roles-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Permissions</th>
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
        $(function () {
            $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("roles.index") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'permissions', name: 'permissions' },
                    { data: 'actions', name: 'actions' },
                ]
            });
        });
    </script>
@endsection