@extends('layouts.app')

@section('content')

    <div class="container">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                            <a href="#" class="btn btn-primary mr-3">Show</a>
                            <a href="#" class="btn btn-warning mr-3">Edit</a>
                            <form class="d-inline-block" method="POST" action="{{route('admin.categories.destroy', ['category' => $category->id])}}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger me-2 ">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection