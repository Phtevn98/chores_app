<?php
if (!isset($_SESSION)) {
    session_start();
}

// get db connection
require_once __DIR__ . '/db.php';

// get user language, default to en
$lang_code = 'en';
if (isset($_SESSION['user_id'])) {
    $result = pg_query_params($dbconnect, 'SELECT lang_code FROM users WHERE user_id = $1', [$_SESSION['user_id']]);
    if ($row = pg_fetch_assoc($result)) {
        $lang_code = $row['lang_code'] ?? 'en';
    }
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
