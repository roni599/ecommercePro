<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Books</title>
    <link rel="stylesheet" href="{{ asset('ui/frontend') }}/css/show.css">
</head>

<body>
    <div class="box">
        <div class="main-box border p-5 mt-4  container shadow">
            <div class="box1 mb-2">
                <div class="pic">
                    <img src="{{ asset('uploads') }}/{{ $product->product_image }}" width="250"
                        class="rounded shadow mt-3" alt="">
                </div>
                <div class="known">
                    <div class="details mt-0">
                        <h2 class="mb-1 h2 fw-bold">Product Title : {{ $product->product_title }}</h2>
                        <p class="mb-1"><p  style="color:blue">Product Description : {{ $product->prouct_description }}</p>
                        </p>
                        <p class="mb-1 d-inline" style="color:blue">Category : <p class="d-inline" style="color:blue">{{ $product->product_category }}</p></p>
                        @if ($product->product_discount != null)
                            <p class="mb-1 d-inline" style="text-decoration: line-through; color:blue">Price : <p
                               class=" d-inline" style="color:blue">${{ $product->product_price }}</p></p>
                            <p class="mb-1 d-inline" style=" color:red">Discount Price : <p
                                   class="d-inline"style="color:blue" >${{ $product->product_discount }}</p></p>
                        @else
                            <p class="mb-1 d-inline" style="color:blue">Price : <p
                                    class="d-inline" style="color:blue">${{ $product->product_price }}</p></p>
                            <p style="color: red">No Discount Available</p>
                        @endif

                    </div>
                    {{-- <div class="button mt-4">
                        <button class="btn btn1 w-50">Read More</button>
                        <button class="btn btn2">Add To Card</button>
                    </div> --}}
                    <form action="{{ route('add_cart', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="button2 mt-4">
                            <input type="number" class=" rounded-pill w-75 px-5 text-black btn-sm mb-1" name="quentity"
                                value="1" min="1">
                            <input type="submit" class="btn-sm  rounded-pill" value="Add to cart">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="comment container">
            <h2 class="mt-3 mb-2 h2 fw-bold">Comment</h2>
            <form action="{{ route('add_comment') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <textarea class="form-control w-50 mb-3" id="comment" name="comment" rows="1"></textarea>
                <input type="submit" class="btn btn-sm btn-primary bg-primary ml-0" value="comment">
            </form>
        </div>
        <div class="all-comment container">
            <h4 class="mt-3 mb-2 h4 fw-bold">All Comments</h4>
            @foreach ($comment as $comment)
                <div class="reply mb-1">
                    <b>{{ $comment->name }}</b>
                    <p class="text-dark">{{ $comment->comment }}</p>
                    <a href='javascript::void(0);' onclick="reply(this)" comment_data="{{ $comment->id }}"
                        class="text-primary">Reply</a>
                    {{-- </div> --}}
                    @foreach ($reply as $replies)
                        @if ($replies->id == $comment->id)
                            <div class="reply mb-0 pl-4">
                                <b>{{ $replies->name }}</b>
                                <p class="text-dark">{{ $replies->reply }}</p>
                                <a href='javascript::void(0);' onclick="reply(this)" comment_data="{{ $comment->id }}"
                                    class="text-primary">Reply</a>
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
            <div class="replyDiv" style="display: none">
                <form action="{{ route('add_reply') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" id="commentId" name="commentId" hidden=''>
                    <textarea class="form-control w-50 mb-3" id="reply" name="reply" rows="1"></textarea>
                    <button type="submit" class="btn btn-sm btn-primary bg-primary ml-0">Reply</button>
                    <a href="javascript::void(0);" class="btn btn-sm btn-primary bg-primary ml-0"
                        onclick="reply_close(this)">Close</a>
                </form>
            </div>
        </div>
    </div>
    <script>
        function reply(caller) {
            document.getElementById('commentId').value = $(caller).attr('comment_data');
            $('.replyDiv').insertAfter($(caller));
            $('.replyDiv').show();
        }

        function reply_close(caller) {
            $('.replyDiv').hide();
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>
</body>

</html>
