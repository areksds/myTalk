<?php 

session_start();

if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){ 
	if (!isset($_SESSION['id'])) {
		echo 0;
	}
}

?>