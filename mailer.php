
<?php

	require_once 'PHPMailer/PHPMailerAutoload.php';

	$mail = new PHPMailer();
	$mail->isSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->isHTML();
	$mail->Username = 'hksecondary1@gmail.com';
	$mail->Password = 'djhqqocrtpbuzjsm';
	$mail->SetFrom('no-reply@hk.org');
	$mail->Subject = 'Hello World';
	$mail->Body = 'Testing mail!';
	$mail->AddAddress('hemanthkumarmulka15@gmail.com');

	if(!$mail->Send())
		echo 'Mailer Error: ' . $mail->ErrorInfo;


?>
