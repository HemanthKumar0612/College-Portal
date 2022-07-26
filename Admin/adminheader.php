<?php  
	session_start();
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
	<?php
		if(!isset($_SESSION['admin'])){
			header("Location:adminlogin.php");
		}
	  ?>

	
			<nav class="container navbar navbar-expand-lg " style="background-color: #e3f2fd;">

				<ul class="nav nav-tabs">
				  <li class="nav-item">
				    <a class="nav-link " aria-current="page" href="http://localhost/Student%20database%20Management%20system/Admin/adminindex.php">Home</a>
				  </li>

				  <div class="dropdown">
					  <button type="button" class="btn  btn-primary dropdown-toggle" data-bs-toggle="dropdown">
					    Profile
					  </button>
					  <ul class="dropdown-menu">
					    <li><a class="dropdown-item" href="adminprofile/adminprofile.php">View Profile</a></li>
					    <li><a class="dropdown-item" href="adminprofile/changepassword.php">Change Password</a></li>
					    
					  </ul>
					</div>
				  
				  <div class="dropdown">
					  <button type="button" class="btn  btn-primary dropdown-toggle" data-bs-toggle="dropdown">
					    Student
					  </button>
					  <ul class="dropdown-menu">
					    <li><a class="dropdown-item" href="add/addstudent.php">Add Student</a></li>
					    <li><a class="dropdown-item" href="view/viewstudent.php">View Student</a></li>
					    <li><a class="dropdown-item" href="edit/editstudent.php">Edit Student</a></li>
					    <li><a class="dropdown-item" href="delete/deletestudent.php">Delete Student</a></li>
					  </ul>
					</div>

				  <li class="nav-item">
				    <a href="studentprogress/studentprogress.php" class="btn btn-outline-primary" role="button" >Progress</a>
				  </li>
				</ul>
			<div>
				<form class="container-fluid"  method="POST">
						<button type="submit" class="btn btn-sm btn-outline-success"  name="admin-logout">Logout</button>
						
				</form>
			
			</div>
			</nav>
	
</body>
</html>


