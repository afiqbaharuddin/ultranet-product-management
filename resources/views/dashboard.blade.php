<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-semibold mb-4">{{ __("Welcome to Ultranet Product Management!") }}</h3>
                    <p class="mb-6">{{ __("You're logged in!") }}</p>

                    <!-- Management Links -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Product Management Card -->
                        <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Product Management</h4>
                            <p class="text-gray-600 mb-4">Create, read, update, and delete products. Export to Excel and
                                manage inventory.</p>
                            <a href="{{ route('admin.products.index') }}"
                                class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Manage Products
                            </a>
                        </div>

                        <!-- Category Management Card -->
                        <div class="border rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <h4 class="text-xl font-bold text-gray-800 mb-2">Category Management</h4>
                            <p class="text-gray-600 mb-4">Organize your products by creating and managing categories.
                            </p>
                            <a href="{{ route('admin.categories.index') }}"
                                class="inline-block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Manage Categories
                            </a>
                        </div>
                    </div>

                    <!-- API Documentation Link -->
                    <div class="mt-8 pt-6 border-t">
                        <h4 class="text-lg font-semibold mb-2">API Documentation</h4>
                        <p class="text-gray-600 mb-4">Access the comprehensive Swagger API documentation for
                            integration.</p>
                        <a href="{{ url('/api/documentation') }}" target="_blank"
                            class="inline-block bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                            View API Docs
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>