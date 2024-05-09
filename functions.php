<?php

include("connections.php");

function check_login($con){

    if(isset($_SESSION['user_id'])){
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' limit 1";

        // // Debugging: Print MySQLi connection object
        // var_dump($con);

        // // Debugging: Print query
        // echo "Query: $query";

        $result = mysqli_query($con, $query);

        if(!$result){
            echo "Error: " . mysqli_error($con);
            die;
        }

        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        }
    }
    //redirect to login
    header("Location: login.php");
    die;
}

function random_num($length, $max_value) {
    $text = "";
    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    $random_num = (int) $text;

    // Check if $max_value is valid
    if ($max_value === null || $max_value <= 0) {
        // Return a default value or raise an error
        return $random_num;
        // or
        // throw new Exception("Invalid maximum value provided for random_num()");
    }

    // Ensure the generated number is within the allowed range
    return $random_num % $max_value;
}

// Threshold values
$in_stock_threshold = 10; // Quantity above this value is considered "in-stock"
$low_stock_threshold = 5; // Quantity below this value is considered "low quantity"

function getStockStatus($quantity)
{
    global $in_stock_threshold, $low_stock_threshold;

    if ($quantity == 0) {
        return '<span style="color:red;">Out of stock</span>';
    } 
    elseif ($quantity <= $low_stock_threshold) {
        return '<span style="color:orange;">Low quantity</span>';
    } 
    else {
        return '<span style="color:green;">In stock</span>';
    }
}

?>