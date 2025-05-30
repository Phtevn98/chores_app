<?php
include 'db.php';

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['user_id'], $_SESSION['username'])) {
    header('Location: login.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chore_name = pg_escape_string($dbconnect, $_POST['chore_name']);
    $description = pg_escape_string($dbconnect, $_POST['description']);
    $assigned_to = pg_escape_string($dbconnect, $_POST['assigned_to']);
    $frequency = pg_escape_string($dbconnect, $_POST['frequency']);

    $query = "INSERT INTO chores (chore_name, description, assigned_to, frequency)
              VALUES ('$chore_name', '$description', '$assigned_to', '$frequency')";
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
            <label class="form-label">Assigned To</label>
            <input type="text" name="assigned_to" class="form-control">
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
        <button type="submit" class="btn btn-success">Add Chore</button>
    </form>
</div>

<?php include 'footer.php'; ?>
</body>
</html>
