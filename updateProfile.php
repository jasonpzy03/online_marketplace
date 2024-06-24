<?php 

	if(isset($_POST['update-profile-submit'])) {

		require 'dbconnect.php';
		session_start();
		$username = $_POST['username'];
		$email = $_POST['email'];
		$phoneno = $_POST['phone'];
		$password = $_POST['pwd'];
		$passwordConfirmed = $_POST['confirm-pwd'];

		if(empty($username) || empty($email) || empty($password) || empty($passwordConfirmed)|| empty($phoneno)) {
			$_SESSION['error'] = "emptyfields";
			$_SESSION['tmp_uid'] = $username;
			$_SESSION['tmp_mail'] = $email;
			$_SESSION['tmp_name'] = $realname;
			$_SESSION['tmp_noic'] = $identitycard;
			$_SESSION['tmp_notel'] = $phoneno;
			header("Location: profile.php");
			
			exit();

		} else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$_SESSION['error'] = "invalidmail";
			$_SESSION['tmp_username'] = $username;
			$_SESSION['tmp_password'] = $password;
			$_SESSION['tmp_phoneno'] = $phoneno;
			header("Location: profile.php");
			exit();

		} else if(!preg_match("/^[a-zA-Z0-9]*$/", $username) || (strlen($username) < 4) || (strlen($username) > 20)) {
			$_SESSION['error'] = "invalidusername";
			$_SESSION['tmp_email'] = $email;
			$_SESSION['tmp_password'] = $password;
			$_SESSION['tmp_phoneno'] = $phoneno;
            header("Location: profile.php");
			exit();

		} else if(!preg_match("/^[a-zA-Z0-9]*$/", $password) || (strlen($password) < 4) || (strlen($password) > 20)) {
			$_SESSION['error'] = "invalidpwd";
			$_SESSION['tmp_username'] = $username;
			$_SESSION['tmp_email'] = $email;
			$_SESSION['tmp_phoneno'] = $phoneno;
			header("Location: profile.php");
			exit();

		} else if(!preg_match("/^01[0-9]*$/", $phoneno) || (strlen($phoneno) < 10) || (strlen($phoneno) > 11)) {
			$_SESSION['error'] = "invalidtel";
			$_SESSION['tmp_username'] = $username;
			$_SESSION['tmp_email'] = $email;
			$_SESSION['tmp_password'] = $password;
			header("Location: profile.php");
			exit();

		} else if($password !== $passwordConfirmed) {
			$_SESSION['error'] = "passwordCheck";
			header("Location: profile.php");
			exit();

		} else {

			$sql = "SELECT Username, Email FROM user WHERE Username=? OR Email = ?";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql)) {

				$_SESSION['error'] = "sqlerror";
				header("Location: profile.php");

				exit();

			} else {

				mysqli_stmt_bind_param($stmt, "ss", $username, $email);
				mysqli_stmt_execute($stmt);
				
				$result = mysqli_stmt_get_result($stmt);
				while($row = mysqli_fetch_assoc($result)) {
                    $u = $row['Username'];
                    $e = $row['Email'];

                    if($u == $username) {
                        if($_SESSION['userUid'] != $u) {
                            $_SESSION['error'] = "usertaken";
                            header("Location: profile.php?error=usertaken");

                            exit();
                        }

                    } 
                    if($e == $email) {
                        if($_SESSION['mail'] != $e) {
                            $_SESSION['error'] = "emailtaken";
                            header("Location: profile.php?error=emailtaken");

                            exit();
                        } 
                        
                    } 
				}
				
					$hashedPwd = password_hash($password, PASSWORD_DEFAULT);
					$sql2 = "UPDATE user SET Username = ?, Email = ?, Password = ?,  PhoneNo = ? WHERE UserID = ?";
					$stmt2 = mysqli_stmt_init($conn);

					if(!mysqli_stmt_prepare($stmt2, $sql2)) {

						$_SESSION['error'] = "sqlerror";
						header("Location: profile.php");

						exit();
 
					} else {
						mysqli_stmt_bind_param($stmt2, "ssssi", $username, $email, $hashedPwd, $phoneno, $_SESSION['UserID']);
						mysqli_stmt_execute($stmt2);
						
						$_SESSION['userUid'] = $username;
						$_SESSION['mail'] = $email;
						setcookie("uid", $_SESSION['userUid'], time() + 86400);

						
                        $_SESSION['update'] = "success";
                        header("Location: profile.php?update=success");
                        exit();
			
					}
	
			}

		} 

		mysqli_stmt_close($stmt);
		mysqli_close($conn);
	} else {

		header("Location: profile.php");

		exit();
	}
 ?>