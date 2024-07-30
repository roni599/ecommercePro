<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="{{ asset('ui/frontend') }}/images/favicon.png" type="">
    <title>Famms - Fashion HTML Template</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="{{ asset('ui/frontend') }}/css/font-awesome.min.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="{{ asset('ui/frontend') }}/css/style.css" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('ui/frontend') }}/css/responsive.css" rel="stylesheet" />
</head>

<body>
    @include('home.header')
    <div class="container mt-3 ">
        <h4 class="text-center mt-1 mb-3 text-success fw-bold">Payment Using Your Card - Amount at ${{ $total }}</h4>
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h4 class="panel-title">Payment Details</h4>
                    </div>
                    <div class="card-body">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <p>{{ Session::get('success') }}</p>
                            </div>
                        @endif
                        <form role="form" action="{{ route('stripe.post', $total) }}" method="post"
                            class="require-validation" data-cc-on-file="false"
                            data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" id="payment-form">
                            @csrf
                            <div class='form-row mb-2'>
                                <div class='col-xs-12 form-group required'>

                                    <label class='form-label fw-bold'>Name on Card</label>
                                    <input class='form-control rounded' size='4' type='text'>
                                </div>
                            </div>
                            <div class='form-row mb-3'>
                                <div class='col-xs-12 form-group  required'>
                                    <label class='form-label fw-bold'>Card Number</label>
                                    <input autocomplete='off' class='form-control card-number rounded' size='20'
                                        type='text'>
                                </div>
                            </div>
                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label fw-bold'>CVC</label> <input autocomplete='off'
                                        class='form-control card-cvc rounded' placeholder='ex. 311' size='4'
                                        type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label fw-bold'>Expiration Month</label> <input
                                        class='form-control card-expiry-month rounded' placeholder='MM' size='2'
                                        type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label fw-bold'>Expiration Year</label> <input
                                        class='form-control card-expiry-year rounded' placeholder='YYYY' size='4'
                                        type='text'>
                                </div>
                            </div>
                            <div class='form-row row mb-3'>
                                <div class='col-md-12 error form-group d-none'>
                                    <div class='alert-danger alert'>Please correct the errors and try
                                        again.</div>
                                </div>
                            </div>
                            <div class='mb-1 '>
                                <button
                                    class='btn rounded text-black w-100 btn-lg btn-primary bg-primary btn-block text-white'
                                    type='submit'>Pay Now ${{ $total }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer start -->
    @include('home.footer')
    <!-- footer end -->
    <div class="cpy_">
        <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
        </p>
    </div>
</body>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">
    $(function() {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');
            $('.has-error').removeClass('has-error');
            $inputs.each(function(i, el) {
                var $input = $(el);
                if ($input.val() === '') {
                    $input.parent().addClass('has-error');
                    $errorMessage.removeClass('d-none');
                    e.preventDefault();
                }
            });
            if (!$form.data('cc-on-file')) {
                e.preventDefault();
                Stripe.setPublishableKey(
                    'pk_test_51NyEcgKs3NOZcWUGJxLt1LEMXqxcIamKRO97lk7H9PC67AOSzXGRiHtyHUBMVZoTFjGnMFZQcGsncCDk40wxbWJM00UyM1FiZW'
                );
                Stripe.createToken({
                    number: $('.card-number').val(),
                    cvc: $('.card-cvc').val(),
                    exp_month: $('.card-expiry-month').val(),
                    exp_year: $('.card-expiry-year').val()
                }, stripeResponseHandler);
            }
        });

        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.error')
                    .removeClass('d-none')
                    .find('.alert')
                    .text(response.error.message);
            } else {
                var token = response['id'];
                $form.find('input[type=text]').empty();
                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
                $form.get(0).submit();
            }
        }
    });
</script>
<!-- jQery -->
<script src="{{ asset('ui/frontend') }}/js/jquery-3.4.1.min.js"></script>
<!-- popper js -->
<script src="{{ asset('ui/frontend') }}/js/popper.min.js"></script>
<!-- bootstrap js -->
<script src="{{ asset('ui/frontend') }}/js/bootstrap.js"></script>
<!-- custom js -->
<script src="{{ asset('ui/frontend') }}/js/custom.js"></script>

</html>
