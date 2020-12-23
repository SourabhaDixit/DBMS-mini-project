<?php
session_start();//starting session

//if session exit,user neither need to sign nor need to signup
if(isset($_SESSION['login_id'])) {
	if(isset($_SESSION['pageStore'])){
		$pagestore=$_SESSION['pageStore'];
		header("location:$pageStore");//redirecting to profile page
    }
}

//Login procress start, if user press the signin button
if(isset($_POST['signIn'])) {
	if(empty($_POST['email']) || empty($_POST['password'])){
		echo "Username and passoord should not be empty";
	}
	else{
		$email = $_POST['email'];
		$password = $_POST['password'];

		//Make a connection with MYSOL server
		include('config.php');

		$sQuery = "SELECT id, password from account where email=? LIMIT 1";

		//To protect fron MYSQL injection foe a security purpose
		$stmt = $conn->prepare($sQuery);
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->bind_result($id, $hash);
		$stmt->store_result();

		if($stmt->fetch()){
			if(password_verify($password, $hash)){
				$_SESSION['login_id'] = $id;

				if(isset($_SESSION['pageStore'])){
					$pageStore = $_SESSION['pagestore'];
				}
				else{
					$pageStore = "index.php";
				}
				header("location: $pageStore");//Redirecting to profile page
				$stmt->close();
				$conn->close();
			}
			else{
				echo "Invalid Username and Password";
			}
		}
		else {
			echo "Invalid Username and Password";
		}
		$stmt->close();
		$conn->close();

		}  
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=`1">
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="rlform.css">
</head>
<body>
	<div class="rlform">
		<div class="rlform rlform-wrapper">
			<div class="rlform-box">
				<div class="rlform-box-inner">
					<form method="post">
						<p>Signin to Continue</p>

						<div class="rlform-group">
							<label>Email</label>
							<input type="email" name="email" class="rlform-input" required>
						</div>
						<div class="rlform-group">
							<label>Password</label>
							<input type="password" name="password" class="rlform-input" required>
						</div>
						
						<button type="submit" class="rlform-btn" name="signIn">Sign In</button>
						<div class="r\text-foot">
							Dont have an account? <a href="register.php">Register</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
