<?php 

function home($base, $fileDir){ 
	include 'header.php';
		
	include 'templates/header.php'; ?>

		<link href="css/signin.css" rel="stylesheet">
		<title>myTalk</title>
	</head>

	<body class="text-center">
		<form class="form-signin">
			<a href="<?php echo $base . $fileDir; ?>" style="color: initial; border-bottom: none"><img class="mb-4" src="images/logo.png" alt="" width="150" height="150"></a>
			<h1 style="color: white" class="font-weight-normal">myTalk</h1>
			<h1 style="color: white" class="h5 mb-3 font-weight-normal"><?php if (isset($_SESSION['email'])) { ?>Welcome back, <?php echo $_SESSION['first'] . "!"; } else { ?>The innovative debate solution.<?php } ?></h1>
			<?php if (isset($_SESSION['email'])) { ?>
				<?php if ($_SESSION['chapter'] != 0) { ?>
					<hr>
					<p style="color: white; margin-top: 10px;">View and register for debates in upcoming events in your state.</p>
					<a href="debates" class="btn btn-lg btn-success btn-block">View Debates</a>
					<hr>
					<p style="color: white; margin-top: 10px;">Check out your chapter homepage, see your classmates' debates, and talk to your chapter president.</p>
					  <a href="chapter" class="btn btn-lg btn-primary btn-block">Chapter Homepage</a>
				<?php } ?>
				<hr>
				<p style="color: white; margin-top: 10px;">Manage your account information, and view your current settings.</p>
				  <a href="account" class="btn btn-lg btn-primary btn-block">Account Settings</a>
				<?php if ($_SESSION['level'] >= 2) { ?>
					<hr style="height: 5px;">
					<p style="color: white; margin-top: 10px;"><?php echo PANEL_DESCRIPTIONS[$_SESSION['level']-1]?></p>
					  <a href="<?php echo PANEL_URLS[$_SESSION['level']-1]?>" class="btn btn-lg btn-danger btn-block" target="_blank"><?php echo PANELS[$_SESSION['level']-1]?></a>
					<hr style="height: 5px;">
					<a href="logout" class="btn btn-lg btn-light btn-block">Log out</a>
				<?php } else { ?>
				<hr>
				<a href="logout" class="btn btn-lg btn-light btn-block">Log out</a>
			<?php } } else { ?>
				<p style="color: white; margin-top: 10px;">View the debates in your state and book a spot without logging in.</p>
				<a href="debates" class="btn btn-lg btn-success btn-block">View Debates</a>
				<hr>
				<p style="color: white; margin-top: 10px;">Login to your account and access your debates and personal information.</p>
			  	<a href="login" class="btn btn-lg btn-primary btn-block">Sign in</a>
				<hr>
				<p style="color: white; margin-top: 10px;">If you have not created an account, please register before signing in.</p>
				<a href="register" class="btn btn-lg btn-primary btn-block">Register</a>
				<hr>
			<?php } ?>
		  <?php include 'templates/footer.php'; ?>
		</form>
		<?php include 'templates/javascript.php'; ?>
	</body>
	</html>
<?php } ?>