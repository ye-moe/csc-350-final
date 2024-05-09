<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

    // Check if the id parameter is specified in the URL
    if (isset($_GET['id'])) {
        // Prepare statement and execute, prevents SQL injection
        $stmt = $con->prepare('SELECT * FROM books WHERE id = ?');
        $stmt->bind_param('i', $_GET['id']);
        $stmt->execute();

        // Fetch the product from the database and return the result as an Array
        $book = $stmt->get_result()->fetch_assoc();

        // Check if the product exists (array is not empty)
        if (!$book) {
            // Simple error to display if the id for the product doesn't exist (array is empty)
            exit('Book does not exist!');
        }
    }

    if (isset($_POST['quantity']) && isset($_POST['book_id'])) {
        // Handle "Add to Cart" form submission
        include 'cart.php';
        
        // Redirect to the cart page after adding the product
        header('Location: cart.php');
        exit;
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

        <div style="height:7em;"></div>

        <!-- Start Displaying One Product -->

        <div class="book" style="display: flex; justify-content: center;">
            <div style="display: flex; align-items: top; max-width: 900px;">
                <img src="images/<?=$book['img']?>" style="margin-right: 5em;" width="400" height="600" alt="<?=$book['title']?>">
                <div style="display: flex; flex-direction: column; justify-content: top;">
                    <p class="name" style="font-size: 35px;"><?=$book['title']?></p>

                    <div class="description">
                        <?=$book['description']?>
                    </div>
            
                    <div style="display: flex; align-items: center;">
                        <span class="price" style="margin-right: 1em;">
                            &dollar;<?=$book['price']?>
                            <?php if ($book['rrp'] > 0): ?>
                                <span class="rrp" style="color: grey; text-decoration: line-through;">&dollar;<?=$book['rrp']?></span>
                            <?php endif; ?>
                        </span>
                        <br><br><br>
                        <span style="margin-right: 1em;"><?= getStockStatus($book['quantity']) ?></span>
                        <form action="cart.php?page=cart" method="post">
                            <input type="number" name="quantity" value="1" style="margin-right: 1em;" min="1" max="<?=$book['quantity']?>" placeholder="Quantity" required>
                            <input type="hidden" name="book_id" value="<?=$book['id']?>">
                            <input type="submit" value="Add To Cart">
                        </form>
                    </div>
                </div>
            </div>
        </div>
                        
        <!-- End Displaying One Product -->

        <div style="height:7em;"></div>

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