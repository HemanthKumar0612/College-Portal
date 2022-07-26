<?php 
	require "../studentheader.php";
	if (!isset($_SESSION['admin'])){
		header('Location: ../adminlogin.php?error=nouserloginfound');
		exit();
	}
?>

<?php  
	if(isset($_POST['admin-back'])){
		header('Location: ../adminindex.php');
		exit();
	}
	if(isset($_POST['select-student'])){
		require_once '../database.php';

		$regno =$_POST['regno-student'];
		$name = $_POST['name-student'];
		if(empty($regno) || empty($name)){
			header('Location: viewstudent.php?error=emptyfields');
			exit();
		}
		$sql = "SELECT course,gender,mobile,dob,aadhaar,emailid,year 
				FROM student 
				WHERE regno =? AND name=?; ";
		$statement = mysqli_stmt_init($connection);
		mysqli_stmt_prepare($statement,$sql);		
		mysqli_stmt_bind_param($statement,"ss",$regno,$name);
		mysqli_stmt_execute($statement);
		mysqli_stmt_store_result($statement);
		mysqli_stmt_bind_result($statement,$course,$gender,$mobile,$dob,$aadhaar,$emailid,$year);
		if(mysqli_stmt_fetch($statement)){
			echo "
				<html>
					<head>
						<meta charset='utf-8'>
						<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>
						
						<title>View Student</title>
					</head>
					<body>
						<div class='d-flex align-items-center justify-content-center' >
							<div class='card border-success' style='width: 30rem;''>
							  	<div class='card-header text-success text-center'>
							    	Admin Portal
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
					        		<a href='viewstudent.php' class='btn btn-outline-danger' role='button'>Back</a>	</div>
					            </div>
					        </div>
						</div>
		
							
							
							
					        
					</body>
			";
					  
			
		}
		else{
			header("Location: viewstudent.php?error=nostudentfound");
			exit();
		}
		mysqli_stmt_close($statement);
		mysqli_close($connection);

	}
	
	
?>

