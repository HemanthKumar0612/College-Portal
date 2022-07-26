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
			    Change Password
			</div>
			<div class="card-body">
			    <form  method="POST">
				  	<div class="mb-3" >
				    	<label class="form-label">Old Password</label>
				    	<input type="text" class="form-control" name="change-password-oldpassword" > 
				  	</div>
				  	<div class="mb-3" >
				    	<label class="form-label">Email Id</label>
				    	<input type="text" class="form-control" name="change-password-email" > 
				  	</div>
				  	<a href="../adminindex.php" class="btn btn-outline-success" role="button">Back</a>
				  	<button type="submit" class="btn btn-outline-success "  name="change-password">Send Link</button>
				</form>
			</div>
		</div>
	</div>


</body>
</html>
<?php
	function resetpasswordmail($email,$token){
		require_once '../../PHPMailer/PHPMailerAutoload.php';

		$mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->isHTML();
		$mail->Username = 'hksecondary1@gmail.com';
		$mail->Password = 'qyggnggqqfisqzvk';
		$mail->SetFrom('no-reply@hk.org');
		$mail->Subject = 'Hello World';
		$msg=
			"<div>
				<h1>Reset Password</h1>
				<p>Use the below Link to reset your password </p>
				<a href='http://localhost/Student%20database%20Management%20system/Admin/adminresetpassword.php'>Reset Link</a>
				<p>One Time Token :</p>

			</div>".$token;
		$mail->Body = $msg;
		$mail->AddAddress($email);

		if($mail->Send())
			return 1;
		else
			return 0;
	}

	if(isset($_POST['change-password'])){
		require_once '../database.php';
		$email = mysqli_real_escape_string($connection,$_POST['change-password-email']);
		$password = mysqli_real_escape_string($connection,$_POST['change-password-oldpassword']);
		$sql = "SELECT password FROM admin WHERE emailid=?;";
		$statement=mysqli_stmt_init($connection);
		mysqli_stmt_prepare($statement,$sql);
		mysqli_stmt_bind_param($statement,"s",$email);
		mysqli_stmt_execute($statement);
		mysqli_stmt_store_result($statement);
		mysqli_stmt_bind_result($statement,$p);
		if(mysqli_stmt_fetch($statement)){
			$pwdcheck = password_verify($password,$p);
			if($pwdcheck == false){
				header("Location: changepassword.php?error=wrongpwd");
				exit();
			}
			$token = openssl_random_pseudo_bytes(10);
			$token = bin2hex($token);
			session_start();
			$_SESSION['token']=$token;
			$_SESSION['email']=$email;
			if(resetpasswordmail($email,$token)){
				echo "Reset Mail sent";
			}
			else{
				echo "Mail not sent";
			}
		}
		else{
			header('Location: changepassword.php?error=usernotfound');
			exit();
		}

	}
	
?>