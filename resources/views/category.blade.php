@extends('app')
@section('title','Category')

@section('content')


    <div class="container mt-5">
        <h4>Category Page</h4>
        @if(session ('success'))
        <div class="alert alert-success">
        {{session('success')}}
        </div>
        @endif

        <form action="{{ $editdata ? route('category.update',$editdata->id) : route('category.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @if($editdata)
            @method('PUT')
            @endif
            <input type="hidden" name="catid" id="catid" value="{{ $editdata ? $editdata->id : '' }}">
            <div class="form-group">
                <label for="catname">Category</label>
                <input type="text" name="catname" id="catname" class="form-control" value="{{ $editdata ? $editdata->catname : '' }}">
                @error('catname')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="catimg">Category Image</label>
                <input type="file" name="image" id="image" class="form-control-file">
                <br><br>
                <img src="{{ $editdata ? asset('catimages/'.$editdata->image):'' }}" width="100" height="100">
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
        <br><br>
        <table class="table table-bordered">
            <caption>Category List</caption>
            <thead class="thead-light">
                <tr>
                    <th>Id</th>
                    <th>Category</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($catdata as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>

                    <td><img src="{{ asset('catimages/'.$cat->image) }}" width="100" height="100"></td>
                    
                    <td>{{ $cat->catname }}</td>
                    <td>
                        <form action="{{ route('category.edit',$cat->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('PATCH')
                        <button type="submit" class="btn btn-warning btn-sm">Edit</button>
                        </form>
                        <form action="{{ route('category.destroy',$cat->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection