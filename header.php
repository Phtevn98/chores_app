<?php
if (!isset($_SESSION)) {
    session_start();
}

require_once __DIR__ . '/db.php';

// Pull debug values from site_config table
$debug = false;
$debug_level = 0;
$config_result = pg_query($dbconnect, "SELECT debug, debug_level FROM site_config WHERE id = 1");
if ($config_result && $row = pg_fetch_assoc($config_result)) {
    $debug = $row['debug'] === 't';
    $debug_level = $row['debug_level'];
}

// get user language, default to en
$lang_code = 'en';
if (isset($_SESSION['user_id'])) {
    $result = pg_query_params($dbconnect, 'SELECT lang_code FROM users WHERE user_id = $1', [$_SESSION['user_id']]);
    if ($row = pg_fetch_assoc($result)) {
        $lang_code = $row['lang_code'] ?? 'en';
    }

    // Always check admin status on every page load
    $admin_result = pg_query_params($dbconnect, 'SELECT 1 FROM site_administrators WHERE user_id = $1 LIMIT 1', [$_SESSION['user_id']]);
    $_SESSION['is_site_admin'] = (pg_num_rows($admin_result) > 0);
} else {
    $_SESSION['is_site_admin'] = false;
}

// load language pack
$lang = require __DIR__ . "/lang/{$lang_code}.php";
?>

<!-- Meta -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- Custom CSS -->
<link rel="stylesheet" href="/assets/css/styles.css">

<?php if ($debug && $debug_level >= 2): ?>
    <script>
        console.log("🛠 Debug: Admin status is <?= $_SESSION['is_site_admin'] ? 'TRUE' : 'FALSE' ?>");
    </script>
<?php endif; ?>
