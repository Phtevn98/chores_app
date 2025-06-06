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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_debug = $_POST['debug_status'] === 'enabled' ? 't' : 'f';
    $new_debug_level = isset($_POST['debug_level']) ? intval($_POST['debug_level']) : 1;
    $update_result = pg_query_params($dbconnect, "UPDATE site_config SET debug = $1, debug_level = $2", [$new_debug, $new_debug_level]);
    if (!$update_result) {
        $base_url = strtok($_SERVER['REQUEST_URI'], '?');
        header("Location: $base_url?status=fail");
        exit;
    } else {
        $base_url = strtok($_SERVER['REQUEST_URI'], '?');
        header("Location: $base_url?status=success");
        exit;
    }
}

// Set alert message based on status GET param
$message = '';
$alert_class = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $message = "Debug status and level updated successfully.";
        $alert_class = "alert-success";
    } elseif ($_GET['status'] === 'fail') {
        $message = "Failed to update settings.";
        $alert_class = "alert-danger";
    }
}

// Fetch current config
$site_config_results = pg_query($dbconnect, "SELECT * FROM site_config");
if (!$site_config_results) {
    die("Database query failed: " . pg_last_error($dbconnect));
}
$site_config = pg_fetch_assoc($site_config_results);
$current_status = ($site_config['debug'] === 't' ? 'enabled' : 'disabled');
$current_level = (int)($site_config['debug_level'] ?? 1);

// Define debug level names
$debug_levels = [
    1 => 'Minimal',
    2 => 'Normal',
    3 => 'Developer'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chores App - <?= htmlspecialchars($lang['site_config'] ?? 'Site_config') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<?php include BASE_PATH . '/navbar.php'; ?>

<div class="container mt-4" style="max-width: 450px;">
    <h4 class="mb-3">Debugging enabled?</h4>
    <?php if (!empty($message)): ?>
        <div class="alert <?= $alert_class ?>"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>
    <form method="post" class="mb-3">
        <div class="mb-3">
            <label for="debug_status" class="form-label">Debug status</label>
            <select class="form-select" name="debug_status" id="debug_status">
                <option value="enabled" <?= $current_status === 'enabled' ? 'selected' : '' ?>>Enabled</option>
                <option value="disabled" <?= $current_status === 'disabled' ? 'selected' : '' ?>>Disabled</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="debug_level" class="form-label">Debug level</label>
            <select class="form-select" name="debug_level" id="debug_level">
                <?php foreach ($debug_levels as $level => $name): ?>
                    <option value="<?= $level ?>" <?= $current_level === $level ? 'selected' : '' ?>>
                        <?= $level ?> - <?= htmlspecialchars($name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" id="saveBtn" disabled>Save Changes</button>
    </form>
</div>

<!-- Script to check if the user has updated the options and then enable the 'Save Changes' button. -->
<script>
    document.addEventListener('DOMContentLoaded', function(){
        const debugStatus = document.getElementById('debug_status');
        const debugLevel = document.getElementById('debug_level');
        const saveBtn = document.getElementById('saveBtn');

        // Store initial values
        const initialStatus = debugStatus.value;
        const initialLevel = debugLevel.value;

        function checkChanges() {
            if (debugStatus.value !== initialStatus || debugLevel.value !== initialLevel) {
                saveBtn.disabled = false;
            } else {
                saveBtn.disabled = true;
            }
        }
        debugStatus.addEventListener('change', checkChanges);
        debugLevel.addEventListener('change', checkChanges);
    });
</script>

<?php include BASE_PATH . '/footer.php'; ?>
</body>
</html>
