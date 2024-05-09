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

        <!-- Display the About Us Information -->

        <div>
            <center>
                <p style="max-width:40%;font-size:50px;">We're changing the way people think about reading</p>
                <p style="max-width:40%;font-size:20px;">
                    Welcome to Moe's Pen & Paper! We started this journey with a love for books and a passion for sharing stories. At Moe's
                    Pen & Paper, our mission is to provide book lovers with a haven where they can explore, discover and connect through the magic of literature...
                </p>
                <p style="max-width:40%;font-size:20px;">
                    As avid readers ourselves, we wanted to create a space where fellow book enthusiasts could find their next favorite read. 
                    We believe that books have the power to change lives, and we're here to help you find the perfect book that speaks to you...
                </p>
                <div style="height:3em;"></div>

                <p style="max-width:40%;font-size:40px;">Our Values</p>
                <div style="display:flex;max-width:45%;text-align:left;">
                    <img src="images/group.png" style="width:50px;height:50px;margin-right:30px;margin-top:10px;" alt="group">
                    <p style="font-size:20px;margin:0;justify-content:left;">
                        Create Community<br>
                        We are committed to providing our customers with a curated selection of books that reflect our dedication to quality and excellence
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:45%;text-align:left;">
                    <img src="images/axis.png" style="width:50px;height:50px;margin-right:30px;margin-top:10px;" alt="axis">
                    <p style="font-size:20px;margin:0;">
                        Embrace Diversity<br>
                        We seek the missing perspectives and leverage the diversity of our team to create a welcoming and inclusive environment for all
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:45%;text-align:left;">
                    <img src="images/target.png" style="width:50px;height:50px;margin-right:30px;margin-top:10px;" alt="target">
                    <p style="font-size:20px;margin:0;">
                        Drive Impact<br>
                        We focus on results that bring our mission within reach, for everyone
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:45%;text-align:left;">
                    <img src="images/map.png" style="width:50px;height:50px;margin-right:30px;margin-top:5px;" alt="map">
                    <p style="font-size:20px;margin:0;">
                        Bring Others Along<br>
                        We are committed to expanding our reach and connecting readers with stories from around the world
                    </p>
                </div>
                <div style="height:3em;"></div>

                <p style="max-width:40%;font-size:40px;">Meet the Team</p>
                <div style="display:flex;max-width:50%;text-align:left;">
                    <img src="images/gojo.jpeg" style="width:200px;height:200px;margin-right:30px;margin-top:5px;" alt="map">
                    <p style="font-size:20px;margin-top:50px;">
                        Mr. President Ye Moe (Me)<br>
                        The visionary behind our literary haven, I lead our mission to connect readers with stories that inspire and educate.<br><br>
                        "Throughout Heaven and Earth, I alone am the Honored One..." - Ye Moe
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:50%;text-align:left;">
                    <img src="images/chaewon.jpeg" style="width:200px;height:200px;margin-right:30px;margin-top:5px;" alt="map">
                    <p style="font-size:20px;margin-top:50px;">
                        Vice President (Fake)<br>
                        The right hand to our President, I am dedicated to ensuring our bookstore delivers exceptional service and a diverse selection of books to satisfy every reader's appetite.
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:50%;text-align:left;">
                    <img src="images/makima.jpeg" style="width:200px;height:200px;margin-right:30px;margin-top:5px;" alt="map">
                    <p style="font-size:20px;margin-top:50px;">
                        Treasurer (Fake)<br>
                        As the Treasurer, I manage the financial health of our bookstore, ensuring every purchase contributes to our mission of spreading the joy of reading.
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:50%;text-align:left;">
                    <img src="images/ryujin.jpeg" style="width:200px;height:200px;margin-right:30px;margin-top:5px;" alt="map">
                    <p style="font-size:20px;margin-top:50px;">
                        Marketing Manager (Fake)<br>
                        The manager of the market, I craft strategies to share our love of books with the world, connecting readers to our bookstore and spreading the joy of reading far and wide.
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:50%;text-align:left;">
                    <img src="images/pikachu.jpg" style="width:200px;height:200px;margin-right:30px;margin-top:5px;" alt="map">
                    <p style="font-size:20px;margin-top:50px;">
                        Logistics Coordinator (Fake)<br>
                        The coordinator of the logistics, I orchestrate the seamless flow of books from publishers to your hands, ensuring timely deliveries and smooth operations for our bookstore.
                    </p>
                </div>
                <br>
                <div style="display:flex;max-width:50%;text-align:left;">
                    <img src="images/choujinx.jpeg" style="width:200px;height:200px;margin-right:30px;margin-top:5px;" alt="map">
                    <p style="font-size:20px;margin-top:50px;">
                        Tech Supporter (Fake)<br>
                        The supporter of the tech, I ensure our online bookstore runs smoothly, providing assistance and solutions to keep your browsing and shopping experience hassle-free.
                    </p>
                </div>
                <div style="height:3em;"></div>

                <p style="max-width:40%;font-size:40px;">Contact Us</p>
                <p style="max-width:40%;font-size:20px;">
                    We welcome all ideas, and aren't afraid to learn from a misstep. 
                    If you have any questions, comments, or concerns, please feel free to reach out to us!
                </p>
                <div style="height:1em;"></div>

                <form action="contact.php" method="post">
                    <div style="display:flex;justify-content:center;text-align:left;font-size:22px;">
                    <p>
                        Name<br>
                        <input class="input-box" type="text" name="name" autocomplete="off" required>
                        <br><br>
                        Email<br>
                        <input class="input-box" type="email" name="email" autocomplete="off" required>
                        <br><br>
                        Message<br>
                        <textarea class="input-box" name="message" autocomplete="off" required></textarea>
                        <br><br>
                        <button class="button button1" style="width:520px;" type="submit">Send Message</button>
                    </p>
                    </div>
                </form>
                
            </center>
        </div>

        <!-- End of Main Content -->

        <div style="height:3em;"></div>

        <!-- Start of Footer Section -->

        <footer style="color:#FFFFFF;">
            <hr style="border:0;height:1px;background-color:#8B8B83;margin:0;">
            <div style="height:1em;"></div>
            <p style="font-size:15px;color:#000000;padding-left:10em;">&copy; 2024 Ye Moe CSC 350 Software Development. All Rights Reserved.</p>
        </footer>

        <!-- End of Footer Section -->

        <div style="height:1em;"></div>

    </body>
</html>
