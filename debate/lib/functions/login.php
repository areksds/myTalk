<?php 

$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
$password = $_POST['password'];
$recaptcha = $_POST['recaptcha'];
$fileDir = $_POST['fileDir'];

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';
require __DIR__ . '/recaptcha.php';
require __DIR__ . '/errors.php';
require __DIR__ . '/../config.php';

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){ 
	
	if ($email == '' || $password == '') {
		error_alert("Please enter your email and password.");
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		error_alert("Please enter a valid email.");
	} elseif (__lookup_user($email) != 1) {
		error_alert("There's no account using that email. Why not <a href=\"register\" style=\"color: black;\">register an account</a>?");
	} elseif ($config['recaptcha']['sitekey'] == '' || $config['recaptcha']['secret'] == '') {
		error_alert("Site error: reCaptcha keys aren't filled out. Please inform your systems administrator.");
	} elseif (__recaptcha($recaptcha, $config['recaptcha']['secret']) != 0) {
		error_alert("reCaptcha verification failed. Please try again.");
	} else {
		try {
			$err = '';
			$db = new DbConn;
			$user = $db->conn->prepare("SELECT * FROM members WHERE email = :email");
			$user->bindParam(':email', $email);
			$user->execute();
			$result = $user->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			$err = $e->getMessage();
			error_alert($err);
		}
		
		if ($err == '') {
			if (!password_verify($password, $result['password'])) {
				error_alert("Incorrect password, please try again.");
			} elseif ($result['verified'] != '1') {
				error_alert("Your email address isn't verified. Please click the link in your email to activate it. <a href=\"resend&email=" . $email . "\" style=\"color: black;\">Having trouble verifying?</a>");
			} else {
				session_start();
                $_SESSION['email'] = $email;
				$_SESSION['first'] = $result['first'];
				$_SESSION['last'] = $result['last'];
				$_SESSION['name'] = $result['fullname'];
				$_SESSION['id'] = $result['id'];
				$_SESSION['state'] = $result['state'];
				$_SESSION['chapter'] = $result['chapter'];
				$_SESSION['graduation'] = $result['graduation'];
				if ($result['phone'] != 0) {
					$_SESSION['phone'] = $result['phone'];
				}
				$_SESSION['level'] = $result['level'];
				$_SESSION['debates'] = $result['debates'];
				$_SESSION['mods'] = $result['mods'];
				$_SESSION['events'] = $result['events'];
				echo "<div class=\"alert alert-success\" role=\"alert\" style=\"text-align: left;\">Login success.</div>";
			}
		}
	}


}

?>