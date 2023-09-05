<?php
session_start();
include_once "config.php";

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($email) && !empty($password)) {
        $sql = "SELECT * FROM users WHERE email = '{$email}'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_pass = md5($password); // Please consider using a more secure hashing method (e.g., bcrypt)

            if ($user_pass === $row['password']) {
                $status = "Active now";
                $update_sql = "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}";
                $update_result = mysqli_query($conn, $update_sql);

                if ($update_result) {
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                } else {
                    echo "Something went wrong. Please try again!";
                }
            } else {
                echo "Email or Password is Incorrect!";
            }
        } else {
            echo "Email not found. Please check your email!";
        }
    } else {
        echo "All input fields are required!";
    }
} else {
    echo "Invalid request!";
}
?>
