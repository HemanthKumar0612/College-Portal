<?php  
	session_start();
	require_once 'includes/database.php';
	$username = $_SESSION['student'];
	if(empty($username)){
		header('Location: studentlogin.php');
		exit();
	}
	$sql = "SELECT name,regno,course,gender,mobile,dob,aadhaar,emailid,year 
	FROM student WHERE username =?; ";
	$statement = mysqli_stmt_init($connection);
	if(!mysqli_stmt_prepare($statement,$sql)){
		header("Location: studentindex.php?error=sqlerror1");
				exit();
	}
	else{
		mysqli_stmt_bind_param($statement,"s",$username);
		mysqli_stmt_execute($statement);
		mysqli_stmt_store_result($statement);
		mysqli_stmt_bind_result($statement,$name,$regno,$course,$gender,$mobile,$dob,$aadhaar,$emailid,$year);
		if(mysqli_stmt_fetch($statement)){
			echo "
				<html>
					<head>
						<meta charset='utf-8'>
						<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>
						
						<title>Student Login</title>
					</head>
					<body>
						<div class='d-flex align-items-center justify-content-center' >
							<div class='card border-success' style='width: 30rem;'>
								<div class='card-header text-success text-center'>
								Student Portal
								</div>
								<div class='card-body'>
									<table class ='table table-bordered '>
							  			<tbody>
										    <tr>
										      <td>Name</td>
										      <td>$name</td>
										    </tr>
										    <tr>
										      <td>Course</td>
										      <td>$course</td>
										    </tr>
										    <tr>
										      <td>Reg.No</td>
										      <td>$regno</td>
										    </tr>
										    <tr>
										      <td>Mobile</td>
										      <td>$mobile</td>
										    </tr>
										    <tr>
										      <td>Gender</td>
										      <td>$gender</td>
										    </tr>
										    <tr>
										      <td>Email</td>
										      <td>$emailid</td>
										    </tr>
										    <tr>
										      <td>Aadhaar no</td>
										      <td>$aadhaar</td>
										    </tr>
										    <tr>
										      <td>Date of Birth</td>
										      <td>$dob</td>
										    </tr>
							            </tbody>
							        </table>
							        <div class = 'd-flex align-items-center justify-content-center'>
							        	<form method='POST'>
									        <div class='d-grid gap-6 d-md-block'>
									        	<button type='submit' class='btn btn-outline-success' name='student-back'>Back</button>
											</div>
										</form>		
							        </div>   
								</div>
							</div>
						</div>

							
					</body>
			";
			
					  
			
		}
		else{
			header("Location: studentindex.php?error=sqlerror2&",$username);
				exit();
		}
	}
	if(isset($_POST['student-back'])){
		header('Location: studentindex.php');
		exit();
	}
?>

