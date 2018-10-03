<?php 

	function account($base, $fileDir) { 
	include 'header.php';
						   
?>
	<?php include 'templates/header.php'; ?>
	<link href="<?php echo $fileDir; ?>/css/account.css" rel="stylesheet">
	<title>Account Settings</title>
	</head>

	<body class="text-center">
		<form class="account">
			<a href="<?php echo $base . $fileDir; ?>" style="color: initial; border-bottom: none"><img class="mb-4" src="<?php echo $fileDir; ?>/images/logo.png" alt="" width="150" height="150"></a>
			<h1 style="color: white" class="font-weight-normal">Account Settings</h1><br>
			<div class="category">
				<legend>Email</legend>
				<i style="color: white">Change your email address. (password required, email must be verified upon change)</i><br><br>
				<input type="text" id="email" class="first form-control" placeholder="<?php echo $_SESSION['email']; ?>" autofocus="">
				<input type="password" id="email-password" class="last form-control" placeholder="Enter password" autofocus="">
			</div><br>
			<div class="category">
				<legend>Name</legend>
				<i style="color: white">Edit your name.</i><br><br>
				<input type="text" id="first" class="first form-control" placeholder="<?php echo $_SESSION['first']; ?>" autofocus="">
				<input type="text" id="last" class="last form-control" placeholder="<?php echo $_SESSION['last']; ?>" autofocus="">
			</div><br>
			<div class="category">
				<legend>Phone</legend>
				<i style="color: white">Add or edit your number.</i><br><br>
				<input type="text" id="phone" class="form-control" placeholder="<?php if (isset($_SESSION['phone'])) { echo $_SESSION['phone']; } else { echo "Phone number"; } ?>" autofocus="">
			</div><br>
			<div class="category">
				<legend>Password</legend>
				<i style="color: white">Change your account password. (current password needed)</i><br><br>
				<input type="password" id="current-password" class="form-control first" placeholder="Current password" autofocus="">
				<input type="password" id="password" class="form-control middle" placeholder="Enter new password" autofocus="">
				<input type="password" id="repeat-password" class="form-control last" placeholder="Repeat new password" autofocus="">
			</div><br>
			<div class="category">
				<legend>Chapter & Graduation</legend>
				<i style="color: white">View chapter and graduation year. <a href="mailto:<?php echo $config['support']; ?>">Contact the site admin</a> to change.</i><br><br>
				<?php if ($_SESSION['chapter'] != 0) { $result = __lookup_chapter($_SESSION['chapter']); ?>
					<textarea <?php if (strlen($result['name']) >= 24) { ?> rows="<?php echo round(strlen($result['name'])/24); ?>" <?php } else { ?> rows="1" <?php } ?> id="chapter" class="first form-control" placeholder="<?php echo $result['name'];?>" autofocus="" disabled></textarea>
				<?php } else { ?>
					<input type="text" id="chapter" class="last form-control" placeholder="Staff account" autofocus="" disabled>
				<?php } ?>
				<input type="text" id="graduation" class="last form-control" placeholder="<?php if ($_SESSION['graduation'] != 0) { echo $_SESSION['graduation']; } else { echo "Staff account"; } ?>" autofocus="" disabled>
			</div><br>
			<div class="category">
				<legend>Information</legend>
				<i style="color: white">Information about your account. <a href="mailto:<?php echo $config['support']; ?>">Contact the site admin</a> for help.</i><br><br>
				<p style="color: white"><b>Account ID: </b><?php echo $_SESSION['id']; ?></p>
				<p style="color: white"><b>State: </b><?php echo STATES[$_SESSION['state'] - 1]; ?></p>
				<p style="color: white"><b>Region: </b><?php $region = __lookup_region_name_id($result['region']); echo $region['name']; ?></p>
				<p style="color: white"><b>Permission level: </b><?php echo PERMISSIONS[$_SESSION['level'] - 1]; ?></p>
			</div><br>
		  <button type="submit" id="submit" class="btn btn-lg btn-success btn-block" disabled>Save</button>
			<a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-light btn-block">Go home</a><br>
			<div id="message"></div>
		  <?php include 'templates/footer.php'; ?>
		</form>
		<?php include 'templates/javascript.php'; ?>
		<?php include 'templates/session.php'; ?>
		<script src="<?php echo $fileDir; ?>/js/account.js"></script>
	</body>
	</html>
<?php } ?>