<?php
include 'db.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Fetch users for dropdown
$user_result = pg_query($dbconnect, "SELECT user_id, username FROM users ORDER BY username ASC");
$users = [];
while ($row = pg_fetch_assoc($user_result)) {
    $users[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chore_name_raw = filter_input(INPUT_POST, 'chore_name', FILTER_SANITIZE_STRING);
    $description_raw = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $frequency_raw = filter_input(INPUT_POST, 'frequency', FILTER_SANITIZE_STRING);
    $next_due_at_raw = filter_input(INPUT_POST, 'next_due_at', FILTER_SANITIZE_STRING);
    $next_to_complete_by_raw = filter_input(INPUT_POST, 'next_to_complete_by', FILTER_SANITIZE_NUMBER_INT);

    $chore_name = pg_escape_string($dbconnect, $chore_name_raw);
    $description = pg_escape_string($dbconnect, $description_raw);
    $frequency = pg_escape_string($dbconnect, $frequency_raw);
    $next_due_at = !empty($next_due_at_raw) ? pg_escape_string($dbconnect, $next_due_at_raw) : null;
    $next_to_complete_by = !empty($next_to_complete_by_raw) ? intval($next_to_complete_by_raw) : 'NULL';

    $query = "INSERT INTO chores (chore_name, description, frequency, next_due_at, next_to_complete_by)
              VALUES ('$chore_name', '$description', '$frequency', " .
        ($next_due_at ? "'$next_due_at'" : "NULL") . ", " .
        ($next_to_complete_by ? $next_to_complete_by : "NULL") . ")";
    pg_query($dbconnect, $query);
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Chore</title>
    <?php include 'header.php'; ?>
</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <h4 class="text-info text-center">📝 Add a New Chore</h4>
    <form method="POST" class="mt-3">
        <div class="mb-3">
            <label class="form-label">Chore Name</label>
            <input type="text" name="chore_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Assigned To (Next To Complete)</label>
            <select name="next_to_complete_by" class="form-select">
                <option value="">Unassigned</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['user_id']) ?>">
                        <?= htmlspecialchars($user['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Frequency</label>
            <select name="frequency" class="form-select" required>
                <option value="">Select frequency</option>
                <option value="once">Once</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="fortnightly">Fortnightly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Next Due Date</label>
            <input type="date" name="next_due_at" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Add Chore</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
