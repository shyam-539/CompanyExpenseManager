@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                    <div class="card-tools">
                        <div class="row justify-content-center mt-4">
                            <div class="col-md-10 d-flex justify-content-end">
                                <a href="{{ route('category.create') }}" class="btn btn-dark">Create</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Tax Percentage</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->tax_percentage }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>{{ $category->updated_at }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', $category->id) }}"
                                            class="btn btn-success">Edit</a>
                                        <a href = "#" onclick="deleteCategory({{ $category->id }});"
                                            class = "btn btn-danger">Delete</a>
                                        <form id="delete-product-from-{{ $category->id }}"
                                            action = "{{ route('category.destroy', $category->id) }}" method = "post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            {{ $categories->links() }}
            <!-- /.card -->
        </div>
    </div>
@endsection

<!-- jquery cdn -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    function deleteCategory(id) {
        if (confirm('Are you sure you want to delete this category?')) {
            $.ajax({
                url: 'categories/' + id,
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
                    alert('Error deleting category');
                }
            });
        }
    }
</script>
