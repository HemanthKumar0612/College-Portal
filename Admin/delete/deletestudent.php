<?php  
	require "../studentheader.php";
	if (!isset($_SESSION['admin'])){
		header('Location: ../adminlogin.php?error=nouserloginfound');
		exit();
	}
?>
<?php 
	require_once '../database.php'; 
	if(isset($_POST['admin-back'])){
		header('Location: ../adminindex.php');
		exit();
	}
	if(isset($_POST['select-student'])){

		$regno = $_POST['regno-student'];
		$name = $_POST['name-student'];

		if(empty($regno) || empty($name)){
			header('Location: deletestudent.php?error=emptyfields');
			exit();
		}
		
		$sql="DELETE FROM student WHERE regno=? AND name=? ;";
		$statement = mysqli_stmt_init($connection);
		mysqli_stmt_prepare($statement,$sql);
		mysqli_stmt_bind_param($statement,"ss",$regno,$name);
		if(mysqli_stmt_execute($statement)){

			$sql="DELETE FROM marks WHERE regno=? AND name=? ;";
			$statement = mysqli_stmt_init($connection);
			mysqli_stmt_prepare($statement,$sql);
			mysqli_stmt_bind_param($statement,"ss",$regno,$name);
			if(mysqli_stmt_execute($statement)){
				header('Location: deletestudent.php?delete=success');
				exit();
			}
			else{
				header('Location: deletestudent.php?delete=fail');
				exit();
			}
		}
		else{
			header('Location: deletestudent.php?delete=fail');
			exit();
		}



	}
?>