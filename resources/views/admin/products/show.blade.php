<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <a href="{{ route('admin.products.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            &larr; Back to Products
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-semibold mb-4">Product Information</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">ID</label>
                                <p class="mt-1 text-gray-900">{{ $product->id }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Name</label>
                                <p class="mt-1 text-gray-900">{{ $product->name }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <p class="mt-1 text-gray-900">{{ $product->category->name }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Description</label>
                                <p class="mt-1 text-gray-900">{{ $product->description ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-semibold mb-4">Pricing & Stock</h3>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Price</label>
                                <p class="mt-1 text-gray-900 text-2xl font-bold">${{ number_format($product->price, 2) }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Stock</label>
                                <p class="mt-1 text-gray-900">{{ $product->stock }} units</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $product->enabled ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Created At</label>
                                <p class="mt-1 text-gray-900">{{ $product->created_at->format('Y-m-d H:i:s') }}</p>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                <p class="mt-1 text-gray-900">{{ $product->updated_at->format('Y-m-d H:i:s') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-4">
                        <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Product
                        </a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this product?')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Product
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>