<?php

@include 'config.php';

if (isset($_POST['order_btn'])) {

    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $method = $_POST['method'];
    $flat = $_POST['flat'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $country = $_POST['country'];
    $pin_code = $_POST['pin_code'];

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart`");
    $price_total = 0;
    $product_name = [];

    if (mysqli_num_rows($cart_query) > 0) {
        while ($product_item = mysqli_fetch_assoc($cart_query)) {
            $product_name[] = $product_item['name'] . ' (' . $product_item['quantity'] . ')';
            // Menghitung total harga tanpa menggunakan number_format
            $product_price = $product_item['price'] * $product_item['quantity'];
            $price_total += $product_price;
        }
    }

    $total_product = implode(', ', $product_name);
    $detail_query = mysqli_query($conn, "INSERT INTO `orders` (name, number, email, method, flat, street, city, state, country, pin_code, total_products, total_price) VALUES ('$name','$number','$email','$method','$flat','$street','$city','$state','$country','$pin_code','$total_product','$price_total')") or die('Query failed');

    if ($cart_query && $detail_query) {
        echo "
        <div class='order-message-container'>
        <div class='message-container'>
            <h3>Thank you for shopping!</h3>
            <div class='order-detail'>
                <span>" . $total_product . "</span>
                <span class='total'>Total: $" . number_format($price_total, 2) . "</span>
            </div>
            <div class='customer-details'>
                <p>Your name: <span>" . $name . "</span></p>
                <p>Your number: <span>" . $number . "</span></p>
                <p>Your email: <span>" . $email . "</span></p>
                <p>Your address: <span>" . $flat . ", " . $street . ", " . $city . ", " . $state . ", " . $country . " - " . $pin_code . "</span></p>
                <p>Your payment mode: <span>" . $method . "</span></p>
                <p>(*Pay when product arrives*)</p>
            </div>
            <a href='products.php' class='btn'>Continue Shopping</a>
        </div>
        </div>
        ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS File Link -->
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'header.php'; ?>

<div class="container">

<section class="checkout-form">

    <h1 class="heading">Complete Your Order</h1>

    <form action="" method="post">

    <div class="display-order">
        <?php
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart`");
        $total = 0;
        $grand_total = 0;
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
                $total += $total_price;
        ?>
        <span><?= $fetch_cart['name']; ?> (<?= $fetch_cart['quantity']; ?>)</span>
        <?php
            }
            $grand_total = $total;
        } else {
            echo "<div class='display-order'><span>Your cart is empty!</span></div>";
        }
        ?>
        <span class="grand-total">Grand Total: $<?= number_format($grand_total, 2); ?></span>
    </div>

        <div class="flex">
            <div class="inputBox">
                <span>Your Name</span>
                <input type="text" placeholder="Enter your name" name="name" required>
            </div>
            <div class="inputBox">
                <span>Your Number</span>
                <input type="number" placeholder="Enter your number" name="number" required>
            </div>
            <div class="inputBox">
                <span>Your Email</span>
                <input type="email" placeholder="Enter your email" name="email" required>
            </div>
            <div class="inputBox">
                <span>Payment Method</span>
                <select name="method">
                    <option value="cash on delivery" selected>Cash on Delivery</option>
                    <option value="credit card">Credit Card</option>
                    <option value="paypal">PayPal</option>
                </select>
            </div>
            <div class="inputBox">
                <span>Address Line 1</span>
                <input type="text" placeholder="E.g. Flat No." name="flat" required>
            </div>
            <div class="inputBox">
                <span>Address Line 2</span>
                <input type="text" placeholder="E.g. Street Name" name="street" required>
            </div>
            <div class="inputBox">
                <span>City</span>
                <input type="text" placeholder="E.g. Mumbai" name="city" required>
            </div>
            <div class="inputBox">
                <span>State</span>
                <input type="text" placeholder="E.g. Maharashtra" name="state" required>
            </div>
            <div class="inputBox">
                <span>Country</span>
                <input type="text" placeholder="E.g. India" name="country" required>
            </div>
            <div class="inputBox">
                <span>Pin Code</span>
                <input type="text" placeholder="E.g. 123456" name="pin_code" required>
            </div>
        </div>
        <input type="submit" value="Order Now" name="order_btn" class="btn">
    </form>

</section>

</div>

<!-- Custom JS File Link -->
<script src="js/script.js"></script>

</body>
</html>
