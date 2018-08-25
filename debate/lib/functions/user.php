<?php 

$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';

session_start();

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SESSION['level'] >= 4){ 
	if ($type == "get") {
		if (in_array($_SESSION['level'], array(4,5))) {
			try {
				$db = new DbConn;
				$list = $db->conn->prepare("SELECT id, first, last, fullname, email, state, chapter, graduation, phone, verified, level FROM members WHERE id = :id AND state = :state");
				$list->bindParam(':id', $id);
				$list->bindParam(':state', $_SESSION['state']);
				$list->execute();
				$response = $list->fetch(PDO::FETCH_ASSOC);
				
				header('Content-Type: application/json');
				echo json_encode($response);

			} catch (Exception $e) {
				$err = $e->getMessage();
				echo "Couldn't load user.";
			}
		} else {
			try {
				$db = new DbConn;
				$list = $db->conn->prepare("SELECT id, first, last, fullname, email, state, chapter, graduation, phone, verified, level FROM members WHERE id = :id");
				$list->bindParam(':id', $id);
				$list->execute();
				$response = $list->fetch(PDO::FETCH_ASSOC);
				
				header('Content-Type: application/json');
				echo json_encode($response);

			} catch (Exception $e) {
				$err = $e->getMessage();
				echo "Couldn't load user.";
			}
		}
	} elseif ($type == "put") {
		$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
		$first = filter_var($_POST['first'], FILTER_SANITIZE_STRING);
		$last = filter_var($_POST['last'], FILTER_SANITIZE_STRING);
		$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
		$graduation = filter_var($_POST['graduation'], FILTER_SANITIZE_STRING);
		$chapter = filter_var($_POST['chapter'], FILTER_SANITIZE_STRING);
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
		$verified = filter_var($_POST['verified'], FILTER_SANITIZE_STRING);
		$level = filter_var($_POST['level'], FILTER_SANITIZE_STRING);
		if ($_SESSION['level'] >= 6) {
			$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
		}
		$changes = 0;
		$errors = 0;
		if (__lookup_level($id) < $_SESSION['level'] || $_SESSION['level'] >= 6) {
			if ($first != '') {
				if (strlen($first) > 60) {
					$errors++;
				} else {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("SELECT last FROM members WHERE id = :id");
						$test->bindParam(':id', $id);	
						$test->execute();
						$response = $test->fetchAll(PDO::FETCH_ASSOC);
						$full = $first . " " . $response['last'];
						$rdb = new DbConn;
						$rtest = $rdb->conn->prepare("UPDATE members SET fullname = :full WHERE id = :id");
						$rtest->bindParam(':full', $full);
						$rtest->bindParam(':id', $id);	
						$rtest->execute();
						$edb = new DbConn;
						$etest = $edb->conn->prepare("UPDATE members SET first = :first WHERE id = :id");
						$etest->bindParam(':first', $first);
						$etest->bindParam(':id', $id);	
						$etest->execute();
					} catch (Exception $e) {
						$err = $e->getMessage();
					}

					if ($err == '') {
						$changes++;
					} else {
						echo $err;
						$errors++;
					}
				}
			}

			if ($last != '') {
				if (strlen($last) > 60) {
					$errors++;
				} else {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("SELECT first FROM members WHERE id = :id");
						$test->bindParam(':id', $id);	
						$test->execute();
						$response = $test->fetchAll(PDO::FETCH_ASSOC);
						$full = $response['first'] . " " . $last;
						$rdb = new DbConn;
						$rtest = $rdb->conn->prepare("UPDATE members SET fullname = :full WHERE id = :id");
						$rtest->bindParam(':full', $full);
						$rtest->bindParam(':id', $id);	
						$rtest->execute();
						$edb = new DbConn;
						$etest = $edb->conn->prepare("UPDATE members SET last = :last WHERE id = :id");
						$etest->bindParam(':last', $last);
						$etest->bindParam(':id', $id);	
						$etest->execute();
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
				try {
					$err = '';
					$db = new DbConn;
					$test = $db->conn->prepare("UPDATE members SET phone = :phone WHERE id = :id");
					$test->bindParam(':phone', $phone);
					$test->bindParam(':id', $id);	
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

			if ($verified != '') {
				try {
					$err = '';
					$db = new DbConn;
					$test = $db->conn->prepare("UPDATE members SET verified = :verified WHERE id = :id");
					$test->bindParam(':verified', $verified);
					$test->bindParam(':id', $id);	
					$test->execute();

					$rdb = new DbConn;
					$rtest = $rdb->conn->prepare("UPDATE members SET verified_code = NULL WHERE id = :id");
					$rtest->bindParam(':id', $id);	
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

			if ($state != '' && $_SESSION['level'] >= 6) {
				try {
					$err = '';
					$db = new DbConn;
					$test = $db->conn->prepare("UPDATE members SET state = :state WHERE id = :id");
					$test->bindParam(':state', $state);
					$test->bindParam(':id', $id);	
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

			if ($chapter != '') {
				if (is_numeric($chapter)) {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("UPDATE members SET chapter = :chapter WHERE id = :id");
						$test->bindParam(':chapter', $chapter);
						$test->bindParam(':id', $id);	
						$test->execute();
					} catch (Exception $e) {
						$err = $e->getMessage();
					}

					if ($err == '') {
						$changes++;
					} else {
						$errors++;
					}
				} else {
					$errors++;
				}
			}

			if ($level != '') {
				if (is_numeric($level)) {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("UPDATE members SET level = :level WHERE id = :id");
						$test->bindParam(':level', $level);
						$test->bindParam(':id', $id);	
						$test->execute();
					} catch (Exception $e) {
						$err = $e->getMessage();
					}

					if ($err == '') {
						$changes++;
					} else {
						$errors++;
					}
				} else {
					$errors++;
				}
			}

			if ($graduation != '') {
				if (is_numeric($graduation)) {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("UPDATE members SET graduation = :graduation WHERE id = :id");
						$test->bindParam(':graduation', $graduation);
						$test->bindParam(':id', $id);	
						$test->execute();
					} catch (Exception $e) {
						$err = $e->getMessage();
					}

					if ($err == '') {
						$changes++;
					} else {
						$errors++;
					}
				} else {
					$errors++;
				}
			}

			if ($email != '') {
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$errors++;
				} elseif (__lookup_user($email) != 0) {
					$errors++;
				} else {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("UPDATE members SET email = :email WHERE id = :id");
						$test->bindParam(':email', $email);
						$test->bindParam(':id', $id);	
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

			if ($changes > 0 && $errors == 0) {
					echo "0";
			} else {
				if ($errors > 0) {
					echo "1";
				}
			}
		} else {
			echo "1";
		}
	}

}


