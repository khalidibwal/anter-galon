@extends('Component.Landing.AdminLayout')

@section('content')
<div class="max-w-3xl mx-auto">

    {{-- Page Title --}}
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">
            Edit Product
        </h2>
        <p class="text-sm text-gray-500">
            Update product information below
        </p>
    </div>

    {{-- Form Card --}}
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Product Name --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Product Name
                </label>
                <input
                    type="text"
                    name="name"
                    value="{{ $product->name }}"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                           focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            {{-- Description --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Description
                </label>
                <textarea
                    name="description"
                    rows="3"
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                           focus:border-blue-500 focus:ring focus:ring-blue-200">{{ $product->description }}</textarea>
            </div>

            {{-- Price --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Price (Rp)
                </label>
                <input
                    type="number"
                    step="0.01"
                    name="price"
                    value="{{ $product->price }}"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                           focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            {{-- Stock --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Stock
                </label>
                <input
                    type="number"
                    name="stock"
                    value="{{ $product->stock }}"
                    required
                    class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm
                           focus:border-blue-500 focus:ring focus:ring-blue-200">
            </div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-4">
                <button
                    type="submit"
                    class="inline-flex justify-center rounded-md bg-yellow-500 px-4 py-2
                           text-sm font-medium text-white hover:bg-yellow-600 transition">
                    Update Product
                </button>

                <a
                    href="{{ route('admin.products.index') }}"
                    class="inline-flex justify-center rounded-md bg-gray-200 px-4 py-2
                           text-sm font-medium text-gray-700 hover:bg-gray-300 transition">
                    Back
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
