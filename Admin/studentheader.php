<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<title>Student</title>
</head>
<body>
		
		<div class="d-flex align-items-center justify-content-center" >
			<div class="card border-success" style="width: 18rem;">
			  <div class="card-header text-success text-center">
			    Student Data
			  </div>
			  <div class="card-body">
			    <form method="POST">
					<div class="mb-3" >
						<label class="form-label">Enter Reg.no</label>
					    <input type="text" class="form-control" name="regno-student" > 
					</div>
					<div class="mb-3" >
						<label class="form-label">Enter Name</label>
					    <input type="text" class="form-control" name="name-student" > 
					</div>
					<button type="submit" class="btn btn-outline-danger"  name="admin-back">Back</button>
					<button type="submit" class="btn btn-outline-success"  name="select-student">Confirm</button>
				</form>
			  </div>
			  
			</div>
		</div>
		
</body>
</html>