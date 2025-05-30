@extends('layouts.index')
@section('title')
    Export | Bengkel APP
@endsection
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Export</h1>
        <p class="mb-4">Menampilkan semua data yang terkait dengan Export</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Table Export</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="permission-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Path</th>
                                <th>Status</th>
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
            $('#permission-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("cars.export.index") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'path', name: 'path' },
                    { data: 'status', name: 'status' },
                    { data: 'actions', name: 'actions' },
                ]
            });
        });
    </script>
@endsection