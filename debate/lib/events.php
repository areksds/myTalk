<?php 

function adminEvents($panel, $base, $fileDir) {
	include 'header.php';	
	include 'templates/header.php';
	?><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="<?php echo $fileDir; ?>/css/admin.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
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
	<div id="events-first">
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
		<hr>
		<div id="before-message" style="color: white">Select a state to view its corresponding events and debates.</div>
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
		if ($_SESSION['level'] == 2) {
			$view = "View";
		} else {
			$view = "Edit";
		}
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
						<p class=\"card-text\">". $events['address'] .", ". $events['city'] ." ". $events['zip'] ." | Event date: " . $date['month'] . "/" . $date['day'] . "/" . $date['year'] . "</p>
						<button onClick=\"load(". $events['id'].")\" class=\"btn btn-dark\">". $view ." Event and Debates</button>
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
		
		
			if ($_SESSION['level'] != 2) { ?> <button class="btn btn-light" onClick="add()">Add New Event</button> <?php } } ?> </div>
				<div id="event-debates" style="display: none"></div>
			<div class="row">
				<div class="col-12">
				<?php include 'templates/footer.php'; ?>
				</div>
			</div>
			</div>
		</div>
		<div class="modal fade" id="eventEdit" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Edit Event Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					  <p id="event-id" hidden></p>
					  <div class="form-group">
						  <label for="name">Event name</label>
						<input type="text" class="form-control" id="name" placeholder="Name">
					  </div>
					  <div class="form-group">
						  <label for="date">Event date</label>
						<input type="date" class="form-control" id="date" placeholder="yyyy-mm-dd">
					  </div>
					  <div class="form-group">
						  <label for="address">Street Address</label>
						<input type="text" class="form-control" id="address" placeholder="123 Main St">
					  </div>
					  <div class="form-group">
						  <label for="city">City, State</label>
						<input type="text" class="form-control" id="city" placeholder="Los Angeles, CA">
					  </div>
					  <div class="form-group">
						  <label for="zip">Zip Code</label>
						  <input type="text" pattern="[0-9]{5}" class="form-control" id="zip" placeholder="12345">
					  </div>
					  <div class="form-group">
					   <label for="type">Event Type</label>
						<select class="custom-select" id="event-type">
							<option value="0">Convention</option>
							<option value="1">Winter Congress</option>
							<option value="2">Regional One-Day</option>
							<option value="3">Chapter One-Day</option>
					  	</select>
					  </div>
					  <div class="form-group" id="more-input">
						  <label for="extra-input" id="extra-label" style="display:none"></label>
						</div>
					  <div class="form-group">
						  <label for="blocks">Number of Blocks</label>
						  <input type="number" step="1" min="0" class="form-control" id="blocks" placeholder="0">
					  </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="save">Save changes</button>
				  </div>
				</div>
			  </div>
			</div>
		<?php include 'templates/javascript.php'; ?>
		<!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js" crossorigin="anonymous"></script>
		
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
							$('#events').slideUp("slow", function(){
								$('#before-message').hide();
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
					$('#before-message').slideDown("slow");
				}
			})
		<?php } ?>
			function load(id){
				$.ajax({
						url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/events.php", 
						type: "post",
						data: "id=" + id,
						dataType: 'html',
						success:function(data){
							$('#events-first').slideUp("slow", function(){
								$('#event-debates').html(data);
								$('#event-debates').slideDown("slow");	
							});
					   	}
					});
			}
			
			function revert(){
				$('#event-debates').slideUp("slow", function(){
					$('#events-first').slideDown("slow");
				});
			}
		<?php if ($panel != PANEL_URLS[1]) { ?>
			
			function add() {
				$('#event-id').empty();
				$('#name').empty();
				$('#date').datepicker('update');
				$('#address').empty();
				$('#city').empty();
				$('#zip').empty();
				$('#blocks').empty();
				$('#event-type').val('0');
				$('#event-type').trigger('change');
				$('#eventEdit').modal('show');
			}
			
			
			function talk(id) {
				
			}
			
			$('[type="date"]').datepicker({
				format: 'yyyy-mm-dd'
			});
			
			function edit(id) {
				$.ajax({
					url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/events.php", 
					type: "post",
					data: "id=" + id + "&full",
					dataType: 'json',
					success:function(data){
						$('#event-id').val(data.id);
						$('#name').val(data.name);
						$('#date').datepicker('update',data.date);
						$('#address').val(data.address);
						$('#city').val(data.city);
						$('#zip').val(data.zip);
						$('#blocks').val(data.blocks);
						if (data.congress == 1) {
							$('#event-type').val('1');
							$('#event-type').trigger('change');
						} else {
							if (data.region != null) {
								$('#event-type').val('2');
								$('#event-type').trigger('change');
								$('#extra-input').val(data.region);
							} else {
								if (data.chapter != null) {
									$('#event-type').val('3');
									$('#event-type').trigger('change');
									$('#extra-input').val(data.chapter);
								} else {
									$('#event-type').val('0');
									$('#event-type').trigger('change');
								}
							}
						}
						$('#eventEdit').modal('show');
					}
				});
			}
			
			$('#event-type').change(function(){
				if ($(this).val() === '2') {
					$('#extra-input').remove();
					$('#extra-label').html("Region");
					$('#extra-label').show();
					$('#more-input').append('<select id="extra-input" class="form-control"></select>');
					$.ajax({
						url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/regions.php", 
						type: "post",
						data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?>parseInt($("#selection-state").val(), 10)<?php } else { echo $_SESSION['state']; } ?>,
						dataType: 'json',
						success:function(data){
							for (x in data) {
								$('#extra-input').append('<option value="'+ data[x].code +'">'+ data[x].code +'</option>');
							}
					   	}
					});
				} else {
					if ($(this).val() === '3') {
						$('#extra-input').remove();
						$('#extra-label').html("Chapter");
						$('#extra-label').show();
						$('#more-input').append('<input id="extra-input" type="text" class="form-control">');
					} else {
						$('#extra-label').hide();
						$('#extra-label').html("");
						$('#extra-input').hide();
						$('#extra-input').remove();
					}	
				}
			});
			
			
		<?php } ?>
		</script>
			
		</body>	
	<?php } ?>



		



		