<?php
session_start();

// Redirect logged-in users to the main chat page
if (isset($_SESSION['unique_id'])) {
    header("location: users.php");
    exit; // Ensure that no further code execution occurs after redirection
}
?>

<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css"> <!-- Adjust the path to your CSS file -->
    <title>Realtime Chat App - Login</title>
</head>
<body>
<div class="wrapper">
    <section class="form login">
        <header>Realtime Chat App</header>
        <form action="#" method="POST" autocomplete="off">
            <div class="error-text"></div>
            <div class="field input">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="field input">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
                <i class="fas fa-eye"></i>
            </div>
            <div class="field button">
                <input type="submit" name="submit" value="Continue to Chat">
            </div>
        </form>
        <div class="link">Not yet signed up? <a href="index.php">Signup now</a></div>
    </section>
</div>

<script src="javascript/pass-show-hide.js"></script>
<script src="javascript/login.js"></script>
</body>
</html>
