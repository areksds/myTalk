<?php 

// Keeps things so simple! Just a single function for each type of page.

function generateLogin($base, $fileDir, $redirect){ 
include 'header.php';
		
	?>
		<?php include 'templates/header.php'; ?>
		<link href="<?php echo $fileDir; ?>/css/signin.css" rel="stylesheet">
		<title>Login | myTalk</title>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>

	<body class="text-center">
		<form class="form-signin">
			<a href="<?php echo $base . $fileDir; ?>" style="color: initial; border-bottom: none"><img class="mb-4" src="<?php echo $fileDir; ?>/images/logo.png" alt="" width="150" height="150"></a>
			<h1 style="color: white" class="font-weight-normal">myTalk</h1>
		  <h1 style="color: white" class="h3 mb-3 font-weight-normal">Please sign in</h1>
		  <label for="inputEmail" class="sr-only">Email address</label>
		  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
		  <label for="inputPassword" class="sr-only">Password</label>
		  <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
			<button data-sitekey="<?php echo $config['recaptcha']['sitekey'];?>" type="submit" id="submit" class="g-recaptcha btn btn-lg btn-primary btn-block" data-callback='submit'>Sign In</button>
			<a href="<?php echo $fileDir . "/"; ?>register" class="btn btn-lg btn-light btn-block">Register</a><br>
			<div id="message"></div>
			<a href="<?php echo $fileDir . "/"; ?>forgot">Forgot password</a>
		  <?php include 'templates/footer.php'; ?>
		</form>
		<script>
			function submit(){
				document.getElementById("submit").setAttribute("disabled","");
				$.ajax({
						url:"<?php echo $fileDir . "/"; ?>lib/functions/login.php", 
						type: "post",
						data: "email=" + $('#inputEmail').val() + "&password=" + $('#inputPassword').val() + "&recaptcha=" + grecaptcha.getResponse() + "&fileDir=" + "<?php echo $fileDir;?>",
						dataType: 'html',
						success:function(data){
							if (data.indexOf("alert-danger") > -1) {
								document.getElementById("submit").removeAttribute("disabled");
								document.getElementById("message").innerHTML = data;
								grecaptcha.reset();
							} else {
								document.getElementById("message").innerHTML = data;
								<?php if ($redirect === 0) {?>
									window.location.href = '<?php echo $base . $fileDir; ?>';
								<?php } else { ?>
									window.location.href = '<?php echo $base . $fileDir . "/" . $redirect; ?>';
								<?php } ?>
							}
					   },
						beforeSend:function () {
							$("#message").html("<p class='text-center'><img src='<?php echo $fileDir . "/"; ?>images/ajax-loader.gif'></p>");
						}
					});
			}
		</script>

		<?php include 'templates/javascript.php'; ?>
	</body>
	</html>
	<?php } ?>
