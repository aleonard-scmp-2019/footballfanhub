<?php
	include_once 'includes/dbh.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
	$data = "Admin";
	// Create a template
	$sql = "SELECT * FROM users WHERE user_uid=?;";
	// create a prepared statement
	$stmt = mysqli_stmt_init($conn);
	// prepare the prepared statement
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "SQL statement failed";
	} else {
		// Bind parameters to the placeholder
		mysqli_stmt_bind_param($stmt, "s", $data);
		// Run params inside db
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		
		while ($row = mysqli_fetch_assoc($result)) {
			echo $row['user_uid'] . "<br>";
		}
	}
?>
</body>
</html>
