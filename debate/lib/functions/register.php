<?php 

$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
$newpw = password_hash($_POST['password'], PASSWORD_DEFAULT);
$password1 = $_POST['password'];
$password2 = $_POST['password_verify'];
$first = filter_var($_POST['first'], FILTER_SANITIZE_STRING);
$last = filter_var($_POST['last'], FILTER_SANITIZE_STRING);
$chapter = filter_var($_POST['chapter'], FILTER_SANITIZE_STRING);
$graduation = filter_var($_POST['graduation'], FILTER_SANITIZE_STRING);
$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
$recaptcha = $_POST['recaptcha'];
$fileDir = $_POST['fileDir'];
$staff_code = filter_var($_POST['staffcode'], FILTER_SANITIZE_STRING);
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
	$base = 'https://' . $_SERVER["SERVER_NAME"];
} else {
	$base = 'http://' . $_SERVER["SERVER_NAME"];
}

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';
require __DIR__ . '/recaptcha.php';
require __DIR__ . '/errors.php';
require __DIR__ . '/../config.php';
require __DIR__ . '/mailer.php';

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	
	//Tedious process of checking all the things that could have gone wrong
	if ($state == '' || $email == '' || $password1 == '' || $password2 == '' || $first == '' || $last == '' || $chapter == '' || $graduation == '') {
		error_alert("Please fill in all the required fields.");
	} elseif (!in_array($state, array(0,1,2,3,4,5,6,7,8,9,10))) {
		error_alert("Invalid state, please try re-filling the registration form.");
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		error_alert("Please enter a valid email.");
	} elseif (__lookup_user($email) != 0) {
		error_alert("Please use another email.");
	} elseif ($password1 != $password2) {
		error_alert("Please make sure your passwords match.");
	} elseif (strlen($password1) < 8) {
		error_alert("Your password must be at least 8 characters.");
	} elseif (strlen($first) > 60) {
		error_alert("Your first name exceeds the maximum of 60 characters permitted.");
	} elseif ($state == 0 && $staff_code != $config['code']) {
		error_alert("Incorrect staff code.");
	} elseif (strlen($last) > 60) {
		error_alert("Your last name exceeds the maximum of 60 characters permitted.");
	} elseif (!is_numeric($chapter)) {
		error_alert("Invalid chapter, please try re-filling the registration form.");
	} elseif (!is_numeric($graduation))  {
		error_alert("Invalid graduation year, please try re-filling the registration form.");
	} elseif ($config['recaptcha']['sitekey'] == '' || $config['recaptcha']['secret'] == '') {
		error_alert("Site error: reCaptcha keys aren't filled out. Please inform your systems administrator.");
	} elseif (__recaptcha($recaptcha, $config['recaptcha']['secret']) != 0) {
		error_alert("reCaptcha verification failed. Please try again.");
	} else {
		try {
			$err = '';
			$capFirst = ucfirst($first);
			$capLast = ucfirst($last);
			$fullname = ucfirst($first) . " " . ucfirst($last);
			$zero = 0;
			$one = 1;
			$code = bin2hex(random_bytes(30));
			$db = new DbConn;
			$user = $db->conn->prepare("INSERT INTO members(first, last, fullname, email, password, state, chapter, graduation, phone, verified, verified_code, level, debates, mods, events) VALUES (:first,:last,:fullname,:email,:password,:state,:chapter,:graduation,:phone,:verified,:verified_code,:level,:debates,:mods,:events)");
			$user->bindParam(':first', $capFirst);
			$user->bindParam(':last', $capLast);
			$user->bindParam(':fullname', $fullname);
			$user->bindParam(':email', $email);
			$user->bindParam(':password', $newpw);
			$user->bindParam(':state', $state);
			$user->bindParam(':chapter', $chapter);
			$user->bindParam(':graduation', $graduation);
			if ($phone != '') {
				$user->bindParam(':phone', $phone);
			} else {
				$user->bindParam(':phone', $zero);
			}
			$user->bindParam(':verified', $zero);
			$user->bindParam(':verified_code', $code);
			$user->bindParam(':level', $one);
			$user->bindParam(':debates', $zero);
			$user->bindParam(':mods', $zero);
			$user->bindParam(':events', $zero);
			$user->execute();
		} catch (Exception $e) {
			$err = $e->getMessage();
			error_alert($err);
		}
		
		if ($err == '') {
			$test = __lookup_user($email);
			if ($test != 1) {
				error_alert("Registration failed. Please try again later.");
			} else {
				$email_sent = sendMail($email, $capFirst, 0, 0, $base . $fileDir . "/verify&code=" . $code);
				if ($email_sent === 1) {
					echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\" style=\"text-align: left;\">You have successfully registered on myTalk! Please verify your account by pressing the link sent to " . $email . ".<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
				} else {
					echo "<div class=\"alert alert-warning alert-dismissible fade show\" role=\"alert\" style=\"text-align: left;\">You have successfully registered on myTalk! Unfortunately, we couldn't send a verification email. Here's the problem: <b>" . $email_sent . "</b><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
				}
			}
		}
	}
	
	
}




?>