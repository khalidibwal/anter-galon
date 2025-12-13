@extends('Component.Landing.AdminLayout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
        <h2 class="text-lg font-semibold text-gray-800">
            Product List
        </h2>

        <a href="{{ route('admin.products.create') }}"
           class="inline-flex items-center justify-center rounded-md
                  bg-blue-600 px-4 py-2 text-sm font-medium text-white
                  hover:bg-blue-700 transition w-full sm:w-auto">
            + Add Product
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="overflow-x-auto rounded-lg border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">
                        #
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500">
                        Product
                    </th>
                    <th class="hidden md:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500">
                        Price
                    </th>
                    <th class="hidden md:table-cell px-4 py-3 text-left text-xs font-semibold text-gray-500">
                        Stock
                    </th>
                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500">
                        Action
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-700">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="text-sm font-medium text-gray-800">
                                {{ $product->name }}
                            </div>

                            {{-- Mobile info --}}
                            <div class="mt-1 text-xs text-gray-500 md:hidden">
                                Rp {{ number_format($product->price, 2) }} •
                                Stock {{ $product->stock }}
                            </div>
                        </td>

                        <td class="hidden md:table-cell px-4 py-3 text-sm text-gray-700">
                            Rp {{ number_format($product->price, 2) }}
                        </td>

                        <td class="hidden md:table-cell px-4 py-3 text-sm text-gray-700">
                            {{ $product->stock }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex flex-col sm:flex-row justify-center gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="rounded-md bg-yellow-500 px-3 py-1.5 text-xs font-medium text-white
                                          hover:bg-yellow-600 transition text-center">
                                    Edit
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Are you sure?')"
                                            class="w-full rounded-md bg-red-600 px-3 py-1.5 text-xs
                                                   font-medium text-white hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="px-4 py-6 text-center text-sm text-gray-500">
                            No products found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4 flex justify-center">
        {{ $products->links() }}
    </div>

</div>
@endsection
