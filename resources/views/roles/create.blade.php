@extends('layouts.index')
@section('title')
    Permission |  {{ config('app.name') }}
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create Role</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.create.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="basic-url">Name</label>
                        <div class="input-group mb-3">
                            <input name="name" required type="text" class="form-control" id="basic-url"
                                aria-describedby="basic-addon3">
                        </div>
                    </div>

                    <div class="form-group container p-0">
                        <label for="basic-url text-start ">Permissions</label>
                        <div class="row p-3">
                            @foreach ($data as $item)
                                <div class="custom-control custom-switch col-sm-4">
                                    <input type="checkbox" name="permission-{{ $item['id'] }}" class="custom-control-input"
                                        id="{{ $item['id'] }}">
                                    <label class="custom-control-label" for="{{ $item['id'] }}">{{ $item['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @can('roles.create')
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Create Data</button>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection