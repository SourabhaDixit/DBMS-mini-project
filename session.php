<?php
//Make a connection with database
include("config.php");

session_start();//Start session

if(isset($_SESSION['login_id'])) {
	$user_id = $_SESSION['login_id'];

	$sQuery = "SELECT fullName from account where id= ? LIMIT 1";

	//To protect from MySQl injection
	$stmt = $conn->prepare($sQuery);
	$stmt->bind_param("i", $user_id);
	$stmt->execute();
	$stmt->bind_result($fullName);
	$stmt->store_result();

	if($stmt->fetch()) //fetching the content of the row
	{
		$session_fullName = $fullName;
		$stmt->close();
		$conn->close();
	}
}
?>

