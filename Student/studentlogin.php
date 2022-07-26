
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	
	<title>Student Login</title>
</head>
<body>
	<div class="d-flex align-items-center justify-content-center" >
		<div class="card border-success" style="width: 25rem;">
			<div class="card-header text-success text-center">
			Student Portal
			</div>
			<div class="card-body">
			    <form  method="POST">
				  	<div class="mb-3" >
				    	<label class="form-label">Username</label>
				    	<input type="text" class="form-control" name="student-login-username" > 
				  	</div>
				  
				  	<div class="mb-3">
				    	<label class="form-label">Password</label>
				    	<input type="password" class="form-control" name="student-login-password"> 
				  	</div>
				  	
				  	<button type="submit" class="btn btn-outline-success "  name="student-login">Login</button>
				  	<a href="studentregister.php" class="btn btn-outline-success" role="button" >Register</a>
				  	
				</form>
			</div>
			<div class="card-footer">
				<a href="../home.php">Home</a>
			 	<a href="forgetpassword.php" >Forget Password</a>
			</div>
		</div>
	</div>
</body>
</html>
<?php
	if(isset($_GET['error'])){
		$status = $_GET['error'];
		echo "<script>alert('$status')</script>";		
	}
?>
<?php
	require_once 'includes/database.php';
	if(isset($_POST['student-login'])){

		$username=$_POST['student-login-username'];
		$password=$_POST['student-login-password'];
		if(empty($username) || empty($password)){
			header("Location: studentlogin.php?error=emptyfields");
			exit();
		}
		else{
			$sql="SELECT regno,password FROM student WHERE username=? ";
			$statement=mysqli_stmt_init($connection);
			if(!mysqli_stmt_prepare($statement,$sql)){
				header("Location: studentlogin.php?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($statement,"s",$username);
				mysqli_stmt_execute($statement);
				// code fixing starts here
				mysqli_stmt_store_result($statement);
				mysqli_stmt_bind_result($statement,$regno,$p);
					
					
					if( mysqli_stmt_fetch($statement)) {
						
						$pwdcheck = password_verify($password,$p);
						if($pwdcheck == false){
							header("Location: studentlogin.php?error=wrongpwd");
							exit();
						}
						else if($pwdcheck == true){
							session_start();
							
							$_SESSION['student']=$username;
							$_SESSION['student-regno']=$regno;
							header("Location: studentindex.php?login=success");
							exit();

						}
						else{
							header("Location: studentlogin.php?error=wrongpwd");
							exit();
						}
					}

					else{
						header("Location: studentlogin.php?error=nouser");
						exit();
					}
					
			}
		}
	}

