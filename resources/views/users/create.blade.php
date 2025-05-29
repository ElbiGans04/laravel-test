@extends('layouts.index')
@section('title')
    User | Bengkel APP
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create User</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('users.create.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="basic-url">Email</label>
                        <div class="input-group mb-3">
                            <input name="email" required type="email" class="form-control" id="basic-url"
                                aria-describedby="basic-addon3">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="basic-url">Name</label>
                        <div class="input-group mb-3">
                            <input name="name" required type="text" class="form-control" id="basic-url"
                                aria-describedby="basic-addon3">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="basic-url">Role</label>
                        <div class="input-group mb-3">
                            <select name="role" class="custom-select">
                                @foreach ($data as $item)
                                    <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
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

                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Create Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection