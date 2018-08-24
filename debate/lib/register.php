
<?php function generateRegister($base, $fileDir){ 
include 'header.php';	

	?>
		<?php include 'templates/header.php'; ?>
		<link href="<?php echo $fileDir; ?>/css/register.css" rel="stylesheet">
		<title>Register | myTalk</title>
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	</head>

	<body class="text-center">
		<form class="form-register" method="post" id="register">
		  <a href="<?php echo $base . $fileDir; ?>" style="color: initial; border-bottom: none"><img class="mb-4" src="<?php echo $fileDir; ?>/images/logo.png" alt="" width="150" height="150"></a>
			<h1 style="color: white" class="font-weight-normal">myTalk</h1>
		  <h1 style="color: white" class="h3 mb-3 font-weight-normal" id="reg-tag">Registration</h1>
			
			<div id="first">
			<select id="inputState" class="custom-select" required>
				  <option value="" selected>Select your state:</option>
				  <option value="1">Pacific Northwest</option>
				  <option value="2">Northern California</option>
				  <option value="3">Southern California</option>
					<option value="4">Arizona</option>
				  <option value="5">Midwest</option>
				  <option value="6">Texas</option>
					<option value="7">Ohio River Valley</option>
				  <option value="8">Northeast</option>
				  <option value="9">Mid-Atlantic</option>
					<option value="10">Southeast</option>
				<option value="0">Non-State Account</option>
			</select>
			<br>
			<button id="onwards" type="button" class="btn btn-primary" disabled>Continue</button>
			</div>
			<div id="second" style="display: none">
				<div class="credentials">
				<legend>Account credentials</legend>
		  <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus="">
		  <input type="password" id="inputPassword" class="form-control initial" placeholder="Password" required>
				<input type="password" id="repeatPassword" class="form-control repeat" placeholder="Repeat password" required>
				<div id="incorrect-repeat" class="invalid-feedback"></div>
				</div><br>
			<div class="personal">	
				<legend>Personal information</legend>
		  <input type="textarea" id="inputFirst" class="form-control first" placeholder="First name" required autofocus="">
		<input type="textarea" id="inputLast" class="form-control last" placeholder="Last name" required autofocus="">
						<select id="inputChapter" class="custom-select" required>
				  <option id="inputChapterSelect" value="" selected>Select your chapter:</option>
			</select><br>
				<select id="inputGraduation" class="custom-select" required>
				  <option id="inputGradSelect" value="" selected>Select your graduation year:</option>
				  <option value="<?php echo date('Y'); ?>"><?php echo date('Y'); ?></option>
				  <option value="<?php echo date('Y', strtotime('+1 year')); ?>"><?php echo date('Y', strtotime('+1 year')); ?></option>
					<option value="<?php echo date('Y', strtotime('+2 year')); ?>"><?php echo date('Y', strtotime('+2 year')); ?></option>
				  <option value="<?php echo date('Y', strtotime('+3 year')); ?>"><?php echo date('Y', strtotime('+3 year')); ?></option>
					<option value="<?php echo date('Y', strtotime('+4 year')); ?>"><?php echo date('Y', strtotime('+4 year')); ?></option>
				  <option value="<?php echo date('Y', strtotime('+5 year')); ?>"><?php echo date('Y', strtotime('+5 year')); ?></option>
					<option value="<?php echo date('Y', strtotime('+6 year')); ?>"><?php echo date('Y', strtotime('+6 year')); ?></option>
				  <option value="<?php echo date('Y', strtotime('+7 year')); ?>"><?php echo date('Y', strtotime('+7 year')); ?></option>
			</select>
				<input type="tel" id="inputPhone" class="form-control" placeholder="Phone (optional)" autofocus="">
				</div><br>
				<div style="display: none" id="staffcode">
					<div class="credentials">
					<legend>Staff passcode</legend>
					<input type="password" id="inputCode" class="form-control" placeholder="Code" autofocus="">
					</div><br>
				</div>
				
				<div class="g-recaptcha" data-sitekey="<?php echo $config['recaptcha']['sitekey']; ?>"></div><br>
			
		
		  <button id="submit" class="btn btn-lg btn-primary btn-block" type="submit">Register</button> 
			<a href="<?php echo $base . $fileDir; ?>" class="btn btn-lg btn-light btn-block">Go home</a><br>
				<div id="error_message"></div>
				<a href id="back">Select another state</a> <!-- Destroys session with a refresh -->
			</div>
		  <?php include 'templates/footer.php'; ?>
		</form>

		<?php include 'templates/javascript.php'; ?>
		
		<script src="<?php echo $fileDir; ?>/js/register.js"></script>
		
		
	</body>
	</html>	

<?php } ?>