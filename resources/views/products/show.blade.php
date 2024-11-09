@extends('layouts.app')

@section('content')
    <h1 class="h3 mb-4">Product Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Name: {{ $product->name }}</h5>
            <p class="card-text">Product ID: {{ $product->product_id }}</p>
            <p class="card-text">Description: {{ $product->description }}</p>
            <p class="card-text">Price: {{ number_format($product->price, 2) }}</p>
            <p class="card-text">Stock: {{ $product->stock }}</p>
            <p class="card-text">Image: </p>

            @if ($product->image)
                <p>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="100">
                </p>
            @endif

            <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
        </div>
