<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<title>Student Data Portal</title>
</head>
<body>
	<div class="d-flex align-items-center justify-content-center">
		<div >
			<center><h3 style="font-family:verdana;">Welcome to Student Portal</h3></center>
			<div class="d-grid gap-2 col-6 mx-auto">
				<form action="Student/studentlogin.php" method="POST">
					<button type="submit" class="btn btn-outline-success" name="student-portal-submit">Student Login</button>
				</form>
				<form action="Admin/adminlogin.php" method="POST"> 	
					<button type="submit" class="btn btn-outline-success" name="admin-portal-submit">Admin Login</button>
				</form>
			</div>
			
		</div>
	</div>

	
</body>
</html>