@extends('layouts.app')

@section('content')
    <style>
        /* Invoice style */
        .invoice {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .invoice-header h2 {
            margin-top: 0;
        }

        .invoice-body {
            padding: 20px 0;
        }

        .invoice-footer {
            border-top: 1px solid #ccc;
            padding-top: 20px;
            margin-top: 20px;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Expense Details</div>

                    <div class="card-body">
                        <div class="invoice">
                            <div class="invoice-header">
                                <h2>Expense Details</h2>
                            </div>
                            <div class="invoice-body">
                                <p><strong>Category:</strong> {{ $expense->category->name }}</p>
                                <p><strong>Amount:</strong> {{ $expense->amount }}</p>
                                <p><strong>Tax Percentage:</strong> {{ $expense->tax_percentage }}</p>
                                <p><strong>Net Amount:</strong> {{ $expense->net_amount }}</p>

                                <!-- Display expense images -->
                                @if ($expense->files->count() > 0)
                                    <p><strong>Invoices:</strong></p>
                                    <div class="row">
                                        @foreach ($expense->files as $file)
                                            <div class="col-md-3">
                                                <img src="{{ asset('storage/' . $file->file) }}" class="img-thumbnail"
                                                    alt="Expense Image">
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection