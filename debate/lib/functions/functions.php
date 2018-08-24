<?php 

include __DIR__ . '/../config.php';

define('STATES',array("Pacific Northwest", "Northern California", "Southern California", "Arizona", "Midwest", "Texas", "Ohio River Valley", "Northeast", "Mid-Atlantic", "Southeast"));
define('PERMISSIONS',array("Member","Cabinet","Mayor","Director of Debate","Governor","JSF Employee","Root Administrator"));
define('PANELS',array(NULL,"Cabinet Homepage","Regional Control Panel","Debate Control Panel","State and Debate Panel","Global Control Panel","Root Control Panel"));
define('PANEL_URLS',array(NULL,"cabinet","region","manage","state","nation","admin"));
define('PANEL_DESCRIPTIONS',array(NULL,"Visit the cabinet homepage, which provides all sorts of information for cabinet members!","Manage your region chapters and regional debates here.","Manage state-wide debates here.","Manage your state settings, users, and state-wide debates.","Administrate nationwide debates, states, regions, and users.","Manage the myTalk installation."));

if (str_replace(' ', '', $config['admins']) != ''){
	$admins = str_replace(' ', '', $config['admins']);
	$admins = explode(',',$admins);
	
	try {
		$err = '';
		$db = new DbConn;
		$test = $db->conn->prepare("SELECT id FROM members WHERE level = 7");	
		$test->execute();
		$current = $test->fetch(PDO::FETCH_ASSOC);
	} catch (Exception $e) {
		$err = $e->getMessage();
	}
	
	foreach($admins as $admin) {
		$user = __lookup_user_id($admin);
		if($user != 1 || $user != 0){
			if($user['level'] != 7){
				try {
					$err = '';
					$db = new DbConn;
					$test = $db->conn->prepare("UPDATE members SET level = 7 WHERE id = :id");
					$test->bindParam(':id', $admin);	
					$test->execute();
				} catch (Exception $e) {
					$err = $e->getMessage();
				}
			}
		}
	}
	if($current != '') {
		$difference = array_diff($current,$admins);
		
		foreach($difference as $person) {
			try {
				$err = '';
				$db = new DbConn;
				$test = $db->conn->prepare("UPDATE members SET level = 1 WHERE id = :id");
				$test->bindParam(':id', $person);	
				$test->execute();
			} catch (Exception $e) {
				$err = $e->getMessage();
			}
		}
	}
	
} else {
	try {
		$err = '';
		$db = new DbConn;
		$test = $db->conn->prepare("UPDATE members SET level = 1 WHERE level = 7");	
		$test->execute();
	} catch (Exception $e) {
		$err = $e->getMessage();
	}
}

if (isset($_SESSION['id'])){
	$result = __lookup_user_id($_SESSION['id']);
	$_SESSION['email'] = $result['email'];
	$_SESSION['first'] = $result['first'];
	$_SESSION['last'] = $result['last'];
	$_SESSION['name'] = $result['fullname'];
	$_SESSION['state'] = $result['state'];
	$_SESSION['chapter'] = $result['chapter'];
	$_SESSION['graduation'] = $result['graduation'];
	if ($result['phone'] != 0) {
		$_SESSION['phone'] = $result['phone'];
	} elseif(isset($_SESSION['phone'])) {
		unset($_SESSION['phone']);
	}
	$_SESSION['level'] = $result['level'];
	$_SESSION['debates'] = $result['debates'];
	$_SESSION['mods'] = $result['mods'];
	$_SESSION['events'] = $result['events'];
}

?>