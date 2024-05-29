<?php
    session_start();
    include_once "config.php";

    $unique_id = $_SESSION['unique_id'];
    $name = $password = $age = $email = $language = $interests = $info = ""; 
/*
if (isset($_SESSION['unique_id'])) {
   

   $update_id = mysqli_real_escape_string($conn, $_GET['update_id']);
    $get_user = "select * from users where unique_id = {$update_id} ";
    $run_user = mysqli_query($conn, $get_user);
    $row = mysqli_fetch_array($run_user);

    $name = $row['name'];
    $password = $row['password'];
    $age = $row['age'];
    $email = $row['email'];
    $language = $row['language'];
    $interests = $row['interests'];
    $info = $row['info'];

    $name_new = mysqli_real_escape_string($conn, $_POST['name']);
    $password_new = mysqli_real_escape_string($conn, $_POST['password']);
    $age_new = mysqli_real_escape_string($conn, $_POST['age']);
    $email_new = mysqli_real_escape_string($conn, $_POST['email']);
    $language_new = mysqli_real_escape_string($conn, $_POST['language']);
    $interests_new = mysqli_real_escape_string($conn, $_POST['interests']);
    $info_new = mysqli_real_escape_string($conn, $_POST['info']);

    if (!empty($name) && !empty($age) && !empty($language) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $encrypt_pass = md5($password_new);
            $update_query = mysqli_query($conn, "UPDATE users SET name = '{$name_new}', email = '{$email_new}', password = '{$encrypt_pass}', age = '{$age_new}', language = '{$language_new}', interests = '{$interests_new}', info = '{$info_new}' WHERE unique_id = '{$update_id}'");
            
            if ($update_query) {
                echo "success";
            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            echo "$email_new is not a valid email!";
        }
    } else {
        echo "Check required input fields!";
    }
} else {
    echo "Session expired. Please log in again."; */

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['update_id'])) {
        $update_id = mysqli_real_escape_string($conn, $_GET['update_id']);
        $get_user = "SELECT * FROM users WHERE unique_id = {$update_id}";
        $run_user = mysqli_query($conn, $get_user);
        
        if (mysqli_num_rows($run_user) > 0) {
            $row = mysqli_fetch_assoc($run_user);

            $name = $row['name'];
            $password = $row['password'];
            $age = $row['age'];
            $email = $row['email'];
            $language = $row['language'];
            $interests = $row['interests'];
            $info = $row['info'];
        } else {
            echo "User not found.";
            exit;
        }
    } else {
        echo "No user ID provided.";
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name_new = mysqli_real_escape_string($conn, $_POST['name']);
    $password_new = mysqli_real_escape_string($conn, $_POST['password']);
    $age_new = mysqli_real_escape_string($conn, $_POST['age']);
    $email_new = mysqli_real_escape_string($conn, $_POST['email']);
    $language_new = mysqli_real_escape_string($conn, $_POST['language']);
    $interests_new = mysqli_real_escape_string($conn, $_POST['interests']);
    $info_new = mysqli_real_escape_string($conn, $_POST['info']);

    if (!empty($name_new) && !empty($age_new) && !empty($language_new) && !empty($password_new)) {
        if (filter_var($email_new, FILTER_VALIDATE_EMAIL)) {
            $encrypt_pass = md5($password_new);
            $update_query = mysqli_query($conn, "UPDATE users SET name = '{$name_new}', email = '{$email_new}', password = '{$encrypt_pass}', age = '{$age_new}', language = '{$language_new}', interests = '{$interests_new}', info = '{$info_new}' WHERE unique_id = '{$update_id}'");

            if ($update_query) {
                echo "success";
            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            echo "$email_new is not a valid email!";
        }
    } else {
        echo "Check required input fields!";
    }
} else {
    echo "Invalid request method.";
    exit;
}
?>


