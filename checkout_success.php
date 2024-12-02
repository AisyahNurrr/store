<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Checkout Success</title>
   <link rel="stylesheet" href="css/styles.css">
</head>
<body>
   <div class="container">
      <h1 class="heading">Checkout Success</h1>
      <p>Thank you for your purchase! Your order has been successfully placed.</p>
      <a href="index.php" class="btn">Back to Home</a>
   </div>
</body>
</html>
