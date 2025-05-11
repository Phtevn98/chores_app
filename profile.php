<?php
include 'header.php'; // Session handling via header.php file

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$username = htmlspecialchars($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $username; ?>'s Profile</title>
    <?php include 'header.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4 text-center">
    <h1><?php echo $username; ?>'s Profile</h1>

    <img src="https://www.svgrepo.com/show/335455/profile-default.svg"
         alt="Profile picture"
         class="rounded-circle mb-3"
         width="120"
         height="120">

    <p><strong>Username:</strong> <?php echo $username; ?></p>
</div>
<?php
include 'footer.php';
?>
</body>
</html>
