<?php 

	if(isset($_POST['reg-submit'])) {

		require 'dbconnect.php';
		session_start();
		$username = $_POST['username'];
		$email = $_POST['email'];
		$password = $_POST['password'];
		$phoneno = $_POST['phoneno'];

		if(empty($username) || empty($email) || empty($password) || empty($phoneno)) {
			$_SESSION['error'] = "emptyfields";
			$_SESSION['tmp_username'] = $username;
			$_SESSION['tmp_email'] = $email;
			$_SESSION['tmp_password'] = $password;
			$_SESSION['tmp_phoneno'] = $phoneno;
            header("Location: register.php");
            exit();

		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['error'] = "invalidmail";
			$_SESSION['tmp_username'] = $username;
			$_SESSION['tmp_password'] = $password;
			$_SESSION['tmp_phoneno'] = $phoneno;
			header("Location: register.php");
			exit();

		} else if(!preg_match("/^[a-zA-Z0-9]*$/", $username) || (strlen($username) < 4) || (strlen($username) > 20)) {
			$_SESSION['error'] = "invalidusername";
			$_SESSION['tmp_email'] = $email;
			$_SESSION['tmp_password'] = $password;
			$_SESSION['tmp_phoneno'] = $phoneno;
            header("Location: register.php");
			exit();

		} else if(!preg_match("/^[a-zA-Z0-9]*$/", $password) || (strlen($password) < 4) || (strlen($password) > 20)) {
			$_SESSION['error'] = "invalidpwd";
			$_SESSION['tmp_username'] = $username;
			$_SESSION['tmp_email'] = $email;
			$_SESSION['tmp_phoneno'] = $phoneno;
			header("Location: register.php");
			exit();

		} else if(!preg_match("/^01[0-9]*$/", $phoneno) || (strlen($phoneno) < 10) || (strlen($phoneno) > 11)) {
			$_SESSION['error'] = "invalidtel";
			$_SESSION['tmp_username'] = $username;
			$_SESSION['tmp_email'] = $email;
			$_SESSION['tmp_password'] = $password;
			header("Location: register.php");
			exit();

		} else {
			$sql = "SELECT * FROM user WHERE username=?";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql)) {
				$_SESSION['error'] = "sqlerror";
				header("Location: register.php");

				exit();

			} else {

				mysqli_stmt_bind_param($stmt, "s", $username);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);
				if($row = mysqli_num_rows($result) > 0) {
						$_SESSION['error'] = "nametaken";
						$_SESSION['tmp_email'] = $email;
                        $_SESSION['tmp_password'] = $password;
                        $_SESSION['tmp_phoneno'] = $phoneno;
						header("Location: register.php");

						exit();

				} else {
					$sql = "INSERT INTO user(Username, Email, Password, PhoneNo) VALUES(?, ?, ?, ?)";
					$stmt = mysqli_stmt_init($conn);

					if(!mysqli_stmt_prepare($stmt, $sql)) {
						$_SESSION['error'] = "sqlerror";
						header("Location: register.php");

						exit();

					} else {
						$hasedPassword = password_hash($password, PASSWORD_DEFAULT);
						mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hasedPassword, $phoneno);
						mysqli_stmt_execute($stmt);
						mysqli_stmt_store_result($stmt);
						$_SESSION['registration'] = "success";
						header("Location: login.php");
						exit();
					}
				}
		}
	}
	} else {

		header("Location: register.php");

		exit();

	}

 ?>