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
                {{-- @if (session('success'))
                    <div id="alert-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif --}}
                <div class="div_center text-center p-4">
                    <h2 class="fs-2 fw-bold text-center pt-1">Update Products</h2>
                    <form action="{{ route('update_products', $products->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="mb-0">
                            <label for="product_title">Product Title : </label>
                            <input class="mt-4 ms-5 border rounded-3 text-black" type="text" name="product_title"
                                id="product_title" value="{{ $products->product_title }}" placeholder="Product Title">
                        </div>
                        <div class="mb-1">
                            <label for="prouct_description">Product Description : </label>
                            <input class="mt-1 border rounded-3 text-black" type="text" name="prouct_description"
                                id="prouct_description" value="{{ $products->prouct_description }}"
                                placeholder="Prouct Description">
                        </div>
                        <div class="mb-1">
                            <label for="product_price">Product Price : </label>
                            <input class="mt-1 ms-5 border rounded-3 text-black" type="text" name="product_price"
                                id="product_price" value="{{ $products->product_price }}" placeholder="Product Price">
                        </div>
                        <div class="mb-1">
                            <label for="product_discount">Discount Price : </label>
                            <input class="mt-1 ms-5 border rounded-3 text-black" type="text" name="product_discount"
                                id="product_discount" value="{{ $products->product_discount }}"
                                placeholder="Product Discount">
                        </div>
                        <div class="mb-2">
                            <label for="product_quentity">Product Quentity : </label>
                            <input class="mt-1 ms-4 border rounded-3 text-black" type="text" name="product_quentity"
                                id="product_quentity" value="{{ $products->product_quentity }}"
                                placeholder="Product Quentity">
                        </div>
                        <div class="mb-1">
                            <label for="product_category" class="ms-3">Product Category : </label>
                            <select class="mt-1 ms-4 border rounded-3 text-black " name="product_category"
                                aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->category_name }}">{{ $category->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2 d-flex justify-content-start gap-2" style="margin-left:305px">
                            <label for="product_image" class=" mt-4">Current Product Image : </label>
                            <img class="rounded"
                                src="{{ asset('uploads') }}/{{ $products->product_image }}"
                                width="70" height="50" alt="">
                        </div>
                        <div class="mb-1">
                            <label for="product_image" class="ms-5">Change Product Image : </label>
                            <input class="mt-1 ms-0 border rounded-3 text-white w-25 " type="file" name="image"
                                id="product_image" value="">
                        </div>
                        <br>
                        <input type="submit" value="Add Product" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        <!-- container-scroller -->
        <!-- plugins:js -->
        @include('admin.script')
        <!-- End custom js for this page -->

        {{-- show alert sms and hide alert sms code --}}
        {{-- <script>
            document.addEventListener('DOMContentLoaded', function() {
                var alertMessage = document.getElementById('alert-message');
                if (alertMessage) {
                    setTimeout(function() {
                        alertMessage.style.display = 'none';
                    }, 10000);
                }
            });
        </script> --}}
</body>

</html>
