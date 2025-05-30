<?php
// CLI script to create a basic user
include __DIR__ . '/../../db.php';

if (!$dbconnect) {
    die("Database connection failed.\n");
}

// Prompt for username
echo "Enter username: ";
$username = trim(fgets(STDIN));

// Prompt for password (plaintext, for now)
echo "Enter password: ";
$password = trim(fgets(STDIN));
echo "\n";

// Hash the password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Insert user
$sql = "INSERT INTO users (username, password_hash) VALUES ($1, $2)";
$result = pg_query_params($dbconnect, $sql, [$username, $password_hash]);

if ($result) {
    echo "User created successfully.\n";
} else {
    echo "Error: " . pg_last_error($dbconnect) . "\n";
}
