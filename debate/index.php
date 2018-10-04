<?php 

session_start();

if (dirname($_SERVER["PHP_SELF"]) != "/") {
	$fileDir = dirname($_SERVER["PHP_SELF"]);
} else {
	$fileDir = '';
}

setcookie("SITE",$fileDir);

if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
	$base = 'https://' . $_SERVER["SERVER_NAME"];
} else {
	$base = 'https://' . $_SERVER["SERVER_NAME"];
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
}


require 'lib/functions/dbconn.php';
require 'lib/functions/test_conn.php';
require 'lib/err.php';

$sql_test = __test();

if ($sql_test === 0) {
	require 'lib/install.php';
	
	generateInstall($base, $fileDir);
} elseif (file_exists("lib/installer/upgrade.sql")) {
	require 'lib/install.php';
	
	generateUpgrade($base, $fileDir);
} elseif ($sql_test === 1) {
	require 'lib/functions/functions.php';
	require 'lib/login.php';
	require 'lib/register.php';
	require 'lib/resend.php';
	require 'lib/home.php';
	require 'lib/verify.php';
	require 'lib/forgot.php';
	require 'lib/account.php';
	require 'lib/admin.php';
	require 'lib/users.php';
	require 'lib/settings.php';
	require 'lib/events.php';
	require 'lib/queue.php';
	
	if (isset($_GET['path'])){
		
		$_GET['path'] = strtolower($_GET['path']);
		
		if(substr($_GET['path'], -1) == "/") {
			$_GET['path'] = substr($_GET['path'], 0, -1);
			header("location:" . $base . $fileDir . "/" . $_GET['path']);
		} 
		
		if(strpos($_GET['path'], "/")) {
			$path = explode("/", $_GET['path'], 2);
		}
		
		// START LOGIN PAGE
		if ($_GET['path'] == 'login') {
			if (isset($_SESSION['email'])) {
				header("location:$base$fileDir");
			} else {
				if (isset($_GET['redirect'])){
					generateLogin($base, $fileDir, $_GET['redirect']);
				} else {
					generateLogin($base, $fileDir, 0);
				}
			}
		// END LOGIN PAGE
			
		// START REGISTER PAGE
		} elseif ($_GET['path'] == 'register') {
			if (isset($_SESSION['email'])) {
				header("location:$base$fileDir");
			} else {
				generateRegister($base, $fileDir);
			}
		// END REGISTER PAGE	
		
		// START FORGOT PAGE
		} elseif ($_GET['path'] == 'forgot') {
			if (isset($_GET['code'])) {
				recover($_GET['code'], $base, $fileDir);
			} else {
				if (isset($_SESSION['email'])) {
					header("location:$base$fileDir");
				} else {
					forgot($base, $fileDir);
				}
			}
		// END FORGOT PAGE
		
		// START VERIFY PAGE	
		} elseif ($_GET['path'] == 'verify') {
			if (isset($_GET['code'])) {
				verify($_GET['code'], $base, $fileDir);
			} else {
				verify(0, $base, $fileDir);
			}
		// END VERIFY PAGE
			
		// START RESEND PAGE
		} elseif ($_GET['path'] == 'resend') {
			if (isset($_SESSION['email'])) {
				header("location:$base$fileDir");
			} else {
				resend($base, $fileDir);
			}
		// END RESEND PAGE	
			
		// START ACCOUNT SETTINGS PAGE	
		} elseif ($_GET['path'] == 'account') {
			if (isset($_SESSION['email'])) {
				account($base, $fileDir);
			} else {
				header("location:" . $base . $fileDir . "/login&redirect=account");
			}
		// END ACCOUNT SETTINGS PAGE	
		
		// START ADMIN PANEL	
		} elseif (in_array($_GET['path'],PANEL_URLS) && $_GET['path'] != NULL) {
			if (isset($_SESSION['email'])) {
				if (PANEL_URLS[$_SESSION['level'] - 1] == $_GET['path']) {
					admin($_GET['path'], $base, $fileDir);
				} else {
					error(403, 0, $fileDir, $base);
				}
			} else {
				header("location:" . $base . $fileDir . "/login&redirect=admin");
			}
		// END ADMIN PANEL	
			
		} elseif (isset($path)) {
			
			// START ADMIN PAGES
			if (in_array($path[0],PANEL_URLS) && $path[0] != NULL) {
				if (isset($_SESSION['email'])) {
					if (PANEL_URLS[$_SESSION['level'] - 1] == $path[0]) {
						// START USERS PANEL
						if ($path[1] === "users") {
							if (in_array($_SESSION['level'],array(4,5,6,7))) {
								adminUsers($path[0], $base, $fileDir);
							} else {
								error(403, 0, $fileDir, $base);
							}
						// START SETTINGS PANEL	
						} elseif ($path[1] === "settings") {
							if (in_array($_SESSION['level'],array(3,5,6,7))) {
								adminSettings($path[0], $base, $fileDir);
							} else {
								error(403, 0, $fileDir, $base);
							}
						// START EVENTS PANEL	
						} elseif ($path[1] === "events") {
							adminEvents($path[0], $base, $fileDir);
						// START QUEUE PANEL
						} elseif ($path[1] === "queue") {
							if (in_array($_SESSION['level'],array(3,4,5,6,7))) {
								adminQueue($path[0], $base, $fileDir);
							} else {
								error(403, 0, $fileDir, $base);
							}
						} else {
							error(404, strip_tags($_GET['path']), $fileDir, $base);
						}
					} else {
						error(404, strip_tags($_GET['path']), $fileDir, $base);
					}
				} else {
					header("location:" . $base . $fileDir . "/login&redirect=".$_GET['path']);
				}
			// END ADMIN PAGES	
			} else {
				error(404, strip_tags($_GET['path']), $fileDir, $base);
			}
			
		
		// INITIATE LOGOUT	
		} elseif ($_GET['path'] == 'logout') {
			session_destroy();
			header("location:$base$fileDir");
			
		// PATH NOT FOUND	
		} else {
				error(404, strip_tags($_GET['path']), $fileDir, $base);
		}
	} elseif(isset($_GET['error'])) {
		// ERROR HANDLERS
		
		// ERROR 403
		if ($_GET['error'] == '403') {
			error(403, 0, $fileDir, $base);
		}
	} else {
		home($base, $fileDir);
	}
} else {
	error("SQL", $sql_test, $fileDir, $base);
}

?>

