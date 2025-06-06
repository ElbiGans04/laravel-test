@extends('layouts.index')
@section('title')
    Permission |  {{ config('app.name') }}
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Permission</h1>
        <p class="mb-4">Menampilkan semua data yang terkait dengan Permission</a>.</p>

        <!-- Create -->
        <!-- @can('permissions.create')
            <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-4" type="button">
                <i class="fas fa-plus fa-sm mr-2"></i>
                <span>Tambah Data </span>
            </a>
        @endcan -->

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Permission</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="permission-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
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
                window.location = `{{ route('permissions.delete') }}?id=${id}`;
            }
        }
        $(function () {
            $('#permission-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("permissions.index") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                ]
            });
        });
    </script>
@endsection