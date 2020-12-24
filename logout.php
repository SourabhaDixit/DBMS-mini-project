<?php
session_start();//starting session

if(session_destroy()) {//destroying All sessions
	header("location: login.php");//Redirecting to login page
}
?>
