<?php 

require __DIR__ . '/../functions/dbconn.php';
require __DIR__ . '/../functions/test_conn.php';

try {
	if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')	{	
		
		if (!extension_loaded('pdo')) {
			echo "The PDO extension is disabled on your host server. Please enable it in order to install the server.";
		} elseif(__test() != 0) {
			echo "The database is already installed or has content in it, please refresh or use a new database.";
		} else {
			try {

				$db = new DbConn;
				$err = '';
				$sql = file_get_contents(__DIR__ . '/install.sql');
				$install = $db->conn->prepare($sql);
				$install->execute();

			} catch (Exception $e) {

				$err = $e->getMessage();

			}

			if ($err == '') {
				$test_install = __test();
				if ($test_install == 0) {
					echo "Installation failed. Please try again, and check your database permissions.";
				} elseif ($test_install == 1) {
					echo "1";
				} else {
					echo $test_install;
				}
			} else {
				echo "An error occured during the installation: " . $err . "";
			}

		}
	}
} catch (Exception $e) {
	$err = $e->getMessage();
	echo "An error occured during the installation: " . $err . "";
}



?>