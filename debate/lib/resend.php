<?php 

	function resend($base, $fileDir) { 
	include 'header.php';
						   
?>
	<?php include 'templates/header.php'; ?>
	<link href="<?php echo $fileDir; ?>/css/signin.css" rel="stylesheet">
	<title>Resend Verification</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>

	<body class="text-center">
		<form class="form-signin">
			<h1 style="color: white" class="font-weight-normal">Resend Verification</h1><br>
			<h1 style="color: white" class="h4 mb-3 font-weight-normal">Please enter your email address below.</h1><br>
			<input type="text" id="email" class="form-control" placeholder="Email" autofocus="" <?php if(isset($_GET['email'])){ echo "value=\"" . filter_var($_GET['email'], FILTER_SANITIZE_STRING) . "\"";}?></input><br> 
		  <button data-sitekey="<?php echo $config['recaptcha']['sitekey'];?>" type="submit" id="submit" class="g-recaptcha btn btn-lg btn-success btn-block" data-callback='submit'>Submit</button>
			<a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-light btn-block">Go home</a><br>
			<div id="message"></div>
		  <?php include 'templates/footer.php'; ?>
		</form>
		<?php include 'templates/javascript.php'; ?>
		<script src="<?php echo $fileDir; ?>/js/resend.js"></script>
	</body>
	</html>
<?php } ?>