@extends('admin.master')

@section('title','Create video')



@section('content')

<div class="d-flex justify-content-between align-items-center">

    <h1>Add New video</h1>

    <a class="btn btn-outline-success" onclick="window.history.back()">Return Back</a>


</div>

@include('admin.errors')

<div class="card shadow mt-4 mb-4">

    <div class="card-body">
        <div class="table-responsive">
            <form action="{{ route('admin.videos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @include('admin.videos.form')

                    <div class="col-md-12">
                        <button class="btn btn-success px-5">Add</button>
                    </div>

                </div>

            </form>
        </div>
    </div>
</div>


@stop
