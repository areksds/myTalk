<?php 

//Tests the database connection as defined in configuration

function __test(){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SHOW TABLES");
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
        $err = "Database connection error occurred:<br>" . $e->getMessage();
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result == 10 || $result == 1){
			return 1;
		} else {
			return "Database corrupted, please reinstall on a clean database. Error code: " . $result;
		}
	} else {
		return $err;
	}
	
}

function __lookup_user_id($id){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM members WHERE id = :id");
		$test->bindParam(':id', $id);	
		$test->execute();
		$rows = $test->rowCount();
		$result = $test->fetch(PDO::FETCH_ASSOC);
	
	} catch (Exception $e) {
		$err = 1;
        return $err;
    }
	
	if ($err == '') {
		if($rows != 0) {
			return $result;
		} else {
			return 0;
		}
	}
	
}

function __lookup_user($information){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM members WHERE email = :email");
		$test->bindParam(':email', $information);	
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
		$err = 2;
        return $err;
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result >= 1){
			return 1;
		} else {
			return 2;
		}
	} else {
		return 2;
	}
	
}

function __lookup_user_name($information){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM members WHERE fullname = :name");
		$test->bindParam(':name', $information);	
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
		$err = 2;
        return $err;
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result >= 1){
			return 1;
		} else {
			return 2;
		}
	} else {
		return 2;
	}
	
}

function __lookup_chapter_name($information, $state){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM chapters WHERE name = :name AND state = :state");
		$test->bindParam(':name', $information);
		$test->bindParam(':state', $state);
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
        return 2;
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result >= 1){
			return 1;
		} else {
			return 2;
		}
	} else {
		return 2;
	}
	
}

function __lookup_region_name($information, $state){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM regions WHERE name = :name AND state = :state");
		$test->bindParam(':name', $information);
		$test->bindParam(':state', $state);
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
		$err = 2;
        return $err;
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result >= 1){
			return 1;
		} else {
			return 2;
		}
	} else {
		return 2;
	}
	
}


function __lookup_code($code){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM members WHERE (verified_code = :code AND verified = 0)");
		$test->bindParam(':code', $code);	
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
		$err = 2;
        return $err;
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result == 1){
			return 1;
		} else {
			return 2;
		}
	} else {
		return 2;
	}
	
}

function __lookup_region_code($information, $state){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM regions WHERE code = :code AND state = :state");
		$test->bindParam(':code', $information);	
		$test->bindParam(':state', $state);
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
		$err = 2;
        return $err;
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result >= 1){
			return 1;
		} else {
			return 2;
		}
	} else {
		return 2;
	}
	
}


function __lookup_forgot_code($code){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM members WHERE (verified_code = :code AND verified = 1)");
		$test->bindParam(':code', $code);	
		$test->execute();
		$result = $test->rowCount();
	
	} catch (Exception $e) {
		$err = 2;
        return $err;
    }
	
	if ($err == '') {
		if ($result == 0) {
			return 0;
		} elseif ($result == 1){
			return 1;
		} else {
			return 2;
		}
	} else {
		return 2;
	}
	
}

function __lookup_chapter($id){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT * FROM chapters WHERE id = :id");
		$test->bindParam(':id', $id);	
		$test->execute();
		$result = $test->fetch(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		$err = 1;
        return $err;
    }
	
	if ($err == '') {
		return $result;
	}
	
}

function __lookup_name_id($information){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT id FROM members WHERE fullname = :fullname");
		$test->bindParam(':fullname', $information);	
		$test->execute();
		$result = $test->fetch(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		$err = 1;
        return $err;
    }
	
	if ($err == '') {
		return $result['id'];
	}
	
}

function __lookup_region_id($information){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT id FROM regions WHERE name = :name");
		$test->bindParam(':name', $information);	
		$test->execute();
		$result = $test->fetch(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		$err = 1;
        return $err;
    }
	
	if ($err == '') {
		return $result['id'];
	}
	
}

function __lookup_region_name_id($information){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT name FROM regions WHERE id = :id");
		$test->bindParam(':id', $information);	
		$test->execute();
		$result = $test->fetch(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		$err = 1;
        return $err;
    }
	
	if ($err == '') {
		if (count($result) > 0) {
			return $result['name'];
		} else {
			$result['name'] = "Deleted";
			return $result['name'];
		}
		
	}
	
}

function __lookup_region_code_id($information){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT code FROM regions WHERE id = :id");
		$test->bindParam(':id', $information);	
		$test->execute();
		$result = $test->fetch(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		$err = 1;
        return $err;
    }
	
	if ($err == '') {
		if (count($result) > 0) {
			return $result['code'];
		} else {
			$result['code'] = "Deleted";
			return $result['code'];
		}
		
	}
	
}

function __lookup_level($id){

	try {
		$db = new DbConn;
		$err = '';
		$test = $db->conn->prepare("SELECT level FROM members WHERE id = :id");
		$test->bindParam(':id', $id);	
		$test->execute();
		$result = $test->fetch(PDO::FETCH_ASSOC);
		
	} catch (Exception $e) {
		$err = 1;
        return $err;
    }
	
	if ($err == '') {
		return $result['level'];
	}
	
}




?>