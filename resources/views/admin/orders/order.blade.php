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
                <div class="text-center mt-1 mb-4">
                    <h1 class="fs-2 fw-bold h2">Order Details</h1>
                </div>
                <div class="search-bar" style="padding-left: 39%;">
                    <form action="{{ route('search') }}" method="GET">
                        <input class="rounded" type="text" style="color: black;" name="search" id="search">
                        <input type="submit" value="search" class="btn btn-sm btn-primary">
                    </form>
                </div>
                <table class="table table-bordered mt-4">
                    <thead>
                        <tr style="padding: 7px">
                            <th scope="col">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>phone</th>
                            <th>Address</th>
                            <th>P_Title</th>
                            <th>Quentity</th>
                            <th>Pirce</th>
                            <th>P_Status</th>
                            <th>D_Status</th>
                            <th>Image</th>
                            <th>Delivery</th>
                            <th>PDF</th>
                            <th>Send Email</th>
                            </th>
                        </tr>
                    </thead>
                    @php
                        $sno = 1;
                    @endphp
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <th scope="row">{{ $sno++ }}</th>
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->phone }}</td>
                                <td>{{ $order->address }}</td>
                                <td>{{ $order->product_title }}</td>
                                <td>{{ $order->quentity }}</td>
                                <td>{{ $order->price }}</td>
                                <td>{{ $order->payment_status }}</td>
                                <td>{{ $order->delivery_status }}</td>
                                <td>
                                    <img src="{{ asset('uploads') }}/{{ $order->image }}" width="50"
                                        height="50" alt="">
                                </td>
                                @if ($order->delivery_status == 'processing')
                                    <td>
                                        <a onclick="return confirm('Are you sure this product is deleverd?')"
                                            href="{{ route('delevered', $order->id) }}"
                                            class="btn btn-sm btn-primary">Delevery</a>
                                    </td>
                                @else
                                    <td class="text-success">Delivered</td>
                                @endif
                                <td>
                                    <a href="{{ route('print_pdf', $order->id) }}" class="btn btn-sm btn-primary">Print
                                        Pdf</a>
                                </td>
                                <td>
                                    <a href="{{ route('send_email', $order->id) }}"
                                        class="btn btn-sm btn-primary">Email</a>
                                </td>
                            </tr>
                        @empty
                            <tr class="">
                                <td colspan="13" class="text-center text-white">No data Found</td>
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
