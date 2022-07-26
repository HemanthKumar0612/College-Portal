<?php  
	require "../adminheader.php";
?>
<?php
	if (!isset($_SESSION['admin'])){
		header('Location: ../adminlogin.php?error=nouserloginfound');
		exit();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<title>Profile</title>
</head>
<body>
</body>
</html>
<?php
		require_once '../database.php';

		$username=$_SESSION['admin'];
		$sql = "SELECT name,empid,aadhaar,emailid
				FROM admin 
				WHERE username=?";
		$statement = mysqli_stmt_init($connection);
		mysqli_stmt_prepare($statement,$sql);
		mysqli_stmt_bind_param($statement,"s",$username);
		mysqli_stmt_execute($statement);
		mysqli_stmt_store_result($statement);
		mysqli_stmt_bind_result($statement,$name,$empid,$aadhaar,$emailid);
		
		if(mysqli_stmt_fetch($statement)){
				
				echo "
					<html>
						<head>
							<meta charset='utf-8'>
							<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>
							<script src='https://code.jquery.com/jquery-1.12.4.js'></script>
							<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
							<title>Edit Student</title>
						</head>
						<body>
							<div class='d-flex align-items-center justify-content-center' >
								<div class='card border-success' style='width: 30rem;''>
									  <div class='card-header text-success text-center'>
									    Admin Portal
									  </div>
									  <div class='card-body'>
									   	<form method='POST'>
									<table class ='table table-bordered'>
							  			<tbody>

										    <tr>
										      <td><label class='form-label'>Name</label></td>
										      <td><input type='text' class='form-control' name='admin-editname' value ='$name'> </td>
										    </tr>
										    <tr>
										      <td><label class='form-label'>Username</label></td>
										      <td><input type='text' class='form-control' name='admin-editusername' value ='$username'> </td>
										    </tr>
										    <tr>
										      <td><label class='form-label'>Employee Id</label></td>
										      <td><input type='text' class='form-control' name='admin-editempid' value ='$empid'> </td>
										    </tr>
										    <tr>
										      <td><label class='form-label'>Aadhaar No</label></td>
										      <td><input type='text' class='form-control' name='admin-editaadhaar' value ='$aadhaar'> </td>
										    </tr>
										    <tr>
										      <td><label class='form-label'>Email ID</label></td>
										      <td><input type='text' class='form-control' name='admin-editemailid' value ='$emailid'> </td>
										    </tr>
										    
										    
							            </tbody>
					            	</table>
								  	<div class='d-grid gap-6 d-md-block'>
							        	<button type='submit' class='btn btn-outline-success' name='admin-profileback'>Back</button>
										<button type='submit' class='btn btn-outline-danger' name='admin-profileedit'>Confirm Edit</button>
									</div>
								</form>
									  </div>
									  
								</div>
							</div>
						</body>	
				";

			}		
			else{
				header('Location: adminprofile.php?error=something');
				exit();
			}
			// control



			if(isset($_POST['admin-profileback'])){
				header('Location: ../adminindex.php');
				exit();
			}
			if(isset($_POST['admin-profileedit'])){
				require_once '../database.php';
				
				$username=$_SESSION['admin'];
				
				$newusername=$_POST['admin-editusername'];
				$name=$_POST['admin-editname'];
				$empid=$_POST['admin-editempid'];
				$emailid=$_POST['admin-editemailid'];
				$aadhaar=$_POST['admin-editaadhaar'];
				
				$sql =  "UPDATE admin 
						SET username=?,name=?,empid=?,emailid=?,aadhaar=?
						WHERE username=?;
						";
				$statement = mysqli_stmt_init($connection);
				if(!mysqli_stmt_prepare($statement,$sql)){
					header('Location: adminprofile.php?edit=failprep');
					exit();
				}
				mysqli_stmt_bind_param($statement,'ssssss',$newusername,$name,$empid,$emailid,$aadhaar,$username);		
				if(mysqli_stmt_execute($statement)){
					$_SESSION['admin']=$newusername;
					header('Location: adminprofile.php?edit=success');
					exit();
				}
				else{
					header('Location: adminprofile.php?edit=notsuccess');
					exit();
				}
			}
			
			//control	


?>
	
    

