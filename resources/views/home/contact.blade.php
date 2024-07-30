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
    <title>ecommercePro_Contact_page</title>
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
        <!-- product section -->
        <div class="container shadow-sm border border-5 rounded p-4 mt-3">
            <h1>Contact Form</h1>
            <form id="contact_form" name="contact_form" method="post">
                <div class="mb-2 row">
                    <div class="col">
                        <label>First Name</label>
                        <input type="text" required maxlength="50" class="form-control" id="first_name"
                            name="first_name">
                    </div>
                    <div class="col">
                        <label>Last Name</label>
                        <input type="text" required maxlength="50" class="form-control" id="last_name"
                            name="last_name">
                    </div>
                </div>
                <div class="mb-2 row">
                    <div class="col">
                        <label for="email_addr">Email address</label>
                        <input type="email" required maxlength="50" class="form-control" id="email_addr"
                            name="email" placeholder="name@example.com">
                    </div>
                    <div class="col">
                        <label for="phone_input">Phone</label>
                        <input type="tel" required maxlength="50" class="form-control" id="phone_input"
                            name="Phone" placeholder="Phone">
                    </div>
                </div>
                <div class="mb-4">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5"></textarea>
                </div>
                <button type="submit" class="btn btn-primary px-4 w-100 btn-lg">Post</button>
            </form>
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
</body>
<script>
    document.addEventListener("DOMContentLoaded", function(event) {
        var scrollpos = localStorage.getItem('scrollpos');
        if (scrollpos) window.scrollTo(0, scrollpos);
    });

    window.onbeforeunload = function(e) {
        localStorage.setItem('scrollpos', window.scrollY);
    };
</script>

</html>
