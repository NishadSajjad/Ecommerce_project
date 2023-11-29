@extends('admin.layouts.template')
@section('page_title')
  All-subCategory
@endsection
@section('content')
  <div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Page/</span> All Sub Category</h4>
    
    @if (session()->has('message'))
    <div class="alert alert-success">
      {{session()->get('message')}}
    </div>
    @endif

      <div class="card">
        <h5 class="card-header">Available Sub Category information</h5>
        <div class="table-responsive text-nowrap">
          <table class="table">
            <thead class="table-light">
              <tr>
                <th>Id</th>
                <th>Sub Category Name</th>
                <th>Category</th>
                <th>Product</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
              @foreach ($subCategories as $subCategory)
              <tr>
                <td>{{$subCategory->id}}</td>
                <td>{{$subCategory->subcategory_name}}</td>
                <td>{{$subCategory->category->category_name}}</td>
                <td>100</td>
                <td>
                    <a href="{{route('editsubcat' , $subCategory->id)}}" class="btn btn-primary">Edit</a>
                    <a href="{{route('deletesubcat' , $subCategory->id)}}" class="btn btn-warning">Delete</a>
                </td>
            </tr>
              @endforeach
                  
            </tbody>
          </table>
        </div>
      </div
    </div>
@endsection