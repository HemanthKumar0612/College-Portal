<?php
	session_start();
	session_unset();
	session_destroy();
	echo "<script>alert('You are logged out');</script>";
	header("Location: ../studentindex.php");
?>