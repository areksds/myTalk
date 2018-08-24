<?php 

if (isset($_POST['first'])){$first = filter_var($_POST['first'], FILTER_SANITIZE_STRING) . "%"; }
if (isset($_POST['last'])){$last = filter_var($_POST['last'], FILTER_SANITIZE_STRING) . "%"; }
if (isset($_POST['email'])){$email = filter_var($_POST['email'], FILTER_SANITIZE_STRING) . "%"; }
if (isset($_POST['full'])){$full = filter_var($_POST['full'], FILTER_SANITIZE_STRING); }
if (isset($_POST['name'])){$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING) . "%"; }
if (isset($_POST['state'])){$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING); } else { $state = ''; }

require __DIR__ . '/dbconn.php';

session_start();

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SESSION['level'] >= 3){
	if (isset($full)) {
		if ($full) {
			if (in_array($_SESSION['level'], array(3,4,5))) {
				$state = $_SESSION['state'];
			}

			try {
				$db = new DbConn;
				$list = $db->conn->prepare("SELECT fullname, level FROM members WHERE fullname LIKE :full AND state = :state");
				$list->bindParam(':full', $name);
				$list->bindParam(':state', $state);
				$list->execute();
				$response = $list->fetchAll(PDO::FETCH_ASSOC);

				header('Content-Type: application/json');
				echo json_encode($response);

			} catch (Exception $e) {
				$err = $e->getMessage();
				echo "Couldn't load users.";
			}
		}
		
	} else {
		if (in_array($_SESSION['level'], array(3,4,5)) || $state != '') {
			if (in_array($_SESSION['level'], array(3,4,5))) {
				$state = $_SESSION['state'];
			}

			try {
				$db = new DbConn;
				$list = $db->conn->prepare("SELECT id, first, last, email, level FROM members WHERE first LIKE :first AND last LIKE :last AND email LIKE :email AND state = :state");
				$list->bindParam(':first', $first);
				$list->bindParam(':last', $last);
				$list->bindParam(':email', $email);
				$list->bindParam(':state', $state);
				$list->execute();
				$response = $list->fetchAll(PDO::FETCH_ASSOC);

				header('Content-Type: application/json');
				echo json_encode($response);

			} catch (Exception $e) {
				$err = $e->getMessage();
				echo "Couldn't load users.";
			}
		} else {
			try {
				$db = new DbConn;
				$list = $db->conn->prepare("SELECT id, first, last, email, level FROM members WHERE first LIKE :first AND last LIKE :last AND email LIKE :email");
				$list->bindParam(':first', $first);
				$list->bindParam(':last', $last);
				$list->bindParam(':email', $email);
				$list->execute();
				$response = $list->fetchAll(PDO::FETCH_ASSOC);

				header('Content-Type: application/json');
				echo json_encode($response);

			} catch (Exception $e) {
				$err = $e->getMessage();
				echo "Couldn't load users.";
			}
		}
	}
}


?>