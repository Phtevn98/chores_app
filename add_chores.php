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

$user_result = pg_query($dbconnect, "SELECT user_id, username FROM users ORDER BY username ASC");
$users = [];
while ($row = pg_fetch_assoc($user_result)) {
    $users[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chore_name = trim(filter_input(INPUT_POST, 'chore_name', FILTER_SANITIZE_STRING));
    $description = trim(filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING));
    $frequency = trim(filter_input(INPUT_POST, 'frequency', FILTER_SANITIZE_STRING));
    $next_due_at = filter_input(INPUT_POST, 'next_due_at', FILTER_SANITIZE_STRING);
    $next_to_complete_by = filter_input(INPUT_POST, 'next_to_complete_by', FILTER_VALIDATE_INT);

    $chore_name_esc = pg_escape_string($dbconnect, $chore_name);
    $description_esc = pg_escape_string($dbconnect, $description);
    $frequency_esc = pg_escape_string($dbconnect, $frequency);
    $next_due_at_esc = !empty($next_due_at) ? pg_escape_string($dbconnect, $next_due_at) : null;
    $next_to_complete_by_val = $next_to_complete_by !== false ? intval($next_to_complete_by) : 'NULL';

    $query = "INSERT INTO chores (chore_name, description, frequency, next_due_at, next_to_complete_by)
              VALUES (
                  '$chore_name_esc',
                  '$description_esc',
                  '$frequency_esc',
                  " . ($next_due_at_esc ? "'$next_due_at_esc'" : "NULL") . ",
                  " . ($next_to_complete_by_val !== 'NULL' ? $next_to_complete_by_val : "NULL") . "
              )";

    pg_query($dbconnect, $query);
    header('Location: /index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Chore</title>
</head>
<body>
<?php include BASE_PATH . '/navbar.php'; ?>

<div class="container mt-4">
    <h4 class="text-info text-center">📝 Add a New Chore</h4>
    <form method="POST" class="mt-3" novalidate>
        <div class="mb-3">
            <label class="form-label" for="chore_name">Chore Name</label>
            <input type="text" id="chore_name" name="chore_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label" for="description">Description</label>
            <textarea id="description" name="description" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label" for="next_to_complete_by">Assigned To (Next To Complete)</label>
            <select id="next_to_complete_by" name="next_to_complete_by" class="form-select">
                <option value="">Unassigned</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['user_id']) ?>">
                        <?= htmlspecialchars($user['username']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="frequency">Frequency</label>
            <select id="frequency" name="frequency" class="form-select" required>
                <option value="">Select frequency</option>
                <option value="once">Once</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="fortnightly">Fortnightly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label" for="next_due_at">Next Due Date</label>
            <input type="date" id="next_due_at" name="next_due_at" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Add Chore</button>
    </form>
</div>

<?php include BASE_PATH . '/footer.php'; ?>
</body>
</html>
