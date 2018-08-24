<?php 

function adminEvents($panel, $base, $fileDir) {
	include 'header.php';	
	include 'templates/header.php';
	?><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="<?php echo $fileDir; ?>/css/admin.css" rel="stylesheet">
	<title><?php if($panel == PANEL_URLS[3]) { echo "Debate"; } else { echo ucfirst($panel); }?> Events</title>
	<body>
		<div class="jumbotron vertical-center" style="background-color:inherit;">
			<div class="container">
			<div class="row">
				<div class="col-8">
					<a href="<?php echo $base . $fileDir . "/" . $panel; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/events-panel.png" alt=""></a>
				</div>
			</div><br>					
	<?php if ($panel == PANEL_URLS[1]) { // Cabinet Access ?>
	<?php } elseif ($panel == PANEL_URLS[2]) { // Mayor Access ?>
	<?php } elseif ($panel == PANEL_URLS[3]) { // Director of Debate Access ?>
	<?php } elseif ($panel == PANEL_URLS[4]) { // Governor Access ?>
	<?php } elseif ($panel == PANEL_URLS[5]) { // JSF Employee Access ?>
	<?php } elseif ($panel == PANEL_URLS[6]) { // Administrator Access ?>
	<?php } ?>
			<div class="row">
				<div class="col-12">
				<?php include 'templates/footer.php'; ?>
				</div>
			</div>
			</div>
		</div>
		<?php include 'templates/javascript.php'; ?>	
		</body>	
	<?php } ?>