<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BulkDeleteProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Exports\ProductsExport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index(Request $request): View
    {
        $query = Product::with('category');

        // Filter by enabled status
        if ($request->has('status') && $request->status !== '') {
            $query->where('enabled', $request->status);
        }

        // Search by name
        if ($request->has('search') && $request->search !== '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->latest()->paginate(15);
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(StoreProductRequest $request): RedirectResponse
    {
        Product::create($request->validated());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product): View
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product): View
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }

    /**
     * Bulk delete products.
     */
    public function bulkDelete(BulkDeleteProductRequest $request): RedirectResponse
    {
        $deletedCount = Product::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.products.index')
            ->with('success', "{$deletedCount} product(s) deleted successfully.");
    }

    /**
     * Export products to Excel.
     */
    public function export(): BinaryFileResponse
    {
        return Excel::download(new ProductsExport, 'products_' . date('Y-m-d_His') . '.xlsx');
    }
}