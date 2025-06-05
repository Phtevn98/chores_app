<?php
if (!isset($_SESSION)) {
    session_start();
}

define('BASE_PATH', realpath(__DIR__ . '/..'));
include BASE_PATH . '/header.php';

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: /login.php');
    exit;
}

$chores_results = pg_query($dbconnect, "SELECT * FROM chores");
if (!$chores_results) {
    die("Database query failed: " . pg_last_error($dbconnect));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chores App - <?= htmlspecialchars($lang['site_config'] ?? 'Site_config') ?></title>
</head>
<body>
<?php include BASE_PATH . '/navbar.php'; ?>

<div class="text-center mt-3">

</div>

<?php include BASE_PATH . '/footer.php'; ?>
</body>
</html>