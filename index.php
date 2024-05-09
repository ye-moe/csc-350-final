<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    $page = isset($_GET['page']) ? $_GET['page'] : '';

    if ($page == 'book') {
        if (isset($_GET['id'])) {
            include 'product.php';
            exit;
        }
    }

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

    // Get the 4 most recently added products
    $stmt = $con->prepare('SELECT * FROM books ORDER BY date_added DESC LIMIT 4');
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set
    $recently_added_books = $result->fetch_all(MYSQLI_ASSOC); // Fetch all rows as associative array

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
        <div style="display:flex;align-items:center;padding-left:162px;">
            <p style="font-size:40px;flex:1;">Welcome, <?php echo $user_data['first_name']; ?></p>
            <input type="text" placeholder="&#128269;  What are you looking for?" style="width:300px;height:30px;padding-left:10px;margin-right:160px;font-family:'Scope One';" autocomplete="off">
        </div>

        <p style="margin-top:10px;padding-left:162px;font-size:65px;">Where imagination meets<br> expression, one<br> bookshelf at a time.</p>

        <!-- <img class="center" style="width:1130px;height:630px;margin-left:160px;margin-bottom:-1em;background-image: linear-gradient(to right, rgba(255,0,0,0), rgba(255,0,0,1));" src="images/book-banner-2.webp" alt="modern house with artworks"> -->
        <!-- <div style="background-image:linear-gradient(to left,rgba(245,246,252,0.52),rgba(107,142,35,0.7)),url('images/book-banner-2.webp');width:1130px;height:630px;margin-left:160px;margin-bottom:-1em;background-size:cover;color:#FFFFFF;">something here</div> -->

        <div style="position:relative;background-image:linear-gradient(to left,rgba(245, 246, 252, 0.52),rgba(107, 142, 35, 0.7)),url('images/book-banner-2.webp');width:1130px;height:630px;margin-left:160px;margin-bottom:-1em;background-size:cover;color:#FFFFFF;">
            <div style="position:absolute;bottom:0;left:10px;max-width:30%;text-align:left;padding-bottom:2em;padding-left:1em;font-size:40px;">More than 200 books available...</div>
        </div>

        <p style="font-size:30px;margin-right:5em;text-align:right;">Discover books of all genres ></p>
        <center>
            <hr style="border:0;width:70em;height:1px;background-color:#8B8B83;margin:10;">
            <p style="font-size:40px;">Browse trending books</p>
        </center>

        <!-- Display the Products on the Index Page by Querying them from the Database -->

        <div class="books" style="display:flex;flex-wrap:wrap;justify-content:center;">
            <?php foreach ($recently_added_books as $book): ?>
                <a href="index.php?page=book&id=<?=$book['id']?>" class="product" style="margin:2em;font-size:18px;color:#000000">
                    <img src="images/<?=$book['img']?>" width="200" height="300" alt="<?=$book['title']?>">
                    <div class="details">
                        <span class="name"><?=$book['title']?></span><br>
                        <span class="price">
                            &dollar;<?=$book['price']?>
                            <?php if ($book['rrp'] > 0): ?>
                            <span class="rrp" style="color:grey;text-decoration:line-through;">&dollar;<?=$book['rrp']?></span>
                            <?php endif; ?>
                        </span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- End of Displaying Products -->

        <button class="button button4" style="margin-left:19em;" onclick="window.location.href='products.php'">Explore</button>
        <div style="height:3em;"></div>

        <!-- Advertisement Section -->

        <div class="advertisement" style="display:flex;">
            <div class="image-ad" style="flex:1;">
                <img src="images/book_ad.webp" style="width:550px;height:300px;margin-left:15em;" alt="advertisement">
            </div>
            <div class="text-ad" style="max-width:400px;margin-right:16em;flex:1;display:flex;flex-direction:column;justify-content:top;align-items:flex-start;color:#FFFFFF;">
                <div class="rectangle" style="width:100%;height:300px;background-color:#195905;padding-left:15px;padding-right:15px;">
                    <p style="font-size:40px;margin-top:30px;margin-bottom:1px;">Subscribe to Moe's Pen & Paper</p>
                    <p style="font-size:22px;margin-top:10px;">Join our community of book enthusiasts and immerse yourself in a realm where inspiration knows no bounds. 
                    Sign up now and embark on a journey of literary discovery.</p>
                </div>
            </div>  
        </div>

        <!-- End of Advertisement Section -->

        <div style="height:3em;"></div>

        <!-- Start of the Footer Section -->

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
                <div class="footer-right" style="max-width:600px;flex:1;display:flex;flex-direction:column;justify-content:top;align-items:center;">
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

        <!-- End of the Footer Section -->

        <!-- End of Main Content -->

    </body>
</html>