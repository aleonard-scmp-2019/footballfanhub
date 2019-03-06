<?php
	
	if (isset($_POST['submit'])) {
		include_once 'dbh.php';
		
		$first = mysqli_real_escape_string($conn, $_POST['first']);
		$last = mysqli_real_escape_string($conn, $_POST['last']);
		$email = mysqli_real_escape_string($conn, $_POST['email']);
		$uid = mysqli_real_escape_string($conn, $_POST['uid']);
		$pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
		
		// Error Handles
		//Check empty boxes
		if (empty($first) || empty($last) || empty($email) || empty($uid) || empty($pwd)) {
			header("Location: ../signup.php?signup=emptyfield");
			exit();
		} else {
			//Check if names are valid
			if (!preg_match("/^[a-zA-Z]*$/",$first) || !preg_match("/^[a-zA-Z]*$/",$last)) {
				header("Location: ../signup.php?signup=invalid");
				exit();
			} else {
				// check email is valid
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					header("Location: ../signup.php?signup=invalidemail");
					exit();
				} else {
					$sql = "SELECT * FROM users WHERE user_uid='$uid'";
					$result = mysqli_query($conn, $sql);
					$resultCheck = mysqli_num_rows($result);
					
					if ($resultCheck > 0) {
						header("Location: ../signup.php?signup=usernametaken");
						exit();
					} else {
						//hashing password
						$hashedpwd = password_hash($pwd, PASSWORD_DEFAULT);
						//Insert User into DB
						$sql = "insert into users (user_first, user_last, user_email, user_uid, user_pwd) VALUES ('$first', '$last', '$email', '$uid', '$hashedpwd');";
						mysqli_query($conn, $sql);
						header("Location: ../index.php?signup=success");
						exit();
					}
				}
			}
		}
	
	} else{
		header("Location: ../footballfanhub/signup.php");
		exit();
	}