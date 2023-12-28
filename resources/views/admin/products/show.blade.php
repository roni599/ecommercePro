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
                    <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between"
                        role="alert">
                        <strong>{{ session()->get('message') }}</strong>
                        <button type="button" class="fw-bold" data-bs-dismiss="alert" aria-label="Close">X</button>
                    </div>
                @endif
                <div class="div_center text-center p-4">
                    <h1 class="fs-2 fw-bold text-center pt-1">All Products</h1>
                </div>
                <table class="table table-bordered mt-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Price</th>
                            <th scope="col">Discount</th>
                            <th scope="col">Quentity</th>
                            <th scope="col">Category</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    @php
                        $sno = 1;
                    @endphp
                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <th scope="row">{{ $sno++ }}</th>
                                <td>{{ $product->product_title }}</td>
                                <td>{{ $product->prouct_description }}</td>
                                <td>{{ $product->product_price }}</td>
                                @if ($product->product_discount !== null)
                                <td>{{ $product->product_discount }}</td>
                                @else
                                    <td>No discount available</td>
                                @endif
                                <td>{{ $product->product_quentity }}</td>
                                <td>{{ $product->product_category }}</td>
                                <td>
                                    <img src="{{ asset('uploads') }}/{{ $product->product_image }}"
                                        alt="">
                                </td>
                                <td>
                                    <a href="{{ route('edit_products', $product->id) }}"
                                        class="btn btn-sm btn-danger">Edit</a>
                                    <a onclick="return confirm('Are you sure watn to Delete this?')"
                                        href="{{ route('delete_products', $product->id) }}"
                                        class="btn btn-sm btn-danger">Delete</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="">
                                <td colspan="9" class="text-center text-white">No data Found</td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
</body>

</html>
