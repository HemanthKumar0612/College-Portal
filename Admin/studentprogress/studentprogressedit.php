<?php  
				if(isset($_POST['student-progress-back'])){
					header('Location: studentprogress.php?back');
					exit();
				}
				if(isset($_POST['student-progress-edit'])){
					session_start();
					require_once '../database.php';
					$name = $_POST['student-name'];
					$regno = $_POST['student-regno'];
					$course = $_POST['student-course'];
					$theory1 = $_POST['student-theory1'];
					$theory2 = $_POST['student-theory2'];
					$theory3 = $_POST['student-theory3'];
					$lab1 = $_POST['student-lab1'];
					$lab2 = $_POST['student-lab2'];
					$openelective = $_POST['student-openelective'];
					
					$sql="
					UPDATE marks 
					SET theory1=?,theory2=?,theory3=?,lab1=?,lab2=?,openelective=? 
					WHERE regno=? AND name=?;
					";
					$statement = mysqli_stmt_init($connection);
					if(!mysqli_stmt_prepare($statement,$sql)){
						header("Location: studentprogress.php?error=sqlerror1");
						exit();
					}
					else{
						mysqli_stmt_bind_param($statement,'iiiiiiss',$theory1,$theory2,$theory3,$lab1,$lab2,$openelective,$regno,$name);
						if(mysqli_stmt_execute($statement)){
							header("Location: studentprogress.php?edit=success");
							exit();
						}
						else{
							header("Location: studentprogress.php?edit=fail");
							exit();
						}
					}	
				} 
?>