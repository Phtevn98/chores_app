 <?php
$host = "localhost";
$dbname = "chores_app";
$username = "chores_app_admin";
$password = "1hMP3^2ICsFV";

// Establish database connection
$dbconnect = pg_connect("host=$host dbname=$dbname user=$username password=$password");

if ($dbconnect == false) {
	// Connection failed
	echo "Database connection failed.";
} else { 
	// Connection established
}

?> 
