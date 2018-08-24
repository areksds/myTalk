<?php 

if(isset($_POST['email'])){$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);} else {$email = '';}
if(isset($_POST['emailpassword'])){$emailpassword = $_POST['emailpassword'];} else {$emailpassword = '';}
if(isset($_POST['first'])){$first = filter_var($_POST['first'], FILTER_SANITIZE_STRING);} else {$first = '';}
if(isset($_POST['last'])){$last = filter_var($_POST['last'], FILTER_SANITIZE_STRING);} else {$last = '';}
if(isset($_POST['phone'])){$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);} else {$phone = '';}
if(isset($_POST['currentpassword'])){$currentpassword = $_POST['currentpassword'];} else {$currentpassword = '';}
if(isset($_POST['newpassword'])){$newpassword = $_POST['newpassword'];} else {$newpassword = '';}
if(isset($_POST['repeatpassword'])){$repeatpassword = $_POST['repeatpassword'];} else {$repeatpassword = '';}
$fileDir = $_POST['fileDir'];

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';
require __DIR__ . '/errors.php';
require __DIR__ . '/../config.php';
require __DIR__ . '/mailer.php';

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){ 

	session_start();
	
	if (isset($_SESSION['id'])) {
	
	$changes = 0;
	$emails = 0;
	$errors = 0;
	$passchange = 0;
	$user_info = __lookup_user_id($_SESSION['id']);
	
	if ($first != '') {
		if ($first == $_SESSION['first']) {
			error_alert("To alter your first name, please make sure it doesn't match the one you've signed up with.");
			exit();
		} elseif (strlen($first) > 60) {
			error_alert("Your first name exceeds the maximum of 60 characters permitted.");
			exit();
		} else {
			try {
				$err = '';
				$full = $first . " " . $_SESSION['last'];
				$db = new DbConn;
				$test = $db->conn->prepare("UPDATE members SET first = :first WHERE id = :id");
				$test->bindParam(':first', $first);
				$test->bindParam(':id', $_SESSION['id']);	
				$test->execute();
				$rdb = new DbConn;
				$rtest = $rdb->conn->prepare("UPDATE members SET fullname = :full WHERE id = :id");
				$rtest->bindParam(':full', $full);
				$rtest->bindParam(':id', $_SESSION['id']);	
				$rtest->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}
			
			if ($err == '') {
				$changes++;
			} else {
				$errors++;
			}
		}
	}
	
	if ($last != '') {
		if ($last == $_SESSION['last']) {
			error_alert("To alter your last name, please make sure it doesn't match the one you've signed up with.");
			exit();
		} elseif (strlen($last) > 60) {
			error_alert("Your last name exceeds the maximum of 60 characters permitted.");
			exit();
		} else {
			try {
				$err = '';
				if (isset($first)) {
					$full = $first . $last;
				} else {
					$full = $_SESSION['first'] . $last;
				}
				$db = new DbConn;
				$test = $db->conn->prepare("UPDATE members SET last = :last WHERE id = :id");
				$test->bindParam(':last', $last);
				$test->bindParam(':id', $_SESSION['id']);	
				$test->execute();
				$rdb = new DbConn;
				$rtest = $rdb->conn->prepare("UPDATE members SET fullname = :full WHERE id = :id");
				$rtest->bindParam(':full', $full);
				$rtest->bindParam(':id', $_SESSION['id']);	
				$rtest->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}
			
			if ($err == '') {
				$changes++;
			} else {
				$errors++;
			}
		}
	}
	
	if ($phone != '') {
		if (isset($_SESSION['phone'])) {
			if ($phone == $_SESSION['phone']) {
				error_alert("To alter your phone number, please make sure it doesn't match the one you've signed up with.");
				exit();
			} else {
				try {
					$err = '';
					$db = new DbConn;
					$test = $db->conn->prepare("UPDATE members SET phone = :phone WHERE id = :id");
					$test->bindParam(':phone', $phone);
					$test->bindParam(':id', $_SESSION['id']);	
					$test->execute();
				} catch (Exception $e) {
					$err = $e->getMessage();
				}

				if ($err == '') {
					$changes++;
				} else {
					$errors++;
				}
		}
			
		} else {
			try {
				$err = '';
				$db = new DbConn;
				$test = $db->conn->prepare("UPDATE members SET phone = :phone WHERE id = :id");
				$test->bindParam(':phone', $phone);
				$test->bindParam(':id', $_SESSION['id']);	
				$test->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}
			
			if ($err == '') {
				$changes++;
			} else {
				$errors++;
			}
		}
	}
	
	if ($currentpassword != '') {
		if ($newpassword == '') {
			error_alert("Please enter your new password.");
			exit();
		} elseif ($repeatpassword == '') {
			error_alert("Please repeat your new password.");
			exit();
		} elseif (!password_verify($currentpassword, $user_info['password'])) {
			error_alert("Incorrect current password, please try again.");
			exit();
		} elseif (strlen($newpassword) < 8) {
			error_alert("Please make sure your new password is at least 8 characters long.");
			exit();
		} elseif ($newpassword != $repeatpassword) {
			error_alert("Make sure you correctly repeat your new password.");
			exit();
		} else {
			try {
				$err = '';
				$newpw = password_hash($newpassword, PASSWORD_DEFAULT);
				$db = new DbConn;
				$test = $db->conn->prepare("UPDATE members SET password = :password WHERE id = :id");
				$test->bindParam(':password', $newpw);
				$test->bindParam(':id', $_SESSION['id']);	
				$test->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}
			
			if ($err == '') {
				$changes++;
				$passchange++;
			} else {
				$errors++;
			}
		}
	}
	
	if ($newpassword != '') {
		if ($currentpassword == '') {
			error_alert("Please enter your current password.");
			exit();
		}
	}
	
	if ($repeatpassword != '') {
		if ($newpassword == '') {
			error_alert("Please enter your new password.");
			exit();
		}
	}
		
	if ($email != '') {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			error_alert("Please enter a valid email to change your email to.");
			exit();
		} elseif ($email == $_SESSION['email']) {
			error_alert("To change your email, use another email besides your current one.");
			exit();
		} elseif (__lookup_user($email) != 0) {
			error_alert("Please use another email address.");
			exit();
		} elseif ($emailpassword == '') {
			error_alert("Please enter your password to change your email.");
			exit();
		} elseif (!password_verify($emailpassword, $user_info['password'])) {
			error_alert("Incorrect password for email change, please try again.");
			exit();
		} else {
			try {
				$err = '';
				$code = bin2hex(random_bytes(30));
				$db = new DbConn;
				$test = $db->conn->prepare("UPDATE members SET email = :email WHERE id = :id");
				$test->bindParam(':email', $email);
				$test->bindParam(':id', $_SESSION['id']);	
				$test->execute();
				
				$rdb = new DbConn;
				$rtest = $rdb->conn->prepare("UPDATE members SET verified_code = :code WHERE id = :id");
				$rtest->bindParam(':code', $code);
				$rtest->bindParam(':id', $_SESSION['id']);	
				$rtest->execute();
				
				$edb = new DbConn;
				$etest = $edb->conn->prepare("UPDATE members SET verified = 0 WHERE id = :id");
				$etest->bindParam(':id', $_SESSION['id']);	
				$etest->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}
			
			if ($err == '') {
				$changes++;
				$emails++;
			} else {
				$errors++;
			}
		}
	}
	
	if ($changes > 0 && $errors == 0) {
		if ($emails == 1){
			if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
				$base = 'https://' . $_SERVER["SERVER_NAME"];
			} else {
				$base = 'http://' . $_SERVER["SERVER_NAME"];
			}
			$email_sent = sendMail($email, $_SESSION['first'], 2, 2, $base . $fileDir . "/verify&code=" . $code);
			if ($email_sent != 1) {
				error_alert("Changes saved, but we were unable to send the verification email to your new email. Please contact the administrator for more information.");
			} else {
				echo "<div class=\"alert alert-success\" role=\"alert\" style=\"text-align: left;\">Changes saved. You must verify your new email to continue using the site.</div>";
			}
			session_destroy();
		} else {
			echo "<div class=\"alert alert-success\" role=\"alert\" style=\"text-align: left;\">Changes saved.</div>";
			if ($passchange > 0) {
				session_destroy();
			}
		}
	} else {
		if ($errors > 0) {
			error_alert("Errors occured while saving. Please try again, or contact your administrator.");
		} else {
			error_alert("No changes made.");
		}
	}
	
	} else {
		error_alert("Please log in.");
		exit();
	}
}


?>