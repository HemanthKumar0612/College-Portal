<?php
	require "studentheader.php";
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
				if (isset($_SESSION['student'])) {
					
					echo "<h1>Welcome to Student Portal</h1>";
					
				}
				else{
					
					echo "<h1>You are logged out</h1>";
				}
			?>
			
		
	</div>
</body>
</html>
