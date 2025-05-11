<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION)) {
    session_start();
}

// Check if db connection is established, if not, print error message
if (!$dbconnect) {
    die("Database Connection failed: ");
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Access denied: not logged in");
}

$checkAdmin = pg_query_params($dbconnect, "SELECT 1 FROM admins WHERE user_id = $1", [$_SESSION['user_id']]
);

// Check if user is an admin
if (pg_num_rows($checkAdmin) == 0) {
    die ("Access denied: not an admin.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password_hash) VALUES ($1, $2)";
    $result = pg_query_params($dbconnect, $sql, [$username, $password_hash]);

    if (!$result) {
        $message = "Error: " . pg_last_error($dbconnect);
    } else {
        $message = "User created successfully.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
    <?php include 'header.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h1>Create New User</h1>

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
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
