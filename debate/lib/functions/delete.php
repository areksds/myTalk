<?php 

if (isset($_POST['type'])){$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING); }
if (isset($_POST['id'])){$id = filter_var($_POST['id'], FILTER_SANITIZE_STRING); }

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';

session_start();

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SESSION['level'] >= 3){
	if ($type == "chapter" && is_numeric($id)) {
		try {
			$err = '';
			$db = new DbConn;
			$stmt = $db->conn->prepare("DELETE FROM chapters WHERE id = :id");
			$stmt->bindParam(':id', $id);
			$stmt->execute();

			$rdb = new DbConn;
			$rstmt = $rdb->conn->prepare("UPDATE members SET chapter = 1 WHERE chapter = :id");
			$rstmt->bindParam(':id', $id);
			$rstmt->execute();
			
			$xdb = new DbConn;
			$xstmt = $xdb->conn->prepare("UPDATE events SET chapter = 1 WHERE chapter = :id");
			$xstmt->bindParam(':id', $id);
			$xstmt->execute();
		} catch (Exception $e) {
			$err = $e->getMessage();
		}
		
		if ($err == '') {
			echo 0;
		} else {
			echo $err;
		}
		
	} elseif ($type == "region" && is_numeric($id)) {
		if ($_SESSION['level'] > 3) {
			try {
				$err = '';
				$db = new DbConn;
				$stmt = $db->conn->prepare("DELETE FROM regions WHERE id = :id");
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				
				$name = __lookup_region_name_id($id);
				$code = __lookup_region_code_id($id);

				$rdb = new DbConn;
				$rstmt = $rdb->conn->prepare("UPDATE chapters SET region = 'None' WHERE region = :region");
				$rstmt->bindParam(':region', $name);
				$rstmt->execute();
				
				$xdb = new DbConn;
				$xstmt = $xdb->conn->prepare("UPDATE events SET region = 'None' WHERE region = :region");
				$xstmt->bindParam(':region', $code);
				$xstmt->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}

			if ($err == '') {
				echo 0;
			} else {
				echo $err;
			}
		}
	}
}

?>