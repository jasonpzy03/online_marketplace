<?php 

	if(isset($_POST['login-submit'])) {

		require 'dbconnect.php';
		session_start();
		$mailuid = $_POST['mailuid'];
		$password = $_POST['password'];

		if(empty($mailuid) || empty($password)) {

			$_SESSION['error'] = "emptyfields";
			$_SESSION['tmp_uid'] = $email;
			header("Location: login.php?error=emptyfields");

			exit();

		} else {

			$sql = "SELECT * FROM user WHERE BINARY Username=? OR Email=?";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $sql)) {
				$_SESSION['error'] = "sqlerror";
				header("Location: login.php?error=sqlerror");

				exit();

			} else {

				mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
				mysqli_stmt_execute($stmt);
				$result = mysqli_stmt_get_result($stmt);

				if($row = mysqli_fetch_assoc($result)) {
                    
					$pwdCheck = password_verify($password, $row['Password']);

					if($pwdCheck == false) {
						$_SESSION['error'] = "wronginfo";
						echo "<script>console.log('Debug Objects: " . $password . "' );</script>";
						echo "<script>console.log('Debug Objects: " . $row['Password'] . "' );</script>";
						echo "<script>console.log('Debug Objects: " . password_verify($password, $row['Password']) . "' );</script>";
						

					} else if($pwdCheck == true) {

						setcookie("uid", $row['Username'], time() + 86400);
						$_SESSION['id'] = session_id();
						// $_SESSION['pic'] = $row['ProfilePicture'];
						$_SESSION['UserID'] = $row['UserID'];
						// $_SESSION['NoTel'] = $row['NoTel'];
						// $_SESSION['name'] = $row['Nama'];
						// $_SESSION['NoIC'] = $row['NoKP'];
						// $_SESSION['userUid'] = $row['Username'];
						// $_SESSION['mail'] = $row['Emel'];
						header("Location: index.php?login=success");
						exit();

					}

				} else {
                    
					$_SESSION['error'] = "wronginfo";
				    header("Location: login.php?error=wronginfo");
					exit();
                    
				}
			}
		}

	} else {

		header("Location: login.php");

		exit();

	}

 ?>