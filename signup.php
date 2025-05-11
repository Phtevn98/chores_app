<?php
include 'header.php'; // Session handling via header.php file
include 'db.php';

if (!isset($_SESSION)) {
    session_start();
}

// Check if db connection is established, if not, print error message
if (!$dbconnect) {
    die("Database Connection failed: ");
}

// Block access if user is already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $agree = isset($_POST['agree']);

    // Enforce accepting of T&C
    if (!$agree) {
        $message = "You must agree to the Terms and Conditions.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password_hash) VALUES ($1, $2)";
        $result = pg_query_params($dbconnect, $sql, [$username, $password_hash]);

        if (!$result) {
            $message = "Error: " . pg_last_error($dbconnect);
        } else {
            $message = "Signup successful. You can now log in.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <?php include 'header.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h1>Create an Account</h1>

    <?php if (isset($message)): ?>
        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Username:
                <input type="text" name="username" class="form-control" required>
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Password:
                <input type="password" name="password" class="form-control" required>
            </label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="agree" id="agree" required>
            <label class="form-check-label" for="agree">
                I agree to the <a href="terms.php" target="_blank">Terms and Conditions</a>
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Sign Up</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
