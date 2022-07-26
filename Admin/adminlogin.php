
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	
	<title>Admin Login</title>
</head>
<body>
	
		<div class="d-flex align-items-center justify-content-center" >
			<div class="card border-success" style="width: 25rem;">
			  <div class="card-header text-success text-center">
			    Admin Portal
			  </div>
			  <div class="card-body">
			    <form  method="POST">
				  <div class="mb-3" >
				    <label class="form-label">Username</label>
				    <input type="text" class="form-control" name="adminusername" > 
				  </div>
				  
				  <div class="mb-3">
				    <label class="form-label">Password</label>
				    <input type="password" class="form-control" name="adminpassword"> 
				  </div>
				  <button type="submit" class="btn btn-outline-success "  name="admin-login">Login</button>
				  <a href="adminsignup.php" class="btn btn-outline-success" role="button" >Signup</a>
				  
				</form>
				<?php
					if(isset($_GET['logout'])){
						$status=$_GET['logout'];
						echo "
						  		<script>
				   					alert('$status')
								</script>
						";
						
					}
					if(isset($_GET['error'])){
						$status=$_GET['error'];
						echo "
						  		<script>
				   					alert('$status')
								</script>
						";

					}
				?>
			  	</div>
			  	<div class="card-footer">
			  		<a href="../home.php" >Home</a>
			  		<a href="forgetpassword.php" >Forget Password</a>
			  	</div>
			</div>
		</div>

	
</body>
</html>

<?php
	require_once 'database.php';
	

	if(isset($_POST['admin-login'])){
		
		$user=$_POST['adminusername'];
		$password=$_POST['adminpassword'];
		if(empty($user) || empty($password)){
			header("Location: adminlogin.php?error=emptyfields");
			exit();
		}
		else{
			$sql="SELECT username,password FROM admin WHERE username=? OR empid=?;";
			$statement=mysqli_stmt_init($connection);
			if(!mysqli_stmt_prepare($statement,$sql)){
				header("Location: adminlogin.php?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($statement,"ss",$user,$user);
				mysqli_stmt_execute($statement);
				// code fixing starts here
				mysqli_stmt_store_result($statement);
				mysqli_stmt_bind_result($statement,$u,$p);
					
					
					if( mysqli_stmt_fetch($statement) && $user == $u) {
						echo "user found ";
						$pwdcheck = password_verify($password,$p);
						if($pwdcheck == false){
							header("Location: adminlogin.php?error=wrongpwd");
							exit();
						}
						else if($pwdcheck == true){
							session_start();
							
							$_SESSION['admin']=$u;
							header("Location: adminindex.php?login=success");
							exit();

						}
						else{
							header("Location: adminlogin.php?error=wrongpwd");
							exit();
						}
					}

					else{
						header("Location: adminlogin.php?error=nouser");
						exit();
					}
					
			}
		}
		mysqli_stmt_close($statement);
		mysqli_close($connection);


	}

