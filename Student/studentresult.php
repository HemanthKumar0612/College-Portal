<?php  
	session_start();
	require_once 'includes/database.php';
	$regno = $_SESSION['student-regno'];
	if(empty($regno)){
		header('Location: studentlogin.php');
		exit();
	}
	$sql = "SELECT name,course,theory1,theory2,theory3,lab1,lab2,openelective 
	FROM marks WHERE regno =?; ";
	$statement = mysqli_stmt_init($connection);
	if(!mysqli_stmt_prepare($statement,$sql)){
		header("Location: studentindex.php?error=sqlerror1");
				exit();
	}
	else{
		mysqli_stmt_bind_param($statement,"s",$regno);
		mysqli_stmt_execute($statement);
		mysqli_stmt_store_result($statement);
		mysqli_stmt_bind_result($statement,$name,$course,$theory1,$theory2,$theory3,$lab1,$lab2,$openelective);
		if(mysqli_stmt_fetch($statement)){
			echo "
				<html>
					<head>
						<meta charset='utf-8'>
						<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>
						
						<title>Student Result</title>
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
										      <td>Registration No</td>
										      <td>$regno</td>
										    </tr>
										    <tr>
										      <td>Course</td>
										      <td>$course</td>
										    </tr>
										    <tr>
										      <td>Theory 1</td>
										      <td>$theory1</td>
										    </tr>
										    <tr>
										      <td>Theory 2</td>
										      <td>$theory1</td>
										    </tr>
										    <tr>
										      <td>Theory 3</td>
										      <td>$theory3</td>
										    </tr>
										    <tr>
										      <td>Lab 1</td>
										      <td>$lab1</td>
										    </tr>
										    <tr>
										      <td>Lab 2</td>
										      <td>$lab2</td>
										    </tr>
										    <tr>
										      <td>Open Elective</td>
										      <td>$openelective</td>
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
			header("Location: studentindex.php?error=sqlerror2");
				exit();
		}
	}
	if(isset($_POST['student-back'])){
		header('Location: studentindex.php');
		exit();
	}
?>

