<?php
	session_start();
	if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] == false) {
		header("Location: index.php");
		
	} 

?>

<h2>Hello User, Welcome to Footbal Fan Hub!</h2>