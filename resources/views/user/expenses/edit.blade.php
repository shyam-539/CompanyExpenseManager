@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-md shadow-md">
    <h3 class="text-xl font-bold mb-4">Welcome, {{ Auth::user()->name }}</h3>
    <h2 class="text-xl font-semibold mb-4">Update Expense</h2>

    <form id="expenseForm" action="{{ route('expenses.update', $expense->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Category -->
        <div class="mb-4">
            <label for="category_id" class="block text-sm font-medium text-gray-700">Category:</label>
            <select name="category_id" id="category_id" class="form-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" onchange="updateTaxPercentage()">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" data-tax="{{ $category->tax_percentage }}" {{ $expense->category_id == $category->id? "selected": "" }}  >{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Amount -->
        <div class="mb-4">
            <label for="amount" class="block text-sm font-medium text-gray-700">Amount:</label>
            <input type="number" name="amount" id="amount" value={{ $expense->amount }} required class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" onchange="calculateTotals()">
        </div>

        <!-- Tax Percentage -->
        <div class="mb-4">
            <label for="tax_percentage" class="block text-sm font-medium text-gray-700">Tax Percentage:</label>
            <input type="text" name="tax_percentage" id="tax_percentage" value={{ $expense->tax_percentage }} class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
        </div>

        <!-- Tax Amount -->
        <div class="mb-4">
            <label for="tax_amount" class="block text-sm font-medium text-gray-700">Tax Amount:</label>
            <input type="text" name="tax_amount" id="tax_amount" value={{ $expense->tax_amount }} class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
        </div>

        <!-- Net Amount -->
        <div class="mb-4">
            <label for="net_amount" class="block text-sm font-medium text-gray-700">Net Amount:</label>
            <input type="text" name="net_amount" id="net_amount" value={{ $expense->net_amount }} class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
        </div>

        <!-- Images section -->
        <div class="mb-4">
            <label for="images" class="block text-sm font-medium text-gray-700">Images:</label>
            <div id="imageInputs">
                <input type="file" name="images[]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <button type="button" onclick="addImageInput()" class="btn btn-secondary mt-2">Add Image</button>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
            Submit
        </button>
    </form>
</div>

<script>
function updateTaxPercentage() {
    let selectedOption = document.querySelector('#category_id').selectedOptions[0];
    let taxPercentage = selectedOption.getAttribute('data-tax');
    document.getElementById('tax_percentage').value = taxPercentage;
    calculateTotals();
}

function calculateTotals() {
    let amount = parseFloat(document.getElementById('amount').value) || 0;
    let taxPercentage = parseFloat(document.getElementById('tax_percentage').value) || 0;
    let taxAmount = amount * (taxPercentage / 100);
    let netAmount = amount + taxAmount;

    document.getElementById('tax_amount').value = taxAmount.toFixed(2);
    document.getElementById('net_amount').value = netAmount.toFixed(2);
}

function addImageInput() {
    let imageInputs = document.getElementById('imageInputs');
    let input = document.createElement('input');
    input.type = 'file';
    input.name = 'images[]';
    input.className = 'form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm';
    imageInputs.appendChild(input);
}

window.onload = function() {
    updateTaxPercentage(); // Initial update when the page loads
}
</script>

@endsection
