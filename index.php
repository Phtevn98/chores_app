<?php
if (!isset($_SESSION)) {
    session_start();
}

include 'db.php';

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: login.php');
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
    <title>Chores App</title>
    <?php include 'header.php'; ?>

    <!-- Prevent favicon 404 -->
    <link rel="icon" href="data:,">
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="text-center mt-3">
    <h4 class="text-info">🧽 Time to tackle some chores! Let’s see what’s on the board...</h4>
</div>

<div class="chore-cards-container">
    <div class="row row-cols-1 row-cols-md-3 g-4 mt-3">
        <?php if (pg_num_rows($chores_results) > 0): ?>
            <?php while ($chore = pg_fetch_assoc($chores_results)): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($chore['chore_name']); ?></h5>
                            <?php if (!empty($chore['description'])): ?>
                                <p class="card-text"><?php echo htmlspecialchars($chore['description']); ?></p>
                            <?php endif; ?>
                            <?php if (!empty($chore['assigned_to'])): ?>
                                <span class="badge bg-primary">Assigned to: <?php echo htmlspecialchars($chore['assigned_to']); ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="card-footer text-muted">
                            <?php if (!empty($chore['due_date'])): ?>
                                Due: <?php echo htmlspecialchars(date('j M Y', strtotime($chore['due_date']))); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col">
                <div class="alert alert-info text-center w-100">
                    No chores found.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
