@extends('../../layouts.app')

@section('content')
    <div class="container mx-auto mt-10 p-6 bg-white rounded-md shadow-md">
        <h2 class="text-xl font-semibold mb-4">Edit Category</h2>

        <div class="flex justify-end mb-4">
            <a href="{{ route('category.index') }}" class="btn btn-dark flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-arrow-left-circle-fill mr-1" viewBox="0 0 16 16">
                    <path
                        d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
                </svg>
                Back
            </a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('category.update', $category->id) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Category:</label>
                <input type="text" class="form-input mt-1 block w-full rounded-md border-gray-300" id="name"
                    name="name" value="{{ $category->name }}">
                @error('name')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tax_percentage" class="block text-sm font-medium text-gray-700">Tax Percentage:</label>
                <input type="text" class="form-input mt-1 block w-full rounded-md border-gray-300" id="tax_percentage"
                    name="tax_percentage" value="{{ $category->tax_percentage }}">
                @error('tax_percentage')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="btn btn-primary px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                Update
            </button>
        </form>
    </div>
@endsection
