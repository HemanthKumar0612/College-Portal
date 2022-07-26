<?php  
	session_start();
	if(!isset($_SESSION['student'])){
			header("Location:studentlogin.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<script type="text/javascript" src="Scripts/bootstrap.min.js"></script>
	<script type="text/javascript" src="Scripts/jquery-2.1.1.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<title></title>
</head>
<body>

	<nav class="container navbar navbar-expand-lg " style="background-color: #e3f2fd;">

				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link " aria-current="page" href="studentindex.php">Home</a>
				  </li>
				  <div class="dropdown">
					  <button type="button" class="btn  btn-primary dropdown-toggle" data-bs-toggle="dropdown">
					    Profile
					  </button>
					  <ul class="dropdown-menu">
					    <li><a class="dropdown-item" href="studentprofile.php">View Profile</a></li>
					    <li><a class="dropdown-item" href="studentedit.php">Edit Profile</a></li>
					    <li><a class="dropdown-item" href="studentchangepassword.php">Change Password</a></li>
					    
					  </ul>
					</div>
				  
				  <li class="nav-item">
				    <a href="studentresult.php" class="btn btn-outline-success" role="button">Results</a>
				  </li>
				</ul>
			<div>
				<form class="container-fluid"  method="POST">
						<button type="submit"  class="btn btn-outline-success" name="student-logout">Logout</button>
						
				</form>
			
			</div>
			</nav>
	
</body>
</html>
<?php
	if(isset($_POST['student-logout']))
	{
		session_start();
		session_unset();
		session_destroy();
		header("Location: studentlogin.php?logout=success");
	}
?>


