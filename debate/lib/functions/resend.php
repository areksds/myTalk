<?php 

$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
$recaptcha = $_POST['recaptcha'];
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
	$base = 'https://' . $_SERVER["SERVER_NAME"];
} else {
	$base = 'http://' . $_SERVER["SERVER_NAME"];
}
$fileDir = $_POST['fileDir'];

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';
require __DIR__ . '/recaptcha.php';
require __DIR__ . '/errors.php';
require __DIR__ . '/../config.php';
require __DIR__ . '/mailer.php';

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	if ($email == '' || $recaptcha == '') {
		echo error_alert("Please fill in your email.");
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		error_alert("Please enter a valid email.");
	} elseif ($config['recaptcha']['sitekey'] == '' || $config['recaptcha']['secret'] == '') {
		error_alert("Site error: reCaptcha keys aren't filled out. Please inform your systems administrator.");
	} elseif (__recaptcha($recaptcha, $config['recaptcha']['secret']) != 0) {
		error_alert("reCaptcha verification failed. Please try again.");
	} elseif (__lookup_user($email) == 0) {
		error_alert("A user with that email could not be found.");
	} else {
		
		try {
			$err = '';
			$rdb = new DbConn;
			$user = $rdb->conn->prepare("SELECT * FROM members WHERE email = :email");
			$user->bindParam(':email', $email);
			$user->execute();
			$result = $user->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			$err = $e->getMessage();
		}
		
		if ($result['verified'] == 1) {
			error_alert("This account is already verified.");
		} elseif ($err != '') {
			error_alert($err);
		} else {
			try {
				$err = '';
				$code = bin2hex(random_bytes(30));
				$db = new DbConn;
				$test = $db->conn->prepare("UPDATE members SET verified_code = :code WHERE email = :email");
				$test->bindParam(':code', $code);	
				$test->bindParam(':email', $email);	
				$test->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}

			if ($err == '') {
				$email_sent = sendMail($email, $result['first'], 0, 0, $base . $fileDir . "/verify&code=" . $code);
				if ($email_sent == 1){
					echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\" style=\"text-align: left;\">A new verification email has been sent.<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
				} else {
					error_alert("Unable to send email. Please contact your systems administrator to fix this problem.");
				}
			} else {
				error_alert("An error occurred: " . $err);
			}
		
		}
	}
}

?>
