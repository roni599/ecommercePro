<section class="product_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2 class="mb-4">
                Our <span>products</span>
            </h2>
            <div class="search">
                @csrf
                <form action="{{ route('search_product') }}" method="GET">
                    <input class="rounded mb-2 text-center" style="width: 500px" type="text" name="search"
                        id="search" placeholder="search your desire product">
                    <input type="submit" value="Search" class="btn btn-sm btn-primary rounded">
                </form>
            </div>
        </div>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="box">
                        <div class="option_container">
                            <div class="options">
                                <a href="{{ route('product_details', $product->id) }}" class="option1">
                                    Product Details
                                </a>
                                <form action="{{ route('add_cart', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="number" class="btn btn-sm rounded-pill mb-1" name="quentity"
                                        value="1" min="1">
                                    <input type="submit" class="btn1 btn btn-sm rounded-pill" value="Add to cart">
                                </form>
                                {{-- <a href="" class="option2">
                                    add to cart
                                </a> --}}
                            </div>
                        </div>
                        <div class="img-box">
                            <img src="{{ asset('uploads') }}/{{ $product->product_image }}" alt="">
                        </div>
                        <div class="detail-box">
                            <h5>
                                {{ $product->product_title }}
                            </h5>
                            @if ($product->product_discount != null)
                                <h6 style="color: red">
                                    Discount Price
                                    <br>
                                    ${{ $product->product_discount }}
                                </h6>
                                <h6 style="text-decoration: line-through;color:blue">
                                    Price
                                    <br>
                                    ${{ $product->product_price }}
                                </h6>
                            @else
                                <h6 style="color: red">
                                    No discount available
                                </h6>
                                <h6 style="color: blue">
                                    price
                                    <br>
                                    ${{ $product->product_price }}
                                </h6>
                            @endif

                        </div>
                    </div>
                </div>
            @empty
                <h1 class="text-center m-auto h1 text-danger mt-5">No Data Found</h1>
            @endforelse
            <span class="p-4">
                {!! $products->withQueryString()->links('pagination::bootstrap-5') !!}
            </span>
        </div>

</section>
