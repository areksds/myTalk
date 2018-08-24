<?php 

	function forgot($base, $fileDir) { 
	include 'header.php';
						   
?>
	<?php include 'templates/header.php'; ?>
	<link href="<?php echo $fileDir; ?>/css/signin.css" rel="stylesheet">
	<title>Forgot Password</title>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>

	<body class="text-center">
		<form class="form-signin">
			<h1 style="color: white" class="font-weight-normal">Forgot password</h1><br>
			<h1 style="color: white" class="h4 mb-3 font-weight-normal">Please enter your email address below.</h1><br>
			<input type="text" id="email" class="form-control" placeholder="Email" autofocus=""><br>
		  <button data-sitekey="<?php echo $config['recaptcha']['sitekey'];?>" type="submit" id="submit" class="g-recaptcha btn btn-lg btn-success btn-block" data-callback='submit'>Submit</button>
			<a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-light btn-block">Go home</a><br>
			<div id="message"></div>
		  <?php include 'templates/footer.php'; ?>
		</form>
		<script src="<?php echo $fileDir; ?>/js/forgot.js"></script>
		<?php include 'templates/javascript.php'; ?>
	</body>
	</html>
<?php 
		}

	function recover($code, $base, $fileDir) { 
	include 'header.php'; ?>

	<?php include 'templates/header.php'; ?>
	<title>Reset Password</title>
	<style>
		html,
		body {
		  height: 100%;
		}

		body {
		  display: -ms-flexbox;
		  display: flex;
		  -ms-flex-align: center;
		  align-items: center;
		  padding-top: 40px;
		  padding-bottom: 40px;
		  background: rgb(95,83,146);
		}

		.form-signin {
		  width: 100%;
		  max-width: 330px;
		  padding: 15px;
		  margin: auto;
		}
		.form-signin .checkbox {
		  font-weight: 400;
		}
		.form-signin .form-control {
		  position: relative;
		  box-sizing: border-box;
		  height: auto;
		  padding: 10px;
		  font-size: 16px;
		}
		.form-signin .form-control:focus {
		  z-index: 2;
		}
		
		.form-signin .password1 {
		  margin-bottom: -1px;
		  border-bottom-right-radius: 0;
		  border-bottom-left-radius: 0;
		}

		.form-signin .password2 {
		  margin-bottom: 10px;
		 border-top-left-radius: 0;
			border-top-right-radius: 0;
		}
		
		a {
			-moz-transition: color 0.2s ease, border bottom 0.2s ease;
			-webkit-transition: color 0.2s ease;
			-ms-transition: color 0.2s ease;
			transition: color 0.2s ease;
			text-decoration: none;
			border-bottom: dotted 1px;
			color: white;
		}

		a:hover {
			border-bottom-color: transparent;
			text-decoration: none;
			border-bottom: none;
			color: lightgray;
		}

		hr {
			background-color: lightgray;
		}
	</style>
	</head>
	<?php if ($code == '') { ?>
	<body class="text-center">
		<form class="form-signin">
			<h1 style="color: white" class="font-weight-normal">Forgot password</h1><br>
			<h1 style="color: white" class="h4 mb-3 font-weight-normal">Please enter a valid code.</h1>
			<hr>
		  <a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-success btn-block">Go home</a><br>
		  <?php include 'templates/footer.php'; ?>
		</form>
		<?php } elseif (__lookup_forgot_code($code) == 1) {?>
		<body class="text-center">
		<form class="form-signin" method="post" id="register" action="lib/functions/recover.php">
			<h1 style="color: white" class="font-weight-normal">Forgot password</h1><br>
			<h1 style="color: white" class="h4 mb-3 font-weight-normal">Please enter your new password, twice.</h1><br>
			<input type="password" id="inputPassword" class="form-control password1 initial" placeholder="Password" required>
				<input type="password" id="repeatPassword" class="form-control password2 repeat" placeholder="Repeat password" required>
			<div id="incorrect-repeat" class="invalid-feedback"></div><br>
		  <button type="submit" id="submit" class="btn btn-lg btn-success btn-block">Reset password</button>
		<a href="<?php echo $base . $fileDir; ?>" id="home" class="btn btn-lg btn-success btn-block" style="display: none">Go home</a><br>
		 <div id="message"></div>
			<?php include 'templates/footer.php'; ?>
		</form>
		<?php include 'templates/javascript.php'; ?>
		<script src="<?php echo $fileDir; ?>/js/recover.js"></script>
		<?php } else { ?>
			<body class="text-center">
		<form class="form-signin">
			<h1 style="color: white" class="font-weight-normal">Forgot password</h1><br>
			<h1 style="color: white" class="h4 mb-3 font-weight-normal">Invalid code. Please try resubmitting the forgot password code.</h1>
			<hr>
		  <a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-success btn-block">Go home</a><br>
		  <?php include 'templates/footer.php'; ?>
		</form>
				<?php include 'templates/javascript.php'; ?>
	</body>
	</html>
		
	
<?php } } ?>