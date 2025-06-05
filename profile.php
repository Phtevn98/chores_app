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

$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $username ?>'s Profile</title>
</head>
<body>
<?php include BASE_PATH . '/navbar.php'; ?>

<div class="container mt-4 text-center">
    <h1><?= $username ?>'s Profile</h1>

    <img src="https://www.svgrepo.com/show/335455/profile-default.svg"
         alt="Profile picture"
         class="rounded-circle mb-3"
         width="120"
         height="120">

    <p><strong>Username:</strong> <?= $username ?></p>
</div>

<?php include BASE_PATH . '/footer.php'; ?>
</body>
</html>