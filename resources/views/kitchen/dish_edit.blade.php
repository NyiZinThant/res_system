@extends('layouts.master')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Kitchen Panel</h1>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Create Dish</h3>
                            </div>

                            <div class="card-body">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </div>
                                @endif
                                <form action="{{ route('dish.update', ['dish'=>$dish->id]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <label for="">Name</label>
                                    <input type="text" name="name" class="form-control mb-3" value="{{ old("name")?: $dish->name }}">
                                    <label for="">Category</label>
                                    <select name="category_id" class="form-control mb-3">
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"{{ $category->id == $dish->category_id ? "selected" : ""}}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="" style="width: 100%">Image</label>
                                    <img src="{{ url('/images/'.$dish->image) }}" class="img-fluid">
                                    <input type="file" name="dish_image" class="form-control mb-3" style="padding-bottom: 36px">
                                    <input type="submit" value="submit" value="Submit" class="btn btn-primary">
                                    <a href="/dish" class="btn btn-default">Back</a>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-md-6 -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection