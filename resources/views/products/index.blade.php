@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Products</h1>
        <div class="d-flex gap-3">
            <a href="{{ route('products.create') }}" class="btn btn-primary">Add product</a>
        </div>
    </div>

    <form action="{{ route('products.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control"
                placeholder="Search your product by Product ID or Description" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex gap-3">
        <button class="btn btn-primary">
            <a class="text-white text-decoration-none"
                href="{{ route('products.index', ['sort' => 'name', 'direction' => $sortField == 'name' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                Sort by Name
                @if ($sortField == 'name')
                    @if ($sortDirection == 'asc')
                        &uarr;
                    @else
                        &darr;
                    @endif
                @endif
            </a>
        </button>

        <button class="btn btn-primary">
            <a class="text-white text-decoration-none"
                href="{{ route('products.index', ['sort' => 'price', 'direction' => $sortField == 'price' && $sortDirection == 'asc' ? 'desc' : 'asc', 'search' => request('search')]) }}">
                Sort by Price
                @if ($sortField == 'price')
                    @if ($sortDirection == 'asc')
                        &uarr;
                    @else
                        &darr;
                    @endif
                @endif
            </a>
        </button>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th scope="col">Product ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->product_id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->description }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="100"></td>
                        <td class="d-flex">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm me-2">View</a>
                            <a href="{{ route('products.edit', $product->id) }}"
                                class="btn btn-warning btn-sm me-2">Edit</a>
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $products->appends(['sort' => $sortField, 'direction' => $sortDirection, 'search' => $search])->links('pagination::bootstrap-5') }}
    </div>
@endsection
