@extends('layouts.index')
@section('title')
    Book |  {{ config('app.name') }}
@endsection
@section('content')
    <div class="container-fluid">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Update Book</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('books.update.post') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{ $data['id'] }}">
                        <label for="basic-url">Name</label>
                        <div class="input-group mb-3">
                            <input value="{{ $data['name'] }}" name="name" required type="text" class="form-control"
                                id="basic-url" aria-describedby="basic-addon3">
                        </div>

                        @can('books.update')
                            <div class="input-group">
                                <button class="btn btn-primary" type="submit">Update Data</button>
                            </div>
                        @endcan
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection