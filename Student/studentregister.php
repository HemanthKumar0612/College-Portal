<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<title>Student Register</title>
</head>
<body>
	<div class="d-flex align-items-center justify-content-center" >
			<div class="card border-success" style="width: 25rem;">
			  	<div class="card-header text-success text-center">
			    	Student Register
			  	</div>
			  	<div class="card-body">
			  		<form   method="POST">
					  <div class="mb-3" >
					    <label class="form-label">Registration Number</label>
					    <input type="text" class="form-control" name="student-regno" > 
					  </div>
					  <div class="mb-3" >
					    <label class="form-label">Name</label>
					    <input type="text" class="form-control" name="student-name" > 
					  </div>
					  <div class="mb-3" >
					    <label class="form-label">Email id</label>
					    <input type="text" class="form-control" name="student-email" > 
					  </div>
					  <div class="mb-3" >
					    <label class="form-label">Username</label>
					    <input type="text" class="form-control" name="student-username" > 
					  </div>
					  <div class="mb-3">
					    <label class="form-label">Password</label>
					    <input type="password" class="form-control" name="student-password"> 
					  </div>
					  <div class="mb-3">
					    <label class="form-label">Confirm Password</label>
					    <input type="password" class="form-control" name="student-password-re"> 
					  </div>
					  <a href="studentlogin.php" class="btn btn-outline-danger" role="button">Back</a>
					  <button type="submit" class="btn btn-outline-success"  name="student-register">Register</button>
					  
					</form>
			  	</div>
			  	
			  
			</div>
	</div>

	
		
		<?php 
		  	if(isset($_GET['signup'])){
		  		$status = $_GET['signup'];
		  		echo "
		  		<script>
   					alert('$status')
				</script>
				";
		  	}
		  	if(isset($_GET['error'])){
		  		$status = $_GET['error'];
		  		echo"
		  		<script>
		  			alert('$status')
		  		</script>
		  		";
		  	}
		   ?>
	
	
</body>
</html>

<?php 
	require_once 'includes/database.php';
	if(isset($_POST['student-register'])){
		
		$regno = $_POST['student-regno'];
		$name = $_POST['student-name'];
		$email = $_POST['student-email'];
		$username = $_POST['student-username'];
		$password = $_POST['student-password'];
		$re_password = $_POST['student-password-re'];


		if(empty($regno) || empty($email) ||empty($name) ||empty($re_password) || empty($password) || empty($username))
		{
			header("Location: studentregister.php?error=emptyfields");
			exit();
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			header("Location: studentregister.php?error=invalidemail");
			exit();
		}
		else if($password !== $re_password){
			header("Location: studentregister.php?error=passwordnotmatching");
			exit();
		}
		else{
			$sql = "SELECT * FROM student WHERE regno=? && name =? && emailid=?;";
			$statement=mysqli_stmt_init($connection);
			mysqli_stmt_prepare($statement,$sql);
			mysqli_stmt_bind_param($statement,"sss",$regno,$name,$email);
			mysqli_stmt_execute($statement);
			mysqli_stmt_store_result($statement);
			$rows  = mysqli_stmt_num_rows($statement);
			if($rows>0){

				$sql="UPDATE student 
				SET username= ?,password=?
				WHERE regno = ? && name = ? && emailid = ?;";
				$statement=mysqli_stmt_init($connection);
				if(!mysqli_stmt_prepare($statement,$sql)){
					header("Location: studentregister.php?error=sqlerror");
					exit();
				}
				else
				{
					$hasedpassword = password_hash($password, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($statement, "sssss",$username,$hasedpassword,$regno,$name,$email);
					if(mysqli_stmt_execute($statement)){
						header("Location: studentregister.php?signup=success");
						exit();
					}
					else{
						header("Location: studentregister.php?error=failed");
						exit();
					}
					
					
					
				}
			}
			else{
				header("Location: studentregister.php?error=wrongcredentials");
				exit();
			}
			mysqli_stmt_close($statement);
			mysqli_close($connection);
			}
	}


		

?>
