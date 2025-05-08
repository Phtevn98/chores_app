<?php
include 'db.php'; // Connects to the database
session_start();  // Starts the session to store login info

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username']; // Get username from form
    $password = $_POST['password']; // Get password from form

    // Look up the user in the database by username
    $result = pg_query($dbconnect, "SELECT * FROM users WHERE username = '$username'");
    $user = pg_fetch_assoc($result); // Get the first row as an array

    if ($user) {
        // Check if the entered password matches the stored hash
        if (password_verify($password, $user['password_hash'])) {
            // If password is correct, save user ID in the session
            $_SESSION['user_id'] = $user['user_id'];

            // Redirect to the homepage after successful login
            header('Location: index.php');
            exit;
        } else {
            // Password did not match
            echo "Invalid password.";
        }
    } else {
        // No user found with that username
        echo "User not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <?php include 'header.php'; // Include header.php where the stylesheet is setup ?>
</head>
<body>
<?php include 'navbar.php'; // Display the navbar ?>

<h2>Login</h2>

<!-- Login form -->
<form method="POST">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
</body>
</html>
