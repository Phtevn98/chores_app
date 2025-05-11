<?php
// Include DB connection
include __DIR__ . '/../../db.php';

if (!$dbconnect) {
    die("Database connection failed.\n");
}

// Prompt for username and password
echo "Enter username: ";
$username = trim(fgets(STDIN));

// echo "Enter password: ";
// system('stty -echo'); // REMOVE THIS LINE (Unix only)
echo "Enter password: ";
$password = trim(fgets(STDIN));
// system('stty echo');  // REMOVE THIS LINE
echo "\n";


// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert into database
$sql = "INSERT INTO users (username, password_hash) VALUES ($1, $2)";
$result = pg_query_params($dbconnect, $sql, [$username, $password_hash]);

if ($result) {
    echo "User created successfully.\n";
} else {
    echo "Error: " . pg_last_error($dbconnect) . "\n";
}
?>