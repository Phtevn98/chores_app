<?php
include 'header.php';     // Session handling via header.php
include 'db.php'; // Establishes db connection

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

$chores_results = pg_query($dbconnect, "SELECT * FROM chores");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chores App</title>
    <?php include 'header.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h1>Chores List</h1>
    <ul>
        <?php while ($chore = pg_fetch_assoc($chores_results)): ?>
            <li><?php echo htmlspecialchars($chore['chore_name']); ?></li>
        <?php endwhile; ?>
    </ul>
</div>
</body>
</html>
