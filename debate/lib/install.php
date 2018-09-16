<?php 

// Installation page

function generateInstall($base, $fileDir){ 
include 'header.php';
		
	?>
		<?php include 'templates/header.php'; ?>
		<link href="css/signin.css" rel="stylesheet">
		<title>Install | myTalk</title>
	</head>
	<body class="text-center">
		<form class="form-signin">
			<img class="mb-4" src="images/logo.png" alt="" width="150" height="150">
			<h1 style="color: white" class="h3 mb-3 font-weight-normal">Your credentials check out, and the database is empty. Let's install the needed tables.</h1>
			<br>
		  <button onclick="install()" id="installation" class="btn btn-lg btn-success btn-block">Install</button>
			<br><div id="error"></div>
		  <?php include 'templates/footer.php'; ?>
		</form>

		<?php include 'templates/javascript.php'; ?>
		<script src="<?php echo $fileDir; ?>/js/install.js"></script>
	</body>
	
	</html>
<?php } 

function generateUpgrade($base, $fileDir){ 
include 'header.php';
		
	?>
		<?php include 'templates/header.php'; ?>
		<link href="css/signin.css" rel="stylesheet">
		<title>Upgrade | myTalk</title>
	</head>
	<body class="text-center">
		<form class="form-signin">
			<img class="mb-4" src="images/logo.png" alt="" width="150" height="150">
			<h1 style="color: white" class="h3 mb-3 font-weight-normal">Click upgrade to update your myTalk installation to the next version.</h1>
			<br>
		  <button onclick="install()" id="installation" class="btn btn-lg btn-success btn-block">Upgrade</button>
			<br><div id="error"></div>
		  <?php include 'templates/footer.php'; ?>
		</form>

		<?php include 'templates/javascript.php'; ?>
		<script src="<?php echo $fileDir; ?>/js/upgrade.js"></script>
	</body>
	
	</html>
<?php } ?>