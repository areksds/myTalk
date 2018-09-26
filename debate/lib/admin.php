<?php 

function admin($panel, $base, $fileDir){
	include 'header.php';	
	include 'templates/header.php';
	?><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="<?php echo $fileDir; ?>/css/admin.css" rel="stylesheet">
	<style>
		@media (max-width: 625px) {
			span {
				display:none;
			}
		}
	</style>
	<?php
	if ($panel == PANEL_URLS[1]) { // Cabinet Access ?>
		<title>Cabinet Panel</title>
		<body>
			<div class="jumbotron vertical-center" style="background-color:inherit;">
				<div class="container">
					<div class="row">
						<div class="col-8">
							<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[1]; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/<?php echo PANEL_URLS[1]; ?>-panel.png" alt=""></a>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-primary">
							  <div class="card-header">View Debates and Event Information</div>
							  <div class="card-body">
								<h5 class="card-title">Gain information regarding debates and events<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-gavel"></i></span></h5>
								<p class="card-text">View your state's events and their corresponding debates in this section.</p>
							  	<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[1];?>/events" class="btn btn-dark">View Events and Debates</a>
								</div>
							</div>
						</div>
					</div><br>
	<?php } elseif ($panel == PANEL_URLS[2]) { // Mayor access ?>
		<title>Region Panel</title>
		<body>
			<div class="jumbotron vertical-center" style="background-color:inherit;">
				<div class="container">
					<div class="row">
						<div class="col-8">
							<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[2]; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/<?php echo PANEL_URLS[2]; ?>-panel.png" alt=""></a>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-primary">
							  <div class="card-header">Events and Debates</div>
							  <div class="card-body">
								<h5 class="card-title">Modify your region's events and debates<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-gavel"></i></span></h5>
								<p class="card-text">Edit and add your regions's events and their corresponding debates in this section.</p>
							  	<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[2];?>/events" class="btn btn-dark">View Events and Debates</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-success">
							  <div class="card-header">Approval Queue</div>
							  <div class="card-body">
								<h5 class="card-title">View pending regional debaters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-check"></i></span></h5>
								<p class="card-text">Approve or reject pending debate arguments from one-day debaters.</p>
							  	<a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[2]; ?>/queue" class="btn btn-dark">View Approval Queue</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-danger">
							  <div class="card-header">Region Settings</div>
							  <div class="card-body">
								<h5 class="card-title">Edit your region's settings<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-cog"></i></span></h5>
								<p class="card-text">Make changes to the chapters in your region.</p>
								  <a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[2]; ?>/settings" class="btn btn-dark">Change State Settings</a>
							  </div>
							</div>
						</div>
					</div>
	<?php } elseif ($panel == PANEL_URLS[3]) { // Director of Debate access ?> 
		<title>Debate Panel</title>
		<body>
			<div class="jumbotron vertical-center" style="background-color:inherit;">
				<div class="container">
					<div class="row">
						<div class="col-8">
							<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[3]; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/<?php echo PANEL_URLS[3]; ?>-panel.png" alt=""></a>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-primary">
							  <div class="card-header">Events and Debates</div>
							  <div class="card-body">
								<h5 class="card-title">Modify your state's events and debates<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-gavel"></i></span></h5>
								<p class="card-text">Edit and add your state's events and their corresponding debates in this section.</p>
							  	<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[3];?>/events" class="btn btn-dark">View Events and Debates</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-success">
							  <div class="card-header">Approval Queue</div>
							  <div class="card-body">
								<h5 class="card-title">View pending debaters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-check"></i></span></h5>
								<p class="card-text">Approve or reject pending debate arguments from debaters.</p>
							  	<a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[3]; ?>/queue" class="btn btn-dark">View Approval Queue</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-dark">
							  <div class="card-header">User Panel</div>
							  <div class="card-body">
								<h5 class="card-title">Access user information and edit permissions<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-users"></i></span></h5>
								<p class="card-text">Here you can access user details and their permission levels.</p>
								  <a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[3]; ?>/users" class="btn btn-light">Enter User Panel</a>
							  </div>
							</div>
						</div>
					</div><br>
	<?php } elseif ($panel == PANEL_URLS[4]) { // Governor access ?>
		<title>State Settings</title>
		<body>
			<div class="jumbotron vertical-center" style="background-color:inherit;">
				<div class="container">
					<div class="row">
						<div class="col-8">
							<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[4]; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/<?php echo PANEL_URLS[4]; ?>-panel.png" alt=""></a>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-primary">
							  <div class="card-header">Events and Debates</div>
							  <div class="card-body">
								<h5 class="card-title">Modify your state's events and debates<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-gavel"></i></span></h5>
								<p class="card-text">Edit and add your state's events and their corresponding debates in this section.</p>
							  	<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[4];?>/events" class="btn btn-dark">View Events and Debates</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-success">
							  <div class="card-header">Approval Queue</div>
							  <div class="card-body">
								<h5 class="card-title">View pending debaters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-check"></i></span></h5>
								<p class="card-text">Approve or reject pending debate arguments from debaters.</p>
							  	<a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[4]; ?>/queue" class="btn btn-dark">View Approval Queue</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-dark">
							  <div class="card-header">User Panel</div>
							  <div class="card-body">
								<h5 class="card-title">Edit user information and permissions<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-users"></i></span></h5>
								<p class="card-text">Here you can modify user details and their permission levels.</p>
								  <a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[4]; ?>/users" class="btn btn-light">Enter User Panel</a>
							  </div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-danger">
							  <div class="card-header">State Settings</div>
							  <div class="card-body">
								<h5 class="card-title">Edit your state's settings<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-cog"></i></span></h5>
								<p class="card-text">Make changes to chapters and regions.</p>
								  <a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[4]; ?>/settings" class="btn btn-dark">Change State Settings</a>
							  </div>
							</div>
						</div>
					</div>
	<?php } elseif ($panel == PANEL_URLS[5]) { // JSF Employee access ?> 
		<title>National Settings</title>
		<body>
			<div class="jumbotron vertical-center" style="background-color:inherit;">
				<div class="container">
					<div class="row">
						<div class="col-8">
							<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[5]; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/<?php echo PANEL_URLS[5]; ?>-panel.png" alt=""></a>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-primary">
							  <div class="card-header">Events and Debates</div>
							  <div class="card-body">
								<h5 class="card-title">Modify the nation's events and debates<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-gavel"></i></span></h5>
								<p class="card-text">Edit and add any events and their corresponding debates in this section.</p>
							  	<a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[5]; ?>/events" class="btn btn-dark">View Events and Debates</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-success">
							  <div class="card-header">Approval Queue</div>
							  <div class="card-body">
								<h5 class="card-title">View pending national debaters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-check"></i></span></h5>
								<p class="card-text">Approve or reject pending debate arguments from national debaters.</p>
							  	<a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[5]; ?>/queue" class="btn btn-dark">View Approval Queue</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-dark">
							  <div class="card-header">User Panel</div>
							  <div class="card-body">
								<h5 class="card-title">Edit user information and permissions<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-users"></i></span></h5>
								<p class="card-text">Here you can modify user details and their permission levels.</p>
								  <a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[5]; ?>/users" class="btn btn-light">Enter User Panel</a>
							  </div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-danger">
							  <div class="card-header">Global State Settings</div>
							  <div class="card-body">
								<h5 class="card-title">Edit global state settings<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-cog"></i></span></h5>
								<p class="card-text">Make changes to chapters, regions, and states as a whole.</p>
								  <a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[5]; ?>/settings" class="btn btn-dark">Change State Settings</a>
							  </div>
							</div>
						</div>
					</div>
	<?php } elseif ($panel == PANEL_URLS[6]) { // Administrator access ?>
		<title>Admin Panel</title>
		<body>
			<div class="jumbotron vertical-center" style="background-color:inherit;">
				<div class="container">
					<div class="row">
						<div class="col-8">
							<a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[6]; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/<?php echo PANEL_URLS[6]; ?>-panel.png" alt=""></a>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-primary">
							  <div class="card-header">Events and Debates</div>
							  <div class="card-body">
								<h5 class="card-title">Modify the nation's events and debates<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-gavel"></i></span></h5>
								<p class="card-text">Edit and add any events and their corresponding debates in this section.</p>
							  	<a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[6]; ?>/events" class="btn btn-dark">View Events and Debates</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-success">
							  <div class="card-header">Approval Queue</div>
							  <div class="card-body">
								<h5 class="card-title">View pending national debaters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-check"></i></span></h5>
								<p class="card-text">Approve or reject pending debate arguments from national debaters.</p>
							  	<a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[6]; ?>/queue" class="btn btn-dark">View Approval Queue</a>
								</div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-dark">
							  <div class="card-header">User Panel</div>
							  <div class="card-body">
								<h5 class="card-title">Edit user information and permissions<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-users"></i></span></h5>
								<p class="card-text">Here you can modify user details and their permission levels.</p>
								  <a href="<?php echo $base . $fileDir  . "/" . PANEL_URLS[6]; ?>/users" class="btn btn-light">Enter User Panel</a>
							  </div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card text-white bg-danger">
							  <div class="card-header">Global State Settings</div>
							  <div class="card-body">
								<h5 class="card-title">Edit global state settings<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-cog"></i></span></h5>
								<p class="card-text">Make changes to chapters, regions, and states as a whole.</p>
								  <a href="<?php echo $base . $fileDir . "/" . PANEL_URLS[6]; ?>/settings" class="btn btn-dark">Change State Settings</a>
							  </div>
							</div>
						</div>
					</div>
	<?php } ?>
				<div class="row">
					<div class="col-12">
					<?php include 'templates/footer.php'; ?>
					</div>
				</div>
			</div>
		</div>
		<?php include 'templates/javascript.php'; ?>
		<?php include 'templates/session.php'; ?>
		</body>	
<?php } ?>