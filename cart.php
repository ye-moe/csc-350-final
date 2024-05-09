<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include("connections.php");
include("functions.php");

$user_data = check_login($con);

// Clear cart when a different user logs in
if (isset($user_data['user_id']) && isset($_SESSION['previous_user_id']) && $user_data['user_id'] !== $_SESSION['previous_user_id']) {
    unset($_SESSION['cart']);
}

// Store the current user's ID for future comparisons
$_SESSION['previous_user_id'] = $user_data['user_id'];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

    // Check if the user clicked the logout button
    if (isset($_GET['action']) && $_GET['action'] === 'logout') {
        // Clear cart on logout
        session_unset();
        session_destroy();
        header('Location: login.php'); // Redirect to login page after logout
        exit;
    }

    // Clear cart on login
    if(isset($_SESSION['user_id'])) {
        $user_data = check_login($con);
        if(!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }
    }

    // If the user clicked the add to cart button on the product page we can check for the form data
    if (isset($_POST['book_id'], $_POST['quantity']) && is_numeric($_POST['book_id']) && is_numeric($_POST['quantity'])) {
        // Set the post variables so we easily identify them, also make sure they are integer
        $book_id = (int)$_POST['book_id'];
        $quantity = (int)$_POST['quantity'];

        // Prepare the SQL statement, we basically are checking if the product exists in our database
        $stmt = $con->prepare('SELECT * FROM books WHERE id = ?');
        $stmt->bind_param('i', $book_id);
        $stmt->execute();

        // Get the result of the query
        $result = $stmt->get_result();

        // Fetch the product from the database and return the result as an Array
        $book = $result->fetch_assoc();

        // Check if the product exists (array is not empty)
        if ($book && $quantity > 0) {
            // Product exists in database, now we can create/update the session variable for the cart
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                if (array_key_exists($book_id, $_SESSION['cart'])) {
                    // Product exists in cart so just update the quanity
                    $_SESSION['cart'][$book_id] += $quantity;
                } 
                else {
                    // Product is not in cart so add it
                    $_SESSION['cart'][$book_id] = $quantity;
                }
            }       
            else {
                // There are no products in cart, this will add the first product to cart
                $_SESSION['cart'] = array($book_id => $quantity);
            }
        }
        // Prevent form resubmission...
        header('location: cart.php?page=cart');
        exit;
    }

    // Remove product from cart, check for the URL param "remove", this is the product id, make sure it's a number and check if it's in the cart
    if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
        // Remove the product from the shopping cart
        unset($_SESSION['cart'][$_GET['remove']]);
    }

    // Update product quantities in cart if the user clicks the "Update" button on the shopping cart page
    if (isset($_POST['update']) && isset($_SESSION['cart'])) {
        // Loop through the post data so we can update the quantities for every product in cart
        foreach ($_POST as $k => $v) {
            if (strpos($k, 'quantity') !== false && is_numeric($v)) {
                $id = str_replace('quantity-', '', $k);
                $quantity = (int)$v;
                // Always do checks and validation
                if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                    // Update new quantity
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }
        // Prevent form resubmission...
        header('Location: cart.php?page=cart');
        exit;
    }

    // Send the user to the place order page if they click the Place Order button, also the cart should not be empty
if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Clear the cart before sending to the order page
    unset($_SESSION['cart']);
    header('Location: order.php'); // Change this line to redirect to order.php
    exit;
}

    // Check the session variable for products in cart
    $books_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $books = array();
    $subtotal = 0.00;

    // If there are products in cart
    if ($books_in_cart) {
        // There are products in the cart so we need to select those products from the database
        // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
        $array_to_question_marks = implode(',', array_fill(0, count($books_in_cart), '?'));
        $stmt = $con->prepare('SELECT * FROM books WHERE id IN (' . $array_to_question_marks . ')');

        // We only need the array keys, not the values, the keys are the id's of the products
        $stmt->bind_param(str_repeat('i', count($books_in_cart)), ...array_keys($books_in_cart)); // 'i' for integer

        $stmt->execute();

        // Get the result of the query
        $result = $stmt->get_result();

        // Fetch the products from the database and return the result as an Array
        $books = $result->fetch_all(MYSQLI_ASSOC);

        // Calculate the subtotal
        foreach ($books as $book) {
            $subtotal += (float)$book['price'] * (int)$books_in_cart[$book['id']];
        }
    }

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
                        <button class="button button3" onclick="window.location.href='cart.php?action=logout'">Log Out</button>
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

        <!-- Display User Shopping Cart Information -->
        <h1 style="display:flex;justify-content:center;font-size:35px;">Shopping Cart</h1>
        <div style="height:1em;"></div>


        <div class="cart content-wrapper" style="display:flex;flex-wrap:wrap;justify-content:center;">
            <form action="cart.php?page=cart" method="post">
                <table>
                    <thead>
                        <tr>
                            <td></td>
                            <td>Product</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Total</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($books)): ?>
                            <tr>
                                <td colspan="5" style="text-align:center;">You have no books added in your Shopping Cart</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($books as $book): ?>
                                <tr>
                                    <td class="img">
                                        <a href="cart.php?page=product&id=<?=$book['id']?>">
                                            <img src="images/<?=$book['img']?>" width="50" height="70" alt="<?=$book['title']?>">
                                        </a>
                                    </td>
                                    <td>
                                        <a style="color:#000000;" href="product.php?id=<?=$book['id']?>"><?=$book['title']?></a>
                                        <br>
                                        <a style="color:#000000;" href="cart.php?page=cart&remove=<?=$book['id']?>" class="remove">Remove</a>
                                    </td>
                                    <td class="price">&dollar;<?=$book['price']?></td>
                                    <td class="quantity">
                                        <input type="number" name="quantity-<?=$book['id']?>" value="<?=$books_in_cart[$book['id']]?>" min="1" max="<?=$book['quantity']?>" placeholder="Quantity" required>
                                    </td>
                                    <td class="price">&dollar;<?=$book['price'] * $books_in_cart[$book['id']]?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="subtotal">
                    <span class="text">Subtotal</span>
                    <span class="price">&dollar;<?=$subtotal?></span>
                </div>
                <div class="buttons">
                    <input type="submit" value="Update" name="update">
                    <input type="submit" value="Place Order" name="placeorder">
                </div>
            </form>
        </div>

        <!-- End of Display User Shopping Cart Information -->

        <div style="height:3em;"></div>

        <!-- Start of Footer Section -->

        <footer style="color:#FFFFFF;">
            <div class="footer-content" style="display:flex;background:#8B8B83;max-width:100%;padding-left:13em;">
                <div class="footer-left" style="flex:1;max-width:450px;">
                    <div class="footer-logo" style="font-size:40px;padding-top:50px;">Moe's Pen & Paper</div>
                    <p style="font-size:20px;">Discover literature that speaks volumes, right at your fingertips</p>
                    <div style="height:5em;"></div>
                    <p style="font-size:15px;">Terms of Service</p>
                    <p style="font-size:15px;">Privacy Policy</p>
                    <p style="font-size:15px;">&copy; 2024 Ye Moe CSC 350 Software Development. All Rights Reserved.</p>
                    <div style="height:1em;"></div>
                </div>
                <div class="footer-right" style="flex:1;max-width:600px;flex:1;display:flex;flex-direction:column;justify-content:top;align-items:center;">
                    <div class="social-media" style="padding-top:110px;margin-left:130px;">
                        <p style="font-size:20px;text-decoration:underline;">Contact us</p>
                        <div style="display:flex;">
                            <div style="flex:1;display:flex;align-items:center;">
                                <img src="images/email.png" style="width:30px;height:30px;margin-right:10px;" alt="email">
                                <p style="font-size:20px;margin:0;">moespenandpaper@gmail.com</p>
                            </div>
                        </div>
                        <p style="font-size:20px;text-decoration:underline;">Social media</p>
                        <div style="display:flex;">
                            <img src="images/facebook.webp" style="width:40px;height:40px;margin-right:20px;" alt="facebook">
                            <img src="images/instagram.webp" style="width:40px;height:40px;margin-right:20px;" alt="instagram">
                            <img src="images/twitter.png" style="width:40px;height:40px;margin-right:20px;" alt="twitter">
                            <img src="images/pinterest.webp" style="width:40px;height:40px;margin-right:20px;" alt="pinterest">
                        </div>
                </div>
        </footer>

        <!-- End of Footer Section -->

        <!-- End of Main Content -->

    </body>
</html>
