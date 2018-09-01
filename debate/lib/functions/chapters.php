<?php 

$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);

require __DIR__ . '/dbconn.php';

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && in_array($state, array(0,1,2,3,4,5,6,7,8,9,10))){
	try {
		$db = new DbConn;
		$list = $db->conn->prepare("SELECT id, name FROM chapters WHERE state = :state ORDER BY name");
		$list->bindParam(':state', $state);
		$list->execute();
		$response = $list->fetchAll(PDO::FETCH_ASSOC);
		
		header('Content-Type: application/json');
		echo htmlspecialchars_decode(json_encode($response),ENT_QUOTES);
		
	} catch (Exception $e) {
		$err = $e->getMessage();
		echo "Couldn't load chapters.";
	}
}


?>