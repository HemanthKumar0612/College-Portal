<?php  
	require "../studentheader.php";
	if (!isset($_SESSION['admin'])){
		header('Location: ../adminlogin.php?error=nouserloginfound');
		exit();
	}
	require_once '../database.php'; 
	if(isset($_POST['admin-back'])){
		header('Location: ../adminindex.php');
		exit();
	}
	if(isset($_POST['select-student']))
	{

		$flag = false;
		$regno=$_POST['regno-student'];
		$name=$_POST['name-student'];
		if(empty($regno) || empty($name)){
			header('Location: studentprogress.php?error=emptyfields');
			exit();
		}
		else{
			$sql = "SELECT * FROM marks WHERE regno=? AND name=?;";
			$statement = mysqli_stmt_init($connection);
			mysqli_stmt_prepare($statement,$sql);
			mysqli_stmt_bind_param($statement,"ss",$regno,$name);
			mysqli_stmt_execute($statement);
			mysqli_stmt_store_result($statement);
			mysqli_stmt_bind_result($statement,$regno,$name,$course,$theory1,$theory2,$theory3,$lab1,$lab2,$openelective);
			if(mysqli_stmt_fetch($statement)){
				$flag = true;
			
			echo "
				<html>
					<head>
						<meta charset='utf-8'>
						<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>
						
						<title>Student Progress Edit</title>
					</head>
					<body>  
						<div class='d-flex align-items-center justify-content-center' >
								<div class='card border-success' style='width: 30rem;''>
									  <div class='card-header text-success text-center'>
									    Student Progress
									  </div>
									  <div class='card-body'>
									   	<form action='studentprogressedit.php'method='POST'>
											<table class ='table table-bordered'>
									  			<tbody>

												    <tr>
												      <td><label class='form-label'>Name</label></td>
												      <td><input type='text' class='form-control' name='student-name' value ='$name'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Reg.No</label></td>
												      <td><input type='text' class='form-control' name='student-regno' value ='$regno'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Course</label></td>
												      <td><input type='text' class='form-control' name='student-course' value ='$course'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Theory1</label></td>
												      <td><input type='text' class='form-control' name='student-theory1' value ='$theory1'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Theory2</label></td>
												      <td><input type='text' class='form-control' name='student-theory2' value ='$theory2'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Theory3</label></td>
												      <td><input type='text' class='form-control' name='student-theory3' value ='$theory3'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Lab1</label></td>
												      <td><input type='text' class='form-control' name='student-lab1' value ='$lab1'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Lab2</label></td>
												      <td><input type='text' class='form-control' name='student-lab2' value ='$lab2'> </td>
												    </tr>
												    <tr>
												      <td><label class='form-label'>Open Elective</label></td>
												      <td><input type='text' class='form-control' name='student-openelective' value ='$openelective'> </td>
												    </tr>
									            </tbody>
							            	</table>
										  	<div class='d-grid gap-6 d-md-block'>
									        	<button type='submit' class='btn btn-outline-success' name='student-progress-back'>Back</button>
												<button type='submit' class='btn btn-outline-danger' name='student-progress-edit'>Confirm Edit</button>
											</div>
										</form>
									  </div>
									  
								</div>
							</div>
					</body>
			";
				
				
			}
			else{
				header('Location: studentprogress.php?error=studentnotfound');
				exit();
			}

		}
		

	}
		

		

	
			
			

	
		
 ?>
 
