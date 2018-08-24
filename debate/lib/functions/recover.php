<?php

$code = $_POST['code'];
$password = $_POST['password'];
$passwordrepeat = $_POST['repeatPassword'];
$newpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';
require __DIR__ . '/errors.php';
require __DIR__ . '/../config.php';

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	if ($code == '') {
		echo error_alert("Code invalid. Please try re-sending a forgot password request.");
	} elseif ($password == '' || $passwordrepeat == '') {
		error_alert("Please fill in both password fields.");
	} elseif ($password != $passwordrepeat) {
		error_alert("Passwords don't match.");
	} elseif(__lookup_forgot_code($code) != 1) {
		error_alert("Code invalid.");
	} else {
		try {
			$err = '';
			
			$db = new DbConn;
			$test = $db->conn->prepare("UPDATE members SET password = :password WHERE verified_code = :code");
			$test->bindParam(':password', $newpassword);
			$test->bindParam(':code', $code);	
			$test->execute();
			
			$rdb = new DbConn;
			$rtest = $rdb->conn->prepare("UPDATE members SET verified_code = NULL WHERE verified_code = :code");
			$rtest->bindParam(':code', $code);	
			$rtest->execute();
		} catch (Exception $e) {
			$err = $e->getMessage();
		}
		
		if ($err == '') {
			echo "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\" style=\"text-align: left;\">Your password has been successfully reset.<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
		} else {
			error_alert("An error occurred: " . $err);
		}
		
		
	}
}

?>