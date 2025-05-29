@extends('layouts.index')
@section('title')
    Book | Bengkel APP
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create Book</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('permissions.create.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="basic-url">Name</label>
                        <div class="input-group mb-3">
                            <input name="name" required type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                        </div>

                        @can('permissions.create')
                        <div class="input-group">
                            <button class="btn btn-primary" type="submit">Create Data</button>
                        </div>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection