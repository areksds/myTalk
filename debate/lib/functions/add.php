<?php 

if (isset($_POST['type'])){$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING); }
if (isset($_POST['name'])){$name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['region'])){$region = trim(filter_var($_POST['region'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['code'])){$code = filter_var($_POST['code'], FILTER_SANITIZE_STRING); }
if (isset($_POST['bulk'])){$bulk = filter_var($_POST['bulk'], FILTER_SANITIZE_STRING); }
if (isset($_POST['list'])){$list = trim(filter_var($_POST['list'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['head'])){$head = trim(filter_var($_POST['head'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['state'])){$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING); } else { $state = ''; }

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';

session_start();

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SESSION['level'] >= 3){
	
	if (in_array($_SESSION['level'], array(3,5))) {
		$state = $_SESSION['state'];
	}
	
	if ($head == '') {
		$head = intval(0);
	}
	
	if (!isset($bulk)) {
		$bulk = false;
	}
	
	if ($type == "region" && $_SESSION['level'] != 3) {
		if ($bulk == "true") {
			if ($list == '') {
				echo "Please enter a bulk list.";
			} else {
				try {	
					$sorted = str_replace(array("; "), ";", $list);
					$sorted = str_replace(array(", "), ",", $sorted);
					$sorted = explode(",", $sorted);
					$db = new DbConn;
					$db->conn->setAttribute(PDO::ATTR_PERSISTENT, true);
					foreach ($sorted as $reg) {
						$i = 0;
						$regi = str_replace(array("{","}"), "", $reg);
						$info = explode(";", $regi);
						$regions_name = $info[0];
						$regions_code = $info[1];
						$regions_mayor = $info[2];
						if (!in_array($state, array(1,2,3,4,5,6,7,8,9,10))) {
							echo "Please select a valid state.";
							exit(1);
						} elseif (__lookup_region_name($regions_name, $state) > 0 && $regions_name == '') {
							echo "Please enter full and unique region names for all items of your bulk list.";
							exit(1);
						} elseif (__lookup_region_code($regions_code, $state) > 0 || $regions_code == '') {
							echo "Please enter valid region codes for your regions.";
							exit(1);
						} else {
							$region = $db->conn->prepare("INSERT INTO regions(name, code, state, mayor) VALUE (:name, :code, :state, :mayor)");
							$region->bindParam(':name', $regions_name);
							$region->bindParam(':code', $regions_code);
							$region->bindParam(':state', $state);
							$region->bindParam(':mayor', $regions_mayor);
							$region->execute();
							if ($regions_mayor != 0) {
								if (__lookup_level($regions_mayor) < 3) {
									$mayor = $db->conn->prepare("UPDATE members SET level = 3 WHERE id = :id");
									$mayor->bindParam(':id', $regions_mayor);
									$mayor->execute();
								}
							}
							
							$i++;
						}
					}
					echo "0";
					die(0);
				} catch (Exception $e) {
					echo "Error occurred during processing bulk list: " . $e->getMessage();
					die(0);
				}
			}
		} else {
			if ($head != '') {
				if (__lookup_user_name($head) == 0) {
					echo "Please enter a valid myTalk registered name for your mayor, or leave it blank for no mayor.";
					exit(1);
				}
			}
			
			if (!in_array($state, array(1,2,3,4,5,6,7,8,9,10))) {
				echo "Please select a valid state.";
			} elseif (__lookup_region_name($name, $state) > 0 || $name == '') {
				echo "Please enter a unique region name.";
			} elseif (__lookup_region_code($code, $state) > 0 || $code == '') {
				echo "Please enter a unique region code.";
			} else {
				if ($head != '') {
					$head = __lookup_name_id($head);
				} else {
					$head = 0;
				}
				$err = '';
				try {
					$bdb = new DbConn;
					$region = $bdb->conn->prepare("INSERT INTO regions(name, code, state, mayor) VALUE (:name, :code, :state, :mayor)");
					$region->bindParam(':name', $name);
					$region->bindParam(':code', $code);
					$region->bindParam(':state', $state);
					$region->bindParam(':mayor', $head);
					$region->execute();
					if ($head != 0) {
						if (__lookup_level($head) < 3) {
							$edb = new DbConn;
							$mayor = $edb->conn->prepare("UPDATE members SET level = 3 WHERE id = :id");
							$mayor->bindParam(':id', $head);
							$mayor->execute();
						}
					}
				} catch (Exception $e) {
					$err = $e->getMessage();
				}
				if ($err == '') {
					echo 0;
				} else {
					echo "Database occurred while trying to insert region: " . $err;
				}
			}
		}
	} elseif ($type == "chapter") {
		if ($bulk == "true") {
			if ($list == '') {
				echo "Please enter a bulk list.";
			} else {
				try {
					$sorted = str_replace(array("; "), ";", $list);
					$sorted = str_replace(array(", "), ",", $sorted);
					$sorted = explode(",", $sorted);
					$db = new DbConn;
					$db->conn->setAttribute(PDO::ATTR_PERSISTENT, true);
					foreach ($sorted as $chap) {
						$i = 0;
						$chapt = str_replace(array("{","}"), "", $chap);
						$info = explode(";", $chapt);
						$chapters_name = $info[0];
						$chapters_region = $info[1];
						$chapters_president = $info[2];
						if (!in_array($state, array(1,2,3,4,5,6,7,8,9,10))) {
							echo "Please select a valid state.";
							exit(1);
						} elseif (__lookup_chapter_name($chapters_name, $state) > 0 || $chapters_name == '') {
							echo "Please enter valid and unique chapter names for all items of your bulk list.";
							exit(1);
						} elseif (__lookup_region_name($chapters_region, $state) == 0 || $chapters_region == '') {
							echo "Please enter valid region names for your chapters.";
							exit(1);
						} else {
							$region_one = __lookup_region_id($chapters_region);
							$chap_region = $region_one['id'];
							$chapter = $db->conn->prepare("INSERT INTO chapters(name, region, state, president) VALUE (:name, :region, :state, :president)");
							$chapter->bindParam(':name', $chapters_name);
							$chapter->bindParam(':region', $chap_region);
							$chapter->bindParam(':state', $state);
							$chapter->bindParam(':president', $chapters_president);
							$chapter->execute();
							$i++;
						}
					}
					echo "0";
					die(0);
				} catch (Exception $e) {
					echo "Error occurred during processing bulk list: " . $e->getMessage();
					die(0);
				}
			}
		} else {
			if ($head != '') {
				if (__lookup_user_name($head) == 0) {
					echo "Please enter a valid myTalk registered name for your chapter president, or leave it blank for no president.";
				}	
			} elseif (!in_array($state, array(1,2,3,4,5,6,7,8,9,10))) {
				echo "Please select a valid state.";
			} elseif (__lookup_chapter_name($name, $state) > 0 || $name == '') {
				echo "Please enter a unique chapter name.";
			} else {
				if ($head != '') {
					$head = __lookup_name_id($head);
				} else {
					$head = 0;
				}
				
				$chap_id = $_SESSION['chapter'];
				
				if ($_SESSION['level'] == 3) {
					$db = new DbConn;
					$list = $db->conn->prepare("SELECT region FROM chapters WHERE id = :id");
					$list->bindParam(':id', $chap_id);
					$list->execute();
					$results = $list->fetch(PDO::FETCH_ASSOC);
					$region = $results['region'];
				} else {
					$region_one = __lookup_region_id($region);
					$chap_region = $region_one['id'];
				}
				$err = '';
				try {
					$bdb = new DbConn;
					$chapter = $bdb->conn->prepare("INSERT INTO chapters(name, region, state, president) VALUES (:name, :region, :state, :president)");
					$chapter->bindParam(':name', $name);
					$chapter->bindParam(':region', $chap_region);
					$chapter->bindParam(':state', $state);
					$chapter->bindParam(':president', $head);
					$chapter->execute();
				} catch (Exception $e) {
					$err = $e->getMessage();
				}
				if ($err == '') {
					echo 0;
				} else {
					echo "Database occurred while trying to insert chapter: " . $err;
				}
				
			}
		}
	} else {
		echo "Invalid type.";
	}
	
} else {
	echo "Invalid type.";
}

?>