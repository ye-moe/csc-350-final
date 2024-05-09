<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CSC 350 Final Project</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <!-- Start of Navigation Bar -->
            <nav class="navbar">
                <div class="navdiv">
                    <div class="logo" style="font-size:40px;padding-left:143px;margin-top:33px;">Moe's Pen & Paper</div>
                    <ul style="padding-right:9em;padding-top:2em;">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="products.php">Explore</a></li>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="about.php">About</a></li>
                        <button class="button button3" onclick="window.location.href='logoff.php'">Log Out</button>
                    </ul>
                </div>
                <div style="height:1.5em;"></div>
            </nav>
        <!-- End of Navigation Bar -->

        <!-- Horizontal Line Separator -->
        <hr style="border:0;height:1px;background-color:#8B8B83;margin:0;">
        <!-- Horizontal Line Separator -->

        <!-- Start of Main Content -->
        <div style="height:1.5em;"></div>

        <!-- Inform the User about their Successful Order -->

        <div style="display:flex;flex-direction: column;align-items:center;">
            <h1>Your Order Has Been Placed</h1>
            <p>Thank you for ordering with us! We'll contact you by email with your order details.</p>
        </div>

        <div style="height:21em;"></div>

        <!-- Start of Footer Section -->

        <footer style="color:#FFFFFF;">
            <hr style="border:0;height:1px;background-color:#8B8B83;margin:0;">
            <div style="height:1em;"></div>
            <p style="font-size:15px;color:#000000;padding-left:10em;">&copy; 2024 Ye Moe CSC 350 Software Development. All Rights Reserved.</p>
        </footer>

        <!-- End of Footer Section -->

        <!-- End of Main Content -->
    </body>
</html>
