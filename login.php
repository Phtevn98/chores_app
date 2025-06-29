<?php
if (!isset($_SESSION)) {
    session_start();
}

define('BASE_PATH', realpath(__DIR__));
include BASE_PATH . '/header.php';

if (isset($_SESSION['user_id'])) {
    header('Location: /index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $result = pg_query_params($dbconnect, "SELECT * FROM users WHERE LOWER(username) = LOWER($1)", [$username]);

        if ($result && pg_num_rows($result) === 1) {
            $user = pg_fetch_assoc($result);

            if (password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /index.php');
                exit;
            } else {
                $error = 'Username or password is incorrect.';
            }
        } else {
            $error = 'User does not exist.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
</head>
<body>
<?php include BASE_PATH . '/navbar.php'; ?>

<div class="container mt-5" style="max-width: 400px;">
    <h2 class="text-center mb-4">Login Page</h2>

    <?php if ($error !== ''): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <form method="POST" novalidate>
        <div class="form-group mb-3">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" name="username" required autofocus>
        </div>

        <div class="form-group mb-3">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">Login</button>

        <div class="text-center mt-3">
            <p>Don't have an account? <a href="/signup.php">Sign up here</a></p>
        </div>
    </form>
</div>

<?php include BASE_PATH . '/footer.php'; ?>
</body>
</html>
