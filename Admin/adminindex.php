<?php
	require "adminheader.php";

?>
<?php
	
	if(isset($_GET['login'])){
		$status=$_GET['login'];
		echo "
		  		<script>
   					alert('$status')
				</script>
		";
		
	}

	if(!isset($_SESSION['admin'])){
		header('Location: adminlogin.php?error=nouserloginfound');
		exit();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home page</title>
</head>
<body>
	<div class="h-100 d-flex align-items-center justify-content-center">
		
			<?php
				if (isset($_SESSION['admin'])) {
					
					echo "<h1>Welcome to Admin Portal</h1>";
					
				}
				else{
					
					echo "<h1>You are logged out</h1>";
				}
			?>
			
			
		
	</div>
</body>
</html>
<?php
	if(isset($_POST['admin-logout'])){
		session_start();
		session_unset();
		session_destroy();
		header("Location: adminlogin.php?logout=success");
	}
?>	