@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expenses</h3>
                    <br><br>
                    <form action="{{ route('expenses.filter') }}" method="get" class="mb-4">
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
                    <div class="card-tools">
                        <div class="row justify-content-center mt-4">
                            <div class="col-md-10 d-flex justify-content-end">
                                <a href="{{ route('expenses.create') }}" class="btn btn-dark">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">

                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Tax Percentage</th>
                                <th>Tax Amount</th>
                                <th>Net Amount</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($expenses->isNotEmpty())
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
                                        <td>
                                            <a href="{{ route('expenses.edit', $expense->id) }}"
                                                class="btn btn-dark">Edit</a>
                                            <a href="{{ route('expenses.show', $expense->id) }}"
                                                class="btn btn-primary">Show</a>
                                            <a href = "#" onclick="deleteExpense({{ $expense->id }});"
                                                class = "btn btn-danger">Delete</a>
                                            <form id="delete-product-from-{{ $expense->id }}"
                                                action = "{{ route('expenses.destroy', $expense->id) }}" method = "post">
                                                @csrf
                                                @method('delete')
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            {{ $expenses->links() }}
            <!-- /.card -->
        </div>
    </div>
@endsection

<!-- jquery cdn -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function deleteExpense(id) {
        if (confirm('Are you sure you want to delete this expense?')) {
            $.ajax({
                url: '/expenses/' + id,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);
                    window.location.reload(); // Reload the page after successful deletion
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert('Error deleting expense');
                }
            });
        }
    }
</script>
