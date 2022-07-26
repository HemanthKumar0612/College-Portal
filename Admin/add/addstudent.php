
<?php
	session_start();
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
	<title>Student Registration</title>
</head>
<body>
	
	<div class="d-flex align-items-center justify-content-center" >
			<div class="card border-success" style="width: 25rem;">
			  <div class="card-header text-success text-center">
			    Add Student
			  </div>
			  <div class="card-body">
			    <form   method="POST">
				  <div class="mb-3" >
				    <label class="form-label">Name</label>
				    <input type="text" class="form-control" name="newstudentname" > 
				  </div>
				  
				  <div class="mb-3" >
				    <label class="form-label">Course</label>
				    <input type="text" class="form-control" name="newstudentcourse" > 
				  </div>
				  <div class="mb-3" >
				    <label class="form-label">Year of Joining</label>
				    <input type="text" class="form-control" name="newstudentyear" > 
				  </div>
				  <div class="mb-3" >
				    <label class="form-label">Gender</label>
				    <input type="text" class="form-control" name="newstudentgender" > 
				  </div>
				  <div class="mb-3" >
				    <label class="form-label">Date of Birth( YYYY-MM-DD)</label>
				    <input type="text" class="form-control" name="newstudentdob" > 
				  </div>
				  <div class="mb-3" >
				    <label class="form-label">Aadhhar no</label>
				    <input type="text" class="form-control" name="newstudentaadhaar" > 
				  </div>
				  <div class="mb-3" >
				    <label class="form-label">Email id</label>
				    <input type="text" class="form-control" name="newstudentemail" > 
				  </div>
				  <div class="mb-3" >
				    <label class="form-label">Mobile</label>
				    <input type="text" class="form-control" name="newstudentmobile" > 
				  </div>
				  <button type="submit" class="btn btn-outline-danger" name="admin-back">Back</button>
				  <button type="submit" class="btn btn-outline-success"  name="addstudent">Add</button>
				  
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
	function regstrationlink($email,$regno,$name){
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
		$mail->Subject = 'Student Registration';
		$msg=
			"<div>
				<h1>Registration</h1>
				<p>Use the below Link and the credentials to signup to Student Portal</p>
				<a href='http://localhost/Student%20database%20Management%20system/Student/studentregister.php'>Link</a>
				<p>Name : $name</p>
				<p>Registration No : $regno</p>
				<p>Email ID : $email</p>
			</div>";
		$mail->Body = $msg;
		$mail->AddAddress($email);

		if($mail->Send())
			return 1;
		else
			return 0;
	} 
	require_once '../database.php';
	if(isset($_POST['admin-back'])){
		header('Location: ../adminindex.php');
		exit();
	}
	else if(isset($_POST['addstudent'])){
		
		
		$name=$_POST['newstudentname'];

		$dob=$_POST['newstudentdob']; 


		$course=$_POST['newstudentcourse'];

		$year=(int)$_POST['newstudentyear'];

		$gender=$_POST['newstudentgender'];

		

		$aadhaar=$_POST['newstudentaadhaar'];

		$email=$_POST['newstudentemail'];

		$mobile=$_POST['newstudentmobile'];

		
		// creating 

		$sql = "SELECT COUNT(*) FROM student WHERE course=?;";
		$statement = mysqli_stmt_init($connection);
		mysqli_stmt_prepare($statement,$sql);
		mysqli_stmt_bind_param($statement,"s",$course);
		mysqli_stmt_execute($statement);
		mysqli_stmt_store_result($statement);
		mysqli_stmt_bind_result($statement,$count);
		mysqli_stmt_fetch($statement);
		$temp = $year%100;
		$count+=1;
		$regno = $course.$temp.$count;

		if(empty($email) || empty($name) || empty($course)  || empty($dob) || empty($year) || empty($aadhaar) || empty($mobile) || empty($gender))
		{
			header("Location: addstudent.php?error=emptyfields");
			exit();
		}
		else if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
			header("Location: addstudent.php?error=invalidemail");
			exit();
		}
		else if(strlen($mobile)!=10){
			header("Location: addstudent.php?error=invalidemobile");
			exit();
		}
		else{
			$sql="SELECT * FROM student WHERE regno = ? ";
			$statement=mysqli_stmt_init($connection);
			if(!mysqli_stmt_prepare($statement,$sql)){
				header("Location: addstudent.php?error=sqlerror");
				exit();
			}
			else{
				mysqli_stmt_bind_param($statement,"s",$regno);
				mysqli_stmt_execute($statement);
				mysqli_stmt_store_result($statement);
				$resultrows=mysqli_stmt_num_rows($statement);
				if($resultrows > 0){
					header("Location: addstudent.php?error=UserPresent");
					exit();
				}
				else{
					$sql="INSERT INTO student(name,regno,course,dob,emailid,mobile,aadhaar,gender,year) VALUES (?,?,?,?,?,?,?,?,?) ;" ;
					$statement=mysqli_stmt_init($connection);
					if(!mysqli_stmt_prepare($statement,$sql)){
						header("Location: addstudent.php?error=sqlerror");
						exit();
					}
					else{
						mysqli_stmt_bind_param($statement, "ssssssssi" ,$name,$regno,$course,$dob,$email,$mobile,$aadhaar,$gender,$year);
						mysqli_stmt_execute($statement);
						$sql = "INSERT INTO marks(regno,name,course) VALUES(?,?,?);";
						$statement = mysqli_stmt_init($connection);
						mysqli_stmt_prepare($statement,$sql);
						mysqli_stmt_bind_param($statement,"sss",$regno,$name,$course);
						mysqli_stmt_execute($statement);
						regstrationlink($email,$regno,$name);
						header("Location: addstudent.php?signup=successfulyaddedstudent");
						exit();

					}
				}
			}


		}



		mysqli_stmt_close($statement);
		mysqli_close($connection);

	}
?>



