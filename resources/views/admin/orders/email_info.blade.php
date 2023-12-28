<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    @include('admin.css')
    <style>
        label {
            display: inline-block;
            width: 150px;
            font-size: 15px;
            font-weight: bold;
        }
    </style>
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
                <h1 class="text-center h1">Send Email To {{ $data->email }}</h1>
                <form action="{{ route('send_user_email',$data->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="greetig" style="padding-left: 32%;padding-top:30px">
                        <label for="greeting">Email Greeting :</label>
                        <input class="text-black rounded" type="text" name="greeting" id="greeting">
                    </div>
                    <div class="greetig" style="padding-left: 32%;padding-top:20px">
                        <label for="firstline">Email Firstline :</label>
                        <input class="text-black rounded" type="text" name="firstline" id="firstline">
                    </div>
                    <div class="greetig" style="padding-left: 32%;padding-top:20px">
                        <label for="email_body">Email Body :</label>
                        <input class="text-black rounded" type="text" name="body" id="email_body">
                    </div>
                    <div class="greetig" style="padding-left: 32%;padding-top:20px">
                        <label for="button_name">Email Button name :</label>
                        <input class="text-black rounded" type="text" name="button" id="button_name">
                    </div>
                    <div class="greetig" style="padding-left: 32%;padding-top:20px">
                        <label for="e_url">Email Url :</label>
                        <input class="text-black rounded" type="text" name="url" id="e_url">
                    </div>
                    <div class="greetig" style="padding-left: 32%;padding-top:20px">
                        <label for="lastline">Email LastLine :</label>
                        <input class="text-black rounded" type="text" name="lastline" id="lastline">
                    </div>
                    <div class="greetig" style="padding-left: 32%;padding-top:20px">
                        <input type="submit" class="btn btn-sm btn-primary" value="submit" id="submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    @include('admin.script')
    <!-- End custom js for this page -->
</body>

</html>
