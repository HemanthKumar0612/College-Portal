<?php
	require_once 'includes/database.php';
	session_start();
	if(!isset($_SESSION['student'])){
			header("Location:studentlogin.php");
	}
		$username = $_SESSION['student'];
		
		$sql = "SELECT name,regno,course,gender,mobile,dob,aadhaar,emailid,year 
		FROM student WHERE username =?; ";
		$statement = mysqli_stmt_init($connection);
		if(!mysqli_stmt_prepare($statement,$sql)){
			header("Location: studentedit.php?error=sqlerror1");
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
							<script src='https://code.jquery.com/jquery-1.12.4.js'></script>
							<script src='https://code.jquery.com/ui/1.12.1/jquery-ui.js'></script>
							<title>Student Profile Edit</title>
						</head>
						<body>
							<div class='d-flex align-items-center justify-content-center' >
								<div class='card border-success' style='width: 35rem;'>
									<div class='card-header text-success text-center'>
									Student Portal
									</div>
									<div class='card-body'>
										<form method='POST'>
											<table class ='table table-bordered '>
									  			<tbody>
									  				<tr>
												      <td><label class='form-label'>Username</label></td>
												      <td><input type='text' class='form-control' name='studenteditusername' value ='$username'></td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Name</label></td>
												      <td><input type='text' class='form-control' name='studenteditname' value ='$name'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Reg.no</label></td>
												      <td><input type='text' class='form-control' name='studenteditregno' value ='$regno' disabled> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Course</label></td>
												      <td><input type='text' class='form-control' name='studenteditcourse' value ='$course' disabled> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Gender</label></td>
												      <td><input type='text' class='form-control' name='studenteditgender' value ='$gender'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Mobile</label></td>
												      <td><input type='text' class='form-control' name='studenteditmobile' value ='$mobile'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Email</label></td>
												      <td><input type='text' class='form-control' name='studenteditemail' value ='$emailid'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Date of Birth</label></td>
												      <td><input type='text' class='form-control' name='studenteditdob' value ='$dob'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Aadhaar no</label></td>
												      <td><input type='text' class='form-control' name='studenteditaadhaar' value ='$aadhaar'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Year of Joining</label></td>
												      <td><input type='text' class='form-control' name='studentedityear' value ='$year' disabled> </td>
												    </tr>
									            </tbody>
							            	</table>
										  	<div class='d-grid gap-6 d-md-block'>
									        	<button type='submit' class='btn btn-outline-success' name='student-back'>Back</button>
												<button type='submit' class='btn btn-outline-danger' name='student-confirm-edit'>Confirm Edit</button>
											</div>
										</form>
								    </div>
								</div>
							</div>
						
				";
				
			}		
			else{
				header('Location: studentedit.php?error=sqlerrornotfetched');
				exit();
			}

		}
		//control starts
				if(isset($_POST['student-back'])){
					header('Location: studentindex.php');
					exit();
				}
				if(isset($_POST['student-confirm-edit'])){
					
					$username = $_SESSION['student'];
	
					//updating values
					$newusername = $_POST['studenteditusername'];
					$name = $_POST['studenteditname'];
					$gender = $_POST['studenteditgender'];
					$mobile = $_POST['studenteditmobile'];
					$emailid = $_POST['studenteditemail'];
					$dob = $_POST['studenteditdob'];
					$aadhaar = $_POST['studenteditaadhaar'];
					
					$sql="
					UPDATE student 
					SET username=?,name=?,gender=?,mobile=?,emailid=?,dob=?,aadhaar=? 
					WHERE username=?;
					";
					$statement = mysqli_stmt_init($connection);
					if(!mysqli_stmt_prepare($statement,$sql)){
						header("Location: studentedit.php?error=sqlerror1");
						exit();
					}
					else{
						
						if(mysqli_stmt_bind_param($statement,'ssssssss',$newusername,$name,$gender,$mobile,$emailid,$dob,$aadhaar,$username))
						{	
							mysqli_stmt_execute($statement);

							$_SESSION['student'] = $newusername;
							$sql ="UPDATE marks 
							SET name=? WHERE regno=?;
							";
							$statement = mysqli_stmt_init($connection);
							mysqli_stmt_prepare($statement,$sql);
							mysqli_stmt_bind_param($statement,"ss",$name,$regno);
							if(!mysqli_stmt_execute($statement)){
								header('Location: studentedit.php?edit=success&marks=failed');
								exit();
							}

							header('Location: studentedit.php?edit=success');
							exit();
						}
						else{
							header("Location: studentedit.php?error=binding");
							exit();
						}	
						
					}	
				}
		//control ends		 

?>		
