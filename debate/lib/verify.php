<?php 

//Verification form

function verify($code, $base, $fileDir){ 
include 'header.php';
		
	?>
		<?php include 'templates/header.php'; ?>
		<link href="css/signin.css" rel="stylesheet">
		<title>Verify | myTalk</title>
	</head>

	<body class="text-center">
		<form class="form-signin">
		  <a href="<?php echo $base . $fileDir; ?>" style="color: initial; border-bottom: none"><img class="mb-4" src="images/logo.png" alt="" width="150" height="150"></a>
			<h1 style="color: white" class="font-weight-normal">Verify Account</h1><br>
			<?php if ($code === 0){?>
				<h1 style="color: white" class="h4 mb-3 font-weight-normal">Please enter a valid code.</h1>
				<hr>
				<a href="<?php echo $base . $fileDir ; ?>" class="btn btn-lg btn-success btn-block">Go home</a>
			<?php }	else { 
			
			$search = __lookup_code($code);
		
				if ($search === 1) {
					try {
						$err = '';
						$db = new DbConn;
						$test = $db->conn->prepare("UPDATE members SET verified = 1 WHERE verified_code = :code");
						$test->bindParam(':code', $code);	
						$test->execute();
						
						$rdb = new DbConn;
						$rtest = $rdb->conn->prepare("UPDATE members SET verified_code = NULL WHERE verified_code = :code");
						$rtest->bindParam(':code', $code);	
						$rtest->execute();
					} catch (Exception $e) {
						$err = $e->getMessage();
					}
					
					if ($err == '') {
						?>
							<h1 style="color: white" class="h4 mb-3 font-weight-normal">Your email was successfully verified. Please use the link below to proceed to the login.</h1>
							<hr>
							<a href="<?php echo $base . $fileDir . "/login"; ?>" class="btn btn-lg btn-success btn-block">Go to login</a>
						<?php 
					} else {
						?>
							<h1 style="color: white" class="h4 mb-3 font-weight-normal">An error occurred during verification. Please try again later.</h1>
							<hr>
							<a href="<?php echo $base . $fileDir ; ?>" class="btn btn-lg btn-success btn-block">Go home</a>	
						<?php 
					}
				} elseif ($search === 0) { ?>
				<h1 style="color: white" class="h4 mb-3 font-weight-normal">Invalid code.</h1>
				<hr>
				<a href="<?php echo $base . $fileDir ; ?>" class="btn btn-lg btn-success btn-block">Go home</a>
			<?php } elseif ($search === 2) { ?>
				<h1 style="color: white" class="h4 mb-3 font-weight-normal">Error occurred during code validation check. Please try again later.</h1>
				<hr>
				<a href="<?php echo $base . $fileDir ; ?>" class="btn btn-lg btn-success btn-block">Go home</a>	
			<?php	
				}
			} 
			
			?>
		  <?php include 'templates/footer.php'; ?>
		</form>

		<?php include 'templates/javascript.php'; ?>
	</body>
	</html>
	<?php } ?>
