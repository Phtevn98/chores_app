<?php
if (!isset($_SESSION)) {
    session_start();
}

define('BASE_PATH', realpath(__DIR__));
include BASE_PATH . '/header.php';

if (!$dbconnect) {
    die("Database Connection failed");
}

if (!isset($_SESSION['user_id'])) {
    die("Access denied: not logged in");
}

$checkAdmin = pg_query_params($dbconnect, "SELECT 1 FROM admins WHERE user_id = $1", [$_SESSION['user_id']]);

if (pg_num_rows($checkAdmin) === 0) {
    die("Access denied: not an admin.");
}

$message = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $message = "Username and password are required.";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (username, password_hash) VALUES ($1, $2)";
        $result = pg_query_params($dbconnect, $sql, [$username, $password_hash]);

        if (!$result) {
            $message = "Error: " . pg_last_error($dbconnect);
        } else {
            $message = "User created successfully.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create User</title>
</head>
<body>
<?php include BASE_PATH . '/navbar.php'; ?>

<div class="container mt-4">
    <h1>Create New User</h1>

    <?php if ($message !== null): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="username" class="form-label">Username:</label>
            <input id="username" type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input id="password" type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
    </form>
</div>

<?php include BASE_PATH . '/footer.php'; ?>
</body>
</html>
