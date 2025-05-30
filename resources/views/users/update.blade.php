@extends('layouts.index')
@section('title')
    User |  {{ config('app.name') }}
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update User</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update.post') }}" method="post">
                    @csrf

                    <input type="hidden" name="id" value="{{ $data['id'] }}">

                    <div class="form-group">
                        <label for="basic-url">Email</label>
                        <div class="input-group mb-3">
                            <input value="{{ $data['email'] }}" name="email" required type="email" class="form-control"
                                id="basic-url" aria-describedby="basic-addon3">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="basic-url">Name</label>
                        <div class="input-group mb-3">
                            <input value="{{ $data['name'] }}" name="name" required type="text" class="form-control"
                                id="basic-url" aria-describedby="basic-addon3">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="basic-url">Role</label>
                        <div class="input-group mb-3">
                            <select name="role" class="custom-select">
                                @foreach ($roles as $item)
                                    <option {{ $item['id'] == $data['roles'][0]['id'] ? "selected" : "" }}
                                        value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="basic-url">Password</label>
                        <div class="input-group mb-3">
                            <input name="password" required type="text" class="form-control" id="basic-url"
                                aria-describedby="basic-addon3">
                        </div>

                    </div>

                    @can('users.update')
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Create Data</button>
                        </div>
                    @endcan
                </form>
            </div>
        </div>
    </div>
@endsection