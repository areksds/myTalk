<?php 

if (isset($_POST['type'])){$type = filter_var($_POST['type'], FILTER_SANITIZE_STRING); }
if (isset($_POST['name'])){$name = trim(filter_var($_POST['name'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['id'])){$id = trim(filter_var($_POST['id'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['region'])){$region = trim(filter_var($_POST['region'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['code'])){$code = filter_var($_POST['code'], FILTER_SANITIZE_STRING); }
if (isset($_POST['head'])){$head = trim(filter_var($_POST['head'], FILTER_SANITIZE_STRING)); }
if (isset($_POST['state'])){$state = filter_var($_POST['state'], FILTER_SANITIZE_STRING); } else { $state = ''; }

require __DIR__ . '/dbconn.php';
require __DIR__ . '/test_conn.php';

session_start();

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' && $_SESSION['level'] >= 3){ 
	
	$changes = 0;
	$errors = 0;
	
	if (in_array($_SESSION['level'], array(3,5))) {
		$state = $_SESSION['state'];
	}
	
	if ($head == '') {
		$head = intval(0);
	}
	
	if ($type == "region" && $_SESSION['level'] != 3) {

			if ($head != '') {
				if (__lookup_user_name($head) == 0) {
					echo "Please enter a valid myTalk registered name for your mayor, or leave it blank for no mayor.";
					exit(1);
				}
			}
			
			if (!in_array($state, array(1,2,3,4,5,6,7,8,9,10))) {
				echo "Please select a valid state.";
			} elseif (__lookup_region_name($name, $state) > 0 && $name != '') {
				echo "Please enter a unique region name.";
			} elseif (__lookup_region_code($code, $state) > 0 && $code != '') {
				echo "Please enter a unique region code.";
			} else {
				if ($head != '') {
					$head = __lookup_name_id($head);
				} else {
					$head = 0;
				}
				if ($name != '') {
					try {
						$old = __lookup_region_name_id($id);
						
						$err = '';
						$rdb = new DbConn;
						$rtest = $rdb->conn->prepare("UPDATE regions SET name = :name WHERE id = :id");
						$rtest->bindParam(':name', $name);
						$rtest->bindParam(':id', $id);	
						$rtest->execute();
						
						$xdb = new DbConn;
						$xtest = $xdb->conn->prepare("UPDATE chapters SET region = :name WHERE region = :old");
						$xtest->bindParam(':name', $name);
						$xtest->bindParam(':old', $old);	
						$xtest->execute();
					} catch (Exception $e) {
						$err = $e->getMessage();
					}

					if ($err == '') {
						$changes++;
					} else {
						$errors++;
					}
				} 
				
				if ($code != '') {
					try {
						$err = '';
						$edb = new DbConn;
						$etest = $edb->conn->prepare("UPDATE regions SET code = :code WHERE id = :id");
						$etest->bindParam(':code', $code);
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
				
				if ($head != '') {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("UPDATE regions SET mayor = :mayor WHERE id = :id");
						$test->bindParam(':mayor', $head);
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
				
				
				if ($changes > 0 && $errors == 0) {
					echo "0";
				} else {
					if ($errors > 0) {
						echo "1";
					}
				}
			}
	} elseif ($type == "chapter") {
			if ($head != '') {
				if (__lookup_user_name($head) == 0) {
					echo "Please enter a valid myTalk registered name for your chapter president, or leave it blank for no president.";
					exit(1);
				}	
			}
		
			if (!in_array($state, array(1,2,3,4,5,6,7,8,9,10))) {
				echo "Please select a valid state.";
			} elseif (__lookup_chapter_name($name, $state) != 0 && $name != '') {
				echo "Please enter a unique chapter name.";
			} else {
				
				if ($head != '') {
					$head = __lookup_name_id($head);
				} else {
					$head = "0";
				}
				
				if ($name != '') {
					try {
						$err = '';
						$rdb = new DbConn;
						$rtest = $rdb->conn->prepare("UPDATE chapters SET name = :name WHERE id = :id");
						$rtest->bindParam(':name', $name);
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
				
				if ($head != '') {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("UPDATE chapters SET president = :president WHERE id = :id");
						$test->bindParam(':president', $head);
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
				
				if ($_SESSION['level'] > 3) {
				
					if ($region != '') {
						try {
							$err = '';
							$edb = new DbConn;
							$etest = $edb->conn->prepare("UPDATE chapters SET region = :region WHERE id = :id");
							$etest->bindParam(':region', $region);
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
				
				if ($changes > 0 && $errors == 0) {
					echo "0";
				} else {
					if ($errors > 0) {
						echo "1";
					}
				}
	
		}
	}
}



?>