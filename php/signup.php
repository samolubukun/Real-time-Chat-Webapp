<?php
session_start();
include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = "SELECT * FROM users WHERE email = '{$email}'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "This email already exists!";
            } else {
                if (isset($_FILES['image'])) {
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];

                    $img_explode = explode('.', $img_name);
                    $img_ext = end($img_explode);

                    $allowed_extensions = ["jpeg", "png", "jpg"];
                    if (in_array($img_ext, $allowed_extensions)) {
                        $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
                        if (in_array($img_type, $allowed_types)) {
                            $time = time();
                            $new_img_name = $time . $img_name;
                            if (move_uploaded_file($tmp_name, "images/" . $new_img_name)) {
                                $ran_id = rand(time(), 100000000);
                                $status = "Active now";
                                $encrypt_pass = md5($password);
                                $insert_query = "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                    VALUES ({$ran_id}, '{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')";

                                if (mysqli_query($conn, $insert_query)) {
                                    $select_sql2 = "SELECT * FROM users WHERE email = '{$email}'";
                                    $result2 = mysqli_query($conn, $select_sql2);

                                    if ($result2 && mysqli_num_rows($result2) > 0) {
                                        $row = mysqli_fetch_assoc($result2);
                                        $_SESSION['unique_id'] = $row['unique_id'];
                                        echo "success";
                                    } else {
                                        echo "User registration failed. Please try again!";
                                    }
                                } else {
                                    echo "Something went wrong. Please try again!";
                                }
                            } else {
                                echo "Failed to upload the image.";
                            }
                        } else {
                            echo "Please upload an image file - jpeg, png, jpg";
                        }
                    } else {
                        echo "Please upload an image file - jpeg, png, jpg";
                    }
                }
            }
        } else {
            echo "Invalid email format!";
        }
    } else {
        echo "All input fields are required!";
    }
} else {
    echo "Invalid request!";
}
?>
