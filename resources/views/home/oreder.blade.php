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
    <link rel="shortcut icon" href="{{ asset('ui/frontend') }}/images/favicon.png" type="">
    <title>ecommercePro_Order_page</title>
    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('ui/frontend') }}/css/bootstrap.css" />
    <!-- font awesome style -->
    <link href="{{ asset('ui/frontend') }}/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('ui/frontend') }}/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('ui/frontend') }}/css/responsive.css" rel="stylesheet" />

</head>

<body>
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
        @foreach ($orders as $order)
            @php
                $count++;
            @endphp
        @endforeach
        @if ($count > 0)
            <table class="table table-bordered w-75 mx-auto mt-5">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product_Title</th>
                        <th>Product_Quentity</th>
                        <th>Price</th>
                        <th>Payment_status</th>
                        <th>Delivery_status</th>
                        <th>image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                @php
                    $sno = 1;
                @endphp
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <th scope="row">{{ $sno++ }}</th>
                            <td>{{ $order->product_title }}</td>
                            <td>{{ $order->quentity }}</td>
                            <td>{{ $order->price }}</td>
                            <td>{{ $order->payment_status }}</td>
                            <td>{{ $order->delivery_status }}</td>
                            <td>
                                <img src="{{ asset('uploads') }}/{{ $order->image }}" width="50" height="50"
                                    alt="">
                            </td>
                            <td>
                                @if ($order->delivery_status=='processing')
                                <a onclick="return confirm('Are you sure watn to cancel your Order?')" href="{{ route('cancel_order',$order->id) }}"
                                    class="btn btn-sm btn-danger">cancel Order</a>
                                @else
                                Not alwood
                                @endif
                                
                            </td>
                        </tr>
                    @empty
                        <tr class="">
                            <td colspan="6" class="text-center text-white">No data Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @else
            <div class="button text-center m-auto">
                <h1 class="h1 fw-bold text-danger">You Have No Product Iteam In Card Menu</h1>
            </div>
        @endif
    </div>

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
</body>

</html>
