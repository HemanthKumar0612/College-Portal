<?php
	session_start();
	if(!isset($_SESSION['token']) || !isset($_SESSION['email']) ){
		header('Location: adminlogin.php?error=nortokenavailable');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<title></title>
</head>
<body>
	<div class="d-flex align-items-center justify-content-center" >
		<div class="card border-success" style="width: 25rem;">
			<div class="card-header text-success text-center">
			    Reset Password
			</div>
			<div class="card-body">
			    <form  method="POST">
				  	<div class="mb-3" >
				    	<label class="form-label">Token</label>
				    	<input type="text" class="form-control" name="reset-password-token" > 
				  	</div>
				  	<div class="mb-3" >
				    	<label class="form-label">New Password</label>
				    	<input type="text" class="form-control" name="reset-password-newpassword" > 
				  	</div>
				  	<div class="mb-3" >
				    	<label class="form-label">Confirm Password</label>
				    	<input type="text" class="form-control" name="reset-password-confirmpassword" > 
				  	</div>
				  	<button type="submit" class="btn btn-outline-danger "  name="admin-back">Back</button>
				  	<button type="submit" class="btn btn-outline-success "  name="reset-password">Confirm change</button>
				</form>
			</div>
		</div>
	</div>

</body>
</html>
<?php
	
	require_once 'database.php';
	if(isset($_POST['admin-back'])){
		unset($_SESSION['token']);
		unset($_SESSION['email']);
		header('Location: adminlogin.php');
		exit();
	}
	else if(isset($_POST['reset-password'])){
		$email = $_SESSION['email'];
		$token = $_SESSION['token'];
		$newpassword = mysqli_real_escape_string($connection,$_POST['reset-password-newpassword']);
		$repassword = mysqli_real_escape_string($connection,$_POST['reset-password-confirmpassword']);

		if(empty($token) || empty($newpassword) || empty($repassword)){
			header('Location: adminresetpassword.php?error=emptyfields');
			exit();
		}
		else if($token != $_SESSION['token']){
			header('Location: adminlogin.php?error=invalidtoken');
			exit();
		}
		else if($newpassword != $repassword){
			header('Location: adminresetpassword.php?error=confirmpassword');
			exit();
		}
		else{
			$sql = "SELECT password FROM admin WHERE emailid=?;";
			$statement = mysqli_stmt_init($connection);
			mysqli_stmt_prepare($statement,$sql);
			mysqli_stmt_bind_param($statement,"s",$email);
			mysqli_stmt_execute($statement);
			mysqli_stmt_store_result($statement);
			mysqli_stmt_bind_result($statement,$p);
			if(mysqli_stmt_fetch($statement)){
				$pwdcheck = password_verify($newpassword,$p);
				if($pwdcheck == true){
					header('Location: adminresetpassword.php?error=oldpassword');
					exit();
				}
				else{
					$sql = "UPDATE admin SET password=? WHERE emailid=?;";
					$statement = mysqli_stmt_init($connection);
					mysqli_stmt_prepare($statement,$sql);
					$hasedpassword=password_hash($newpassword, PASSWORD_DEFAULT);
					mysqli_stmt_bind_param($statement,"ss",$hasedpassword,$email);
					if(mysqli_stmt_execute($statement)){
						unset($_SESSION['token']);
						unset($_SESSION['email']);
						header('Location: adminlogin.php?reset=successful');
						exit();
						
		
					}
					else{
						header('Location: adminresetpassword.php?reset=fail2');
						exit();
					}
					
				}	
			}
			else{
				header('Location: adminlogin.php');
				exit();
			}
				
		}
	}
?>
