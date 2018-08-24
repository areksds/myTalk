<?php 

if (isset($_POST['type'])){$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING); }
if (isset($_POST['chapter'])){$chapter = filter_var($_POST['chapter'], FILTER_SANITIZE_STRING); }
if (isset($_POST['region'])){$region =filter_var($_POST['region'], FILTER_SANITIZE_STRING); }

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	if ($type == "chapter") {
		try {
			$db = new DbConn;
			$list = $db->conn->prepare("SELECT id, name, region, president FROM chapters WHERE id = :id");
			$list->bindParam(':id', $chapter);
			$list->execute();
			$response = $list->fetch(PDO::FETCH_ASSOC);
			
			if ($response['president'] != 0) {
				$head = $response['president'];
				$bdb = new DbConn;
				$blist = $bdb->conn->prepare("SELECT fullname FROM members WHERE id = :id");
				$blist->bindParam(':id', $head);
				$blist->execute();
				$info = $blist->fetch(PDO::FETCH_ASSOC);
				$head = $info['fullname'];
				$response['head'] = $head;
			}
				

			header('Content-Type: application/json');
			echo json_encode($response);

		} catch (Exception $e) {
			$err = $e->getMessage();
			echo "Couldn't load chapters.";
		}
	} elseif ($type == "region") {
		$region = __lookup_region_id($region);
		try {
			$db = new DbConn;
			$list = $db->conn->prepare("SELECT id, name, code, mayor FROM regions WHERE id = :id");
			$list->bindParam(':id', $region);
			$list->execute();
			$response = $list->fetch(PDO::FETCH_ASSOC);
				
			if ($response['mayor'] != 0) {
				$head = $response['mayor'];
				$bdb = new DbConn;
				$blist = $bdb->conn->prepare("SELECT fullname FROM members WHERE id = :id");
				$blist->bindParam(':id', $head);
				$blist->execute();
				$info = $blist->fetch(PDO::FETCH_ASSOC);
				$head = $info['fullname'];
				$response['head'] = $head;
			}
			
			header('Content-Type: application/json');
			echo json_encode($response);

		} catch (Exception $e) {
			$err = $e->getMessage();
			echo "Couldn't load chapters.";
		}
	}
	
}


?>


