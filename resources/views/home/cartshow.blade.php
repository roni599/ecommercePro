<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('ui/frontend') }}/{{ asset('ui/frontend') }}/images/favicon.png"
        type="">
    <title>ecommercePro_cartshow_page</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('ui/frontend') }}/css/bootstrap.css" />
    <!-- font awesome style -->
    <link href="{{ asset('ui/frontend') }}/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('ui/frontend') }}/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('ui/frontend') }}/css/responsive.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    @include('sweetalert::alert');
    <div class="hero_area">
        <!-- header section strats -->
        @include('home.header')
        <!-- end header section -->
        {{-- @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                <strong>{{ session()->get('message') }}</strong>
                <button type="button" class="fw-bold" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        @endif --}}
        @php
            $count = 0;
        @endphp
        @foreach ($carts as $cart)
            @php
                $count++;
            @endphp
        @endforeach
        @if ($count > 0)
            <table class="table table-bordered w-50 mx-auto mt-5">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Title</th>
                        <th scope="col">Product Quentity</th>
                        <th scope="col">image</th>
                        <th scope="col">Action</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                @php
                    $sno = 1;
                    $total = 0;
                @endphp
                <tbody>
                    @forelse ($carts as $cart)
                        <tr>
                            <th scope="row">{{ $sno++ }}</th>
                            <td>{{ $cart->product_title }}</td>
                            <td>{{ $cart->quentity }}</td>
                            <td>
                                <img src="{{ asset('uploads') }}/{{ $cart->image }}" width="50" height="50"
                                    alt="">
                            </td>
                            <td>
                                <a onclick="return confirmation(event)" href="{{ route('remove_cart', $cart->id) }}"
                                    class="btn btn-sm btn-danger">Delete</a>
                            </td>
                            <td>${{ $cart->price }}</td>
                        </tr>
                        @php
                            $total = $total + $cart->price;
                        @endphp
                    @empty
                        <tr class="">
                            <td colspan="6 mt-5" class="text-center text-white">No data Found</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td class="text-center" colspan="5">Total</td>
                        <td colspan="">${{ $total }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="button text-center">
                <h1 class="mb-2 h5">Procced To Pay</h1>
                <a href="{{ route('cash_order') }}" class="btn btn-sm btn-danger p-3">Cash on delevary</a>
                <a href="{{ route('stripe', $total) }}" class="btn btn-sm btn-danger p-3">Pay using Card</a>
                {{-- <a href="{{ route('stripe', $total) }}" class="btn btn-sm border tt">
                    <img src="{{ asset('ui/frontend/images/bkash.png') }}" alt="" class="" width="110" height="47">
                </a> --}}
                <a href="{{ route('bkash-create-payment.post',$total) }}" class="btn btn-sm border tt">
                    <img src="{{ asset('ui/frontend/images/bkash.png') }}" alt="" class="" width="110" height="47">
                </a>
                {{-- <a href="{{ route('stripe', $total) }}" class="btn btn-sm btn-danger p-3 d-flex align-items-center justify-content-center">
                    <img src="{{ asset('ui/frontend/images/bkash.png') }}" alt="" class="" width="110" height="47">
                </a> --}}
            </div>
        @else
            @if (session()->has('message'))
                <div class="button text-center m-auto  d-flex justify-content-between">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{ session()->get('message') }}</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
                    </div>
                </div>
            @else
                <div class="button text-center m-auto">
                    <h1 class="h1 fw-bold text-danger">You Have No Product Iteam In Card Menu</h1>
                </div>
            @endif

        @endif
    </div>
    <!-- footer start -->
    @include('home.footer')
    <!-- footer end -->
    <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>

            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>

        </p>
    </div>
    <!-- jQery -->
    <script src="{{ asset('ui/frontend') }}/js/jquery-3.4.1.min.js"></script>
    <!-- popper js -->
    <script src="{{ asset('ui/frontend') }}/js/popper.min.js"></script>
    <!-- bootstrap js -->
    <script src="{{ asset('ui/frontend') }}/js/bootstrap.js"></script>
    <!-- custom js -->
    <script src="{{ asset('ui/frontend') }}/js/custom.js"></script>
    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href');
            swal({
                    title: "Are you sure to cancel this product",
                    text: "You will not be able to revert this!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willCancel) => {
                    if (willCancel) {
                        window.location.href = urlToRedirect;
                    }
                });
        }
    </script>
</body>

</html>
