<!-- resources/views/products/create.blade.php -->
@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4">Add New Product</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" class="needs-validation" enctype="multipart/form-data"
        novalidate>
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Product ID <strong class="text-danger">*</strong></label>
            <input type="text" name="product_id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Product Name <strong class="text-danger">*</strong></label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Price <strong class="text-danger">*</strong></label>
            <input type="number" step="0.01" name="price" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" class="form-control">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
@endsection
