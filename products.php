<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    include("connections.php");
    include("functions.php");

    $user_data = check_login($con);

    // The amounts of books to show on each page
    $num_books_on_each_page = 6;

    // The current page - in the URL, will appear as index.php?page=books&p=1, index.php?page=books&p=2, etc...
    $current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;

    // Select books ordered by the date added
    $stmt = $con->prepare('SELECT * FROM books ORDER BY id DESC LIMIT ?, ?');

    // Bind the parameters using bind_param
    $offset = ($current_page - 1) * $num_books_on_each_page;
    $limit = $num_books_on_each_page;
    $stmt->bind_param('ii', $offset, $limit);
    $stmt->execute();

    // Fetch the books from the database and return the result as an Array
    $books = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    // Get the total number of books
    $total_books = $con->query('SELECT * FROM books')->num_rows;

    

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

        <!-- Start Displaying the Products -->

        <h1 style="display:flex;justify-content:center;font-size:35px;">Products</h1><br>
        <p style="display:flex;justify-content:left;padding-left:163px;font-size:22px;"><?= $total_books ?> Books</p>
        <div style="height:1em;"></div>

        <div class="books" style="display:flex;flex-wrap:wrap;justify-content:center;">
            <?php // Check if the current page is the last page
                $is_last_page = ($current_page * $num_books_on_each_page) >= $total_books;
                if (!$is_last_page): ?>
                <div class="products-wrapper" style="display:flex;flex-wrap:wrap;justify-content:center;">
                    <?php foreach ($books as $book): ?>
                    <div class="product" style="display:flex;justify-content:center;width:30%;;margin-bottom:20px;">
                        <a href="index.php?page=book&id=<?=$book['id']?>" class="product" style="margin:2em;font-size:18px;color:#000000">
                            <img src="images/<?= $book['img'] ?>" width="200" height="300" alt="<?= $book['title'] ?>"><br>
                            <div class="details" style="max-width:200px;">
                                <span class="name"><?= $book['title'] ?></span><br>
                                <span class="price">
                                    &dollar;<?= $book['price'] ?>
                                    <?php if ($book['rrp'] > 0): ?>
                                        <span class="rrp" style="color:grey;text-decoration:line-through;">&dollar;<?=$book['rrp']?></span>
                                    <?php endif; ?>
                                </span>
                                <br>
                                <span><?= getStockStatus($book['quantity']) ?></span>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if ($is_last_page): ?>
            <div class="final-row" style="display:flex;justify-content:center;width:100%;">
                <?php foreach ($books as $book): ?>
                <div class="product" style="display:flex;justify-content:center;width:30%;;margin-bottom:20px;">
                    <a href="index.php?page=book&id=<?=$book['id']?>" class="product" style="margin:2em;font-size:18px;color:#000000">
                        <img src="images/<?= $book['img'] ?>" width="200" height="300" alt="<?= $book['title'] ?>"><br>
                        <div class="details" style="max-width:200px;">
                            <span class="name"><?= $book['title'] ?></span><br>
                            <span class="price">
                                &dollar;<?= $book['price'] ?>
                                <?php if ($book['rrp'] > 0): ?>
                                    <span class="rrp" style="color:grey;text-decoration:line-through;">&dollar;<?=$book['rrp']?></span>
                                <?php endif; ?>
                            </span>
                            <br>
                            <span><?= getStockStatus($book['quantity']) ?></span>
                        </div>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <div class="buttons">
                <?php if ($current_page > 1): ?>
                    <a href="products.php?page=book&p=<?= $current_page - 1 ?>" style="margin:2em;font-size:18px;color:#000000">Prev</a>
                <?php endif; ?>
                <?php if ($total_books > ($current_page * $num_books_on_each_page) - $num_books_on_each_page + count($books)): ?>
                    <a href="products.php?page=books&p=<?= $current_page + 1 ?>" style="margin:2em;font-size:18px;color:#000000">Next</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- End of Displaying Products -->

        <div style="height:2em;"></div>

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