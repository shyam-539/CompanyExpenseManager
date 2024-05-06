@extends('layouts.app')

@section('content')
    <style>
        /* Invoice style */
        .invoice-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .invoice-body {
            padding: 20px;
        }

        .invoice-table {
            width: 100%;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
        }

        .invoice-total {
            background-color: #343a40;
            color: #fff;
            padding: 20px;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    </style>

    <div class="row">
        <div class="col-md-12">
            <form action="#" method="get" class="mb-4">
                <!-- Filter form -->
                <div class="row">
                    <div class="col-md-3">
                        <select name="category" class="form-control">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control" placeholder="Start Date">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control" placeholder="End Date">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if (!empty($expenses))
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="invoice-container">
                    <div class="invoice-header">
                        <h5 class="card-title">Filtered Expenses</h5>
                    </div>
                    <div class="invoice-body">
                        <table class="invoice-table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Tax Percentage</th>
                                    <th>Tax Amount</th>
                                    <th>Net Amount</th>
                                    <th>Created At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($expenses as $expense)
                                    <tr>
                                        <td>{{ $expense->id }}</td>
                                        <td>{{ $expense->user->name }}</td>
                                        <td>{{ $expense->category->name }}</td>
                                        <td>{{ $expense->amount }}</td>
                                        <td>{{ $expense->tax_percentage }}</td>
                                        <td>{{ $expense->tax_amount }}</td>
                                        <td>{{ $expense->net_amount }}</td>
                                        <td>{{ $expense->created_at->format('d M, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="invoice-container">
                    <div class="invoice-total">
                        <h5 class="card-title">Total Net Amount</h5>
                    </div>
                    <div class="invoice-body">
                        <p>{{ $totalExpense }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
