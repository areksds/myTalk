<?php 

function adminEvents($panel, $base, $fileDir) {
	include 'header.php';	
	include 'templates/header.php';
	?><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="<?php echo $fileDir; ?>/css/admin.css" rel="stylesheet">
	<title><?php if($panel == PANEL_URLS[3]) { echo "Debate"; } else { echo ucfirst($panel); }?> Events</title>
	<style>
		@media (max-width: 625px) {
			span {
				display:none;
			}
		}
	</style>
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
	<?php } ?>
	
	
	<?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // National Access ?>
				<div class="form-group">
					   <select class="custom-select" id="selection-state">
						<option selected value="">Select a state</option>
						<option value="1">NorCal</option>
						<option value="2">PNW</option>
						<option value="3">SoCal</option>
						<option value="4">Arizona</option>
						<option value="5">Midwest</option>
						<option value="6">Texas</option>
						<option value="7">ORV</option>
						<option value="8">Northeast</option>
						<option value="9">Mid-Atlantic</option>
						<option value="10">Southeast</option>
					  </select>
				</div>
				<div id="hr"></div>
				<div id="events" style="display: none"></div>
	<?php 
	} else { 
		if ($_SESSION['level'] == 3) {
			$xdb = new DbConn;
			$xstmt = $xdb->conn->prepare("SELECT region FROM chapters WHERE chapter = :chapter");
			$xstmt->bindParam(":chapter", $_SESSION['chapter']);
			$xstmt->execute();
			$xresult = $xstmt->fetch(PDO::FETCH_ASSOC);
			$region = $xresult['region'];
			$db = new DbConn;
			$stmt = $db->conn->prepare("SELECT * FROM events WHERE region = :region AND state = :state");
			$stmt->bindParam(":region", $region);
			$stmt->bindParam(":state", $_SESSION['state']);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		} else {
			$db = new DbConn;
			$stmt = $db->conn->prepare("SELECT * FROM events WHERE state = :state ORDER BY date DESC");
			$stmt->bindParam(":state", $_SESSION['state']);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		$i = 0;
		foreach ($result as $events) {
			$i++;
			if ($events['region'] != NULL) {
				$type = "One-day";
				$icon = "fa-clock";
			} else {
				$type = "Convention";
				$icon = "fa-calendar-alt";
			}
			$date = date_parse($events['date']);
			print "<div class=\"card\">
					<div class=\"card-header\">". $type ."</div>
					<div class=\"card-body\">
						<h5 class=\"card-title\">". $events['name'] ."<span style=\"font-size: 3em; float:right; margin-right: 20px;\"><i class=\"fas " . $icon . "\"></i></span></h5>
						<p class=\"card-text\">". $events['address'] .", ". $events['city'] .", ". $events['zip'] ." | Event date: " . $date['month'] . "/" . $date['day'] . "/" . $date['year'] . "</p>
						<button href=\"#\" class=\"btn btn-dark\">Edit Event and Debates</button>
					  </div>
				</div>";
			if ((count($result) - $i) > 0){
				print "<br>";
			}
		}
		
		if (count($result) == 0) {
			print "<p style=\"color: white\">No events currently registered.</p><hr>";
		} else {
			print "<hr>";
		}
		
		
	?> <button class="btn btn-light" onClick="add()">Add New Event</button> <?php } ?>
			<div class="row">
				<div class="col-12">
				<?php include 'templates/footer.php'; ?>
				</div>
			</div>
			</div>
		</div>
		<?php include 'templates/javascript.php'; ?>
		<script>
			<?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // National Access ?>
			$("#selection-state").on('change',function(){
				if($(this).val() != '') {
					$.ajax({
						url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/events.php", 
						type: "post",
						data: "state=" + parseInt($("#selection-state").val(), 10),
						dataType: 'html',
						success:function(data){
							$('#hr').html("<hr>");
							$('#events').slideUp("slow", function(){
								$('#events').empty();
								$('#events').html(data);
								$('#events').slideDown("slow");	
							});
					   	}
					});
				} else {
					$('#events').slideUp("slow");
					$('#hr').empty();
					$('#events').empty();
				}
			})
		<?php } ?>
		</script>
		</body>	
	<?php } ?>