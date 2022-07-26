
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<title>Admin Signup</title>
</head>
<body>
	<div class="d-flex align-items-center justify-content-center" >
			<div class="card border-success" style="width: 25rem;">
			  	<div class="card-header text-success text-center">
			    	Admin Signup
			  	</div>
			  	<div class="card-body">
			  		<form   method="POST">
					  <div class="mb-3" >
					    <label class="form-label">Name</label>
					    <input type="text" class="form-control" name="adminname" > 
					  </div>
					  <div class="mb-3" >
					    <label class="form-label">Employee Id</label>
					    <input type="text" class="form-control" name="adminempid" > 
					  </div>
					  <div class="mb-3" >
					    <label class="form-label">Aadhhar no</label>
					    <input type="text" class="form-control" name="adminaadhaar" > 
					  </div>
					  <div class="mb-3" >
					    <label class="form-label">Email id</label>
					    <input type="text" class="form-control" name="adminemail" > 
					  </div>
					  <div class="mb-3" >
					    <label class="form-label">Username</label>
					    <input type="text" class="form-control" name="adminusername" > 
					  </div>
					  <div class="mb-3">
					    <label class="form-label">Password</label>
					    <input type="password" class="form-control" name="adminpassword"> 
					  </div>
					  <div class="mb-3">
					    <label class="form-label">Confirm Password</label>
					    <input type="password" class="form-control" name="adminpassword-re"> 
					  </div>
					  <button type="submit" class="btn btn-outline-danger"  name="admin-login-back">Back</button>
					  <button type="submit" class="btn btn-outline-success"  name="admin-signup">Signup</button>
					  
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
	require_once 'database.php';
	if(isset($_POST['admin-login-back'])){
		header('Location: adminlogin.php');
		exit();
	}
	if(isset($_POST['admin-signup'])){
		
		$name=$_POST['adminname'];

		$empid=$_POST['adminempid'];

		$aadhaar=$_POST['adminaadhaar'];

		$email=$_POST['adminemail'];

		$username=$_POST['adminusername'];

		$password=$_POST['adminpassword'];
		
		$re_password=$_POST['adminpassword-re'];





		if(empty($username) || empty($email) ||empty($password) ||empty($re_password) || empty($name) || empty($empid)|| empty($aadhaar))
		{
			header("Location: adminsignup.php?error=emptyfields");
			exit();
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			header("Location: adminsignup.php?error=invalidemail");
			exit();
		}
		else if($password !== $re_password){
			header("Location: adminsignup.php?error=passwordnotmatching");
			exit();
		}
		else{
			$sql="SELECT * FROM admin WHERE username = ? ";
			$statement=mysqli_stmt_init($connection);
			if(!mysqli_stmt_prepare($statement,$sql)){
				header("Location: adminsignup.php?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($statement, "s" ,$username);
				mysqli_stmt_execute($statement);
				mysqli_stmt_store_result($statement);
				$resultrows=mysqli_stmt_num_rows($statement);
				if($resultrows > 0){
					header("Location: adminsignup.php?error=usertaken");
					exit();
				}
				else{
					$sql="INSERT INTO admin(username,password,name,empid,aadhaar,emailid) VALUES (?,?,?,?,?,?) " ;
					$statement=mysqli_stmt_init($connection);
					if(!mysqli_stmt_prepare($statement,$sql)){
						header("Location: adminsignup.php?error=sqlerror");
						exit();
					}
					else{

						$hasedpassword=password_hash($password, PASSWORD_DEFAULT);
						mysqli_stmt_bind_param($statement, "ssssss" ,$username,$hasedpassword,$name,$empid,$aadhaar,$email);
						mysqli_stmt_execute($statement);
						header("Location: adminsignup.php?signup=success");
						exit();

					}
				}
			}

		}
		mysqli_stmt_close($statement);
		mysqli_close($connection);

}


