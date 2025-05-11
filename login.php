<?php
include 'db.php'; // Connects to the database
session_start();  // Starts the session to store login info
$error = '';

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
            header('Location: index.php');
            exit;
        } else {
            $error = 'Username or password is incorrect';
        }
    } else {
        $error = 'User does not exist.';
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

<?php if (!empty($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($error); ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    </div>
<?php endif; ?>

<!-- Login form -->
<div class="container mt-4" style="max-width: 400px;">
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Login</button>

        <!-- Link to sign-up page -->
        <p> Don't have an account? <a href="/signup.php">Sign up here</a></p>

    </form>
</body>
</html>
