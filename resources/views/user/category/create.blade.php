@extends('../../layouts.app')

@section('content')
    <div class="container mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
        <h2 class="text-xl font-semibold mb-4">Create New Category</h2>

        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('category.index') }}" class="btn btn-dark">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                    </svg>&nbsp;Back
                </a>
            </div>
        </div>

        <form action="{{ route('category.store') }}" method="POST" class="flex flex-col space-y-4">
            @csrf
            <div class="w-full">
                <label for="name" class="block text-sm font-medium text-gray-700">Category :</label>
                <input type="text" name="name" id="name"
                    class="mt-1 px-3 py-2 block w-full rounded-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <br><br>

            <div class="w-full">
                <label for="tax_percentage" class="block text-sm font-medium text-gray-700">Tax Percentage :</label>
                <input type="text" name="tax_percentage" id="tax_percentage"
                    class="mt-1 px-3 py-2 block w-full rounded-md border border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    required>
                @error('tax_percentage')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <br><br>

            <div class="flex justify-end">
                <button type="submit" class="btn btn-primary btn-sm">Create Category</button>
            </div>
        </form>
    </div>
@endsection
