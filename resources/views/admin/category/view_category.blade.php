<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')
</head>

<body>
    <div class="container-scroller">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.sidebar')
        <!-- partial -->
        @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                        <strong>{{ session()->get('message') }}</strong>
                        <button type="button" class="fw-bold" data-bs-dismiss="alert" aria-label="Close">X</button>
                    </div>
                @endif
                <div class="div_center text-center p-4">
                    <h2 class="fs-2 fw-bold">Add Category</h2>
                    <form action="{{ route('add_category') }}" method="POST">
                        @csrf
                        <input class="mt-4 border rounded-3 text-black" type="text" name="add_category"
                            id="add_category" value="{{ old('add_category') }}" placeholder="Add_Category">
                        <input type="submit" value="Add Category" name="submit" class="btn btn-primary">
                    </form>
                </div>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @php
                        $sno = 1;
                    @endphp
                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <th scope="row">{{ $sno++ }}</th>
                                <td>{{ $category->category_name }}</td>
                                <td>
                                    <a onclick="return confirm('Are you sure watn to Delete this?')"
                                        href="{{ route('delete_category', $category->id) }}"
                                        class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">No data found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
        <!-- End custom js for this page -->
</body>

</html>
