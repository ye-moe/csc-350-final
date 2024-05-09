<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

    include("connections.php");
    include("functions.php");

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        //something was posted
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($email) && !empty($password)){
            //read from database
            $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($con, $query);

            if(!$result){
                die("Error in query: " . mysqli_error($con));
            }

            if($result && mysqli_num_rows($result) > 0){
                $user_data = mysqli_fetch_assoc($result);

                if($user_data['password'] === $password){
                    $_SESSION['user_id'] = $user_data['user_id'];
                    $_SESSION['first_name'] = $user_data['first_name'];
                    header("Location: index.php");
                    die;
                } 
                else {
                    $_SESSION['error'] = "Incorrect email or password!";
                    header("Location: login.php");
                    die;
                }
            } 
            else {
                $_SESSION['error'] = "Incorrect email or password!";
                header("Location: login.php");
                die;
            }
        } 
        else {
            $_SESSION['error'] = "Please enter some valid information!";
            header("Location: login.php");
            die;
        }
    }

// Clear error message if exists
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
} else {
    $error_message = "";
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
        <form action="login.php" method="post" enctype="multipart/form-data">
            <h1 style="font-size:50px;text-align:center;margin-top:5em;">Moe's Pen & Paper</h1>
            <h2 style="font-size:50px;text-align:center;">Log In</h2>
            <input class="input-box" type="email" name="email" placeholder="Email" autocomplete="off" required>
            <br><br>
            <input class="input-box" type="password" name="password" placeholder="Password" autocomplete="off" required>
            <br><br><br>

            <?php
            if (!empty($error_message)) {
                echo "<p style='color:red;font-size:22px;text-align:center;'>$error_message</p>";
            }
            ?>

            <p style="font-size:22px;">Don't Have An Account? <a style="color:#8B8B83;text-decoration:underline;" href="register.php">Sign Up</a></p><br>
            <hr style="border:0;width:60em;height:1px;background-color:#8B8B83;margin:0;">
            <div style="height:3em;"></div>
            <button class="button button1" type="submit">Log In</button>
            <div style="height:3em;"></div>
            <p style="font-size:13px;">Copyright &copy; Ye Moe 2024 CSC 350 Software Development Prof. Kahanda</p>
            <div style="height:1em;"></div>

        </form>
    </section>
</body>
</html>
