<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    include("connections.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //something was posted
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)){
            //save to database
            $max_user_id = 999999; // Set the maximum allowed value for user_id
            $user_id = random_num(20, $max_user_id);
            $query = "INSERT INTO users (user_id, first_name, last_name, email, password) VALUES ('$user_id', '$first_name', '$last_name', '$email', '$password')";

            mysqli_query($con, $query);

            header("Location: login.php");
            die;
        }
        else{
            echo "Please enter some valid information!";
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
    <section>
        <form action="register.php" method="post" enctype="multipart/form-data">
            <h1 style="font-size:50px;text-align:center;margin-top:10em;">Moe's Pen & Paper</h1>
            <h2 style="font-size:50px;text-align:center;">Sign Up</h2>
            <input class="input-box" type="text" name="first_name" placeholder="First Name" autocomplete="off" required>
            <br><br>
            <input class="input-box" type="text" name="last_name" placeholder="Last Name" autocomplete="off" required>
            <br><br>
            <input class="input-box" type="email" name="email" placeholder="Email" autocomplete="off" required>
            <br><br>
            <input class="input-box" type="password" name="password" placeholder="Password" autocomplete="off" required>
            <br><br><br>
            <input class="radio-input" type="radio" name="news" value="news" id="news-radio" required>
            <label for="news-radio" class="radio-label">
                <span class="radio-custom"></span>
                Yes, I would like to receive the latest news from Moe's Pen & Paper via email
            </label>
            <br><br>
            <input class="radio-input" type="radio" name="tspp" value="tspp" id="tspp-radio" required>
            <label for="tspp-radio" class="radio-label">
                <span class="radio-custom"></span>
                I have read and agree to the <u>Terms of Service</u> and <u>Privacy Policy</u>
            </label>
            <div style="height:3em;"></div>
            <hr style="border:0;width:60em;height:1px;background-color:#8B8B83;margin:0;">
            <div style="height:3em;"></div>
            <button class="button button1" type="submit">Sign Up</button>
            <p style="font-size:22px;">Already have an account? <a style="color:#8B8B83;text-decoration:underline;" href="login.php">Login</a></p>
            <p style="font-size:22px;">By signing up, you agree to our <u>Terms of Service</u> and <u>Privacy Policy</u></p><br>
            <p style="font-size:13px;">Copyright &copy; Ye Moe 2024 CSC 350 Software Development Prof. Kahanda</p>
            <div style="height:1em;"></div>
        </form>
    </section>
</body>
</html>
