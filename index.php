<?php

include 'db.php';

$chores = "SELECT * FROM chores";
$chores_results = pg_query($dbconnect, $chores);
$chores_row = pg_fetch_assoc($chores_results);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chores App</title>
</head>
<body>
    <h1>Chores List</h1>

    <?php
    // pull chores from 'chores' table in the db and print as list
	echo "<ul>";
	while ($chores_row) {
		echo "<li>" . $chores_row['chore_name'] . "</li>";
		$chores_row = pg_fetch_assoc($chores_results);
	}
	echo "</ul>";
    ?>

</body>
</html>

