<?php  
 
$dbServername ="localhost";
$dbUsername ="root";
$dbPassword ="root";
$dbname ="studentdatabase";

$connection = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbname);
if(!$connection){
	die("Connection failed...".mysqli_connect_error());
}