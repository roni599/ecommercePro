<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Order Delivery Details</title>
</head>

<body>
    <h1 class="text-center">Order Delivery Details</h1>
    <div class="main d-flex justify-content-between align-items-center container border m-auto w-50 rounded">
        <div class="customer_details mt-5">
            <p>Order ID: {{ $orders->id }}</p>
            <p>Customer: {{ $orders->name }}</p>
            <p>Address: {{ $orders->address }}</p>
            <p>Phone: {{ $orders->phone }}</p>
            <br><br>
        </div>
            <div class="image">
                <img height="150" width="150" src="uploads/{{ $orders->image }}">
            </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
