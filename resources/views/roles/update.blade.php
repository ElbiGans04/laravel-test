@extends('layouts.index')
@section('title')
    Permission | Bengkel APP
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Role</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('roles.update.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <label for="basic-url">Name</label>
                        <div class="input-group mb-3">
                            <input value="{{ $data['name'] }}" name="name" required type="text" class="form-control"
                                id="basic-url" aria-describedby="basic-addon3">
                        </div>

                    </div>

                    <div class="form-group container p-0">
                        <label for="basic-url text-start ">Permissions</label>
                        <div class="row p-3">
                            @foreach ($permissions as $item)
                                <div class="custom-control custom-switch col-sm-4">
                                    <input {{isset($alreadyPermissions[$item['id']]) ? "checked" : "" }} type="checkbox" name="permission-{{ $item['id'] }}" class="custom-control-input"
                                        id="{{ $item['id'] }}">
                                    <label class="custom-control-label" for="{{ $item['id'] }}">{{ $item['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="input-group">
                        <button class="btn btn-primary" type="submit">Update Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection