@extends('admin.master')

@section('title','Create Category')

@section('content')

<div class="d-flex justify-content-between align-items-center">

    <h1>Add New Category</h1>

    <a class="btn btn-outline-success" onclick="window.history.back()">Return Back</a>


</div>

@include('admin.errors')

<div class="card shadow mt-4 mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                @include('admin.categories.form')

                    <div class="col-md-12">
                        <button class="btn btn-success px-5">Add</button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>


@stop
