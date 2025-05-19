<!DOCTYPE html>
<html>

<head>
    <title>New Rental Notification</title>
</head>

<body>
    <h2>A New Rental Has Been Created</h2>
    <p><strong>Car:</strong> {{ $rental->fleet->license_plate }}</p>
    <p><strong>Customer:</strong> {{ $rental->customer->name }}</p>
    <p><strong>Pickup Date:</strong> {{ $rental->pickup_date }} at {{ $rental->pickup_time }}</p>
    <p><strong>Return Date:</strong> {{ $rental->return_date }} at {{ $rental->return_time }}</p>
    <p><strong>Payment:</strong> MYR {{ $rental->payment->rental_amount }}</p>

    <p>Check the rental details in your system.</p>
</body>

</html>
