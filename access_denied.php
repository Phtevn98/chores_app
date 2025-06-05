<?php
if (!isset($_SESSION)) {
    session_start();
}

define('BASE_PATH', realpath(__DIR__));
include BASE_PATH . '/header.php';

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chores App</title>
</head>
<body>
<?php include BASE_PATH . '/navbar.php'; ?>

<div class="text-center mt-3">
    <h3 class="text-info">Woah, you don't have the right permissions to view this!</h3>
</div>

<img id="access-denied-img" src="/assets/static/access_denied.png" alt="Access Denied" class="img-fluid mx-auto d-block" style="max-width: 400px;">

<div class="text-center mt-3">
    <button onclick="history.back()" class="btn btn-secondary mt-4">Go Back</button>
</div>

<?php include BASE_PATH . '/footer.php'; ?>
</body>
</html>
