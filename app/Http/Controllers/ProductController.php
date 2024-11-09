<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller {
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request) {
		$sortField     = $request->input('sort', 'name');
		$sortDirection = $request->input('direction', 'asc');

		$search = $request->input('search');
		$query  = Product::query();

		if ($search) {
			$query->where('product_id', 'like', '%' . $search . '%')
				->orWhere('description', 'like', '%' . $search . '%');
		}

		$products = $query->orderBy($sortField, $sortDirection)->paginate(10);

		return view('products.index', compact('products', 'sortField', 'sortDirection', 'search'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create() {
		return view('products.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */

	public function store(Request $request) {
		$request->validate([
			'product_id' => 'required|string|unique:products',
			'name'       => 'required|string',
			'price'      => 'required|numeric',
		]);

		$imagePath = null;
		if ($request->hasFile('image')) {
			$image     = $request->file('image');
			$imageName = time() . '.' . $image->getClientOriginalExtension();
			$imagePath = $image->storeAs('images', $imageName, 'public');
		}

		Product::create([
			'product_id'  => $request->product_id,
			'name'        => $request->name,
			'price'       => $request->price,
			'description' => $request->description,
			'stock'       => $request->stock,
			'image'       => $imagePath,
		]);

		return redirect()->route('products.index')->with('success', 'Product created successfully.');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(string $id) {
		$product = Product::find($id);

		return view('products.show', compact('product'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(string $id) {
		$product = Product::find($id);

		return view('products.edit', compact('product'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, string $id) {
		$request->validate([
			'product_id' => 'required|unique:products,product_id,' . $id,
			'name'       => 'required',
			'price'      => 'required',
		]);

		$product = Product::findOrFail($id);

		$product->update($request->only(['product_id', 'name', 'price', 'description', 'stock', 'image']));

		return redirect()->route('products.index')->with('success', 'Product updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(string $id) {
		$product = Product::findOrFail($id);
		$product->delete();

		return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
	}
}
