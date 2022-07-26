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
	if(isset($_POST['select-student'])) {
		require_once '../database.php';

		$regno = $_POST['regno-student'];
		$name = $_POST['name-student'];

		
		if(empty($regno) || empty($name)){
			header('Location: editstudent.php?error=emptyfields');
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
				
				$_SESSION['editname']=$name;
				$_SESSION['editregno']=$regno;
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
												      <td><input type='text' class='form-control' name='admin-student-editname' value ='$name'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Reg no</label></td>
												      <td><input type='text' class='form-control' name='admin-student-editregno' value ='$regno' disabled> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Course</label></td>
												      <td><input type='text' class='form-control' name='admin-student-editcourse' value ='$course' disabled> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Gender</label></td>
												      <td><input type='text' class='form-control' name='admin-student-editgender' value ='$gender'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Mobile</label></td>
												      <td><input type='text' class='form-control' name='admin-student-editmobile' value ='$mobile'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Email</label></td>
												      <td><input type='text' class='form-control' name='admin-student-editemail' value ='$emailid'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Date of Birth</label></td>
												      <td><input type='text' class='form-control' name='admin-student-editdob' value ='$dob'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Aadhaar no</label></td>
												      <td><input type='text' class='form-control' name='admin-student-editaadhaar' value ='$aadhaar'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Year of Joining</label></td>
												      <td><input type='text' class='form-control' name='admin-student-edityear' value ='$year'> </td>
												    </tr>
									            </tbody>
							            	</table>
										  	<div class='d-grid gap-6 d-md-block'>
									        	<button type='submit' class='btn btn-outline-success' name='editback'>Back</button>
												<button type='submit' class='btn btn-outline-danger' name='editconfirm'>Confirm Edit</button>
											</div>
										</form>
						            </div>
						        </div>
							</div>
						</body>	
				";

			}		
			else{
				header('Location: editstudent.php?error=nouserfound');
				exit();
			}
			// control
}


			if(isset($_POST['editback'])){
				header('Location: editstudent.php');
				exit();
			}
			if(isset($_POST['editconfirm'])){
				require_once '../database.php';
				
				$name = $_SESSION['editname'];
				$regno = $_SESSION['editregno'];
				

				if(empty($regno) || empty($name)){
					header('Location: editstudent.php?error=emptyfields');
					exit();
				}
				$newname=$_POST['admin-student-editname'];
				$newregno=$_POST['admin-student-editregno'];
				$course=$_POST['admin-student-editcourse'];
				$gender=$_POST['admin-student-editgender'];
				$mobile=$_POST['admin-student-editmobile'];
				$emailid=$_POST['admin-student-editemail'];
				$dob=$_POST['admin-student-editdob'];
				$aadhaar=$_POST['admin-student-editaadhaar'];
				$year=$_POST['admin-student-edityear'];
				
				$sql =  "UPDATE student 
						SET name=?,regno=?,course=?,gender=?,mobile=?,emailid=?,dob=?,aadhaar=?,year=? 
						WHERE regno=? AND name=?;
						";
				$statement = mysqli_stmt_init($connection);
				if(!mysqli_stmt_prepare($statement,$sql)){
					header('Location: editstudent.php?edit=failprep');
					exit();
				}
				mysqli_stmt_bind_param($statement,'ssssissiiss',$newname,$newregno,$course,$gender,$mobile,$emailid,$dob,$aadhaar,$year,$regno,$name);		
				if(mysqli_stmt_execute($statement)){
					$sql2 =  
					"UPDATE marks 
					SET name=?
					WHERE regno=?;
					";
					$statement2 = mysqli_stmt_init($connection);
					mysqli_stmt_prepare($statement2,$sql2);
					mysqli_stmt_bind_param($statement2,"ss",$newname,$regno);
					if(mysqli_stmt_execute($statement2)){
						unset($_SESSION['editname']);
						unset($_SESSION['editregno']);
						header('Location: editstudent.php?edit=success');
						exit();
					}
					else{
						header('Location: editstudent.php?edit=fail2');
						exit();
					}
					
				}
				else{
					header('Location: editstudent.php?edit=fail1');
					exit();
				}
			}
			
			//control	


?>
	
    

