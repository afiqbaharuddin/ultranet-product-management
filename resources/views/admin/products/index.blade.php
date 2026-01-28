<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
</div>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Header Actions -->
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Products List</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('admin.products.export') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Export to Excel
                            </a>
                            <a href="{{ route('admin.products.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Product
                            </a>
                        </div>
                    </div>

                    <!-- Filters -->
                    <form method="GET" action="{{ route('admin.products.index') }}" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Enabled</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Disabled</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                                <a href="{{ route('admin.products.index') }}" class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                    Clear
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Bulk Actions Form -->
                    <form id="bulkDeleteForm" method="POST" action="{{ route('admin.products.bulk-delete') }}">
                        @csrf
                        <div class="mb-4">
                            <button type="submit" onclick="return confirm('Are you sure you want to delete selected products?')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                Delete Selected
                            </button>
                        </div>

                        <!-- Products Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left">
                                            <input type="checkbox" id="selectAll" class="rounded">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" name="ids[]" value="{{ $product->id }}" class="product-checkbox rounded">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->id }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->category->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($product->price, 2) }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $product->stock }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $product->enabled ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $product->enabled ? 'Enabled' : 'Disabled' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('admin.products.show', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                                <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">No products found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </form>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Select All Checkbox
        document.getElementById('selectAll').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.product-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    </script>
</x-app-layout>