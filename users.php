<?php
  session_start();
  include_once "php/config.php";

  // Check if the user is not logged in; redirect to login page if not
  if (!isset($_SESSION['unique_id'])) {
    header("location: login.php");
    exit; // Make sure to exit after a redirect
  }

  // Fetch user data
  $user_id = $_SESSION['unique_id'];
  $query = "SELECT * FROM users WHERE unique_id = $user_id";
  $result = mysqli_query($conn, $query);

  if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
  } else {
    // Handle the case where user data is not found
    // You can customize this part as needed
    echo "User data not found.";
    exit; // Exit to prevent further execution
  }
?>

<?php include_once "header.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css"> <!-- Adjust the path to your CSS file -->
  <title>Your Chat Application</title>
</head>
<body>
  <div class="wrapper">
    <section class="users">
      <header>
        <div class="content">
          <img src="php/images/<?php echo $row['img']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['fname'] . " " . $row['lname']; ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
        <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>" class="logout">Logout</a>
      </header>
      <div class="search">
        <span class="text">Select a user to start a chat</span>
        <input type="text" placeholder="Enter a name to search...">
        <button><i class="fas fa-search"></i></button>
      </div>
      <div class="users-list">
        <!-- Display the list of users here -->
      </div>
    </section>
  </div>

  <script src="javascript/users.js"></script>
</body>
</html>
