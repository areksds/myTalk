<?php 

function adminSettings($panel, $base, $fileDir) {
	include 'header.php';	
	include 'templates/header.php';
	?><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="<?php echo $fileDir; ?>/css/admin.css" rel="stylesheet">
	<style>
		@media (max-width: 625px) {
			span {
				display:none;
			}
		}
		
		/**
		 * Add the correct
		 * display in IE 10-
		 */
		
		[hidden] {
			display: none;
		}
	</style>
	<title><?php echo ucfirst($panel);?> Settings</title>
	<body>
		<script src="https://cdn.jsdelivr.net/npm/datalist-polyfill@1.21.2/datalist-polyfill.min.js" crossorigin="anonymous"></script>
		<div class="jumbotron vertical-center" style="background-color:inherit;">
			<div class="container">
			<div class="row">
				<div class="col-8">
					<a href="<?php echo $base . $fileDir . "/" . $panel; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/settings-panel.png" alt=""></a>
				</div>
			</div><br>		
			<div id="options">
				<div class="row">
					<div class="col-12">
						<div class="card text-white bg-info">
							<div class="card-header">Chapters</div>
						  <div class="card-body">
							 <?php if ($panel == PANEL_URLS[2]) { // Mayor Access ?>
								<h5 class="card-title">View the chapters of your region<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-atlas"></i></span></h5>
								<p class="card-text">View and edit the chapters of your region.</p>
							 <?php } elseif ($panel == PANEL_URLS[4]) { // Governor Access ?>
							  	<h5 class="card-title">View your state's chapters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-atlas"></i></span></h5>
								<p class="card-text">View and edit the chapters of your state.</p>
							<?php } elseif ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // JSF Employee and Admin Access ?>
							  	<h5 class="card-title">View the nation's chapters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-atlas"></i></span></h5>
								<p class="card-text">View and edit the chapters of the ten states.</p>
							<?php } ?>
							<button class="btn btn-light" onClick="chapters()">Open Chapter Editor</button>
						  </div>
						</div>
					</div>
				</div><br>
				<?php if ($panel == PANEL_URLS[4] || $panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?>
					<div class="row">
					<div class="col-12">
						<div class="card text-white bg-info">
						 <div class="card-header">Regions</div>
						<div class="card-body">
							<?php if ($panel == PANEL_URLS[4]) { // Governor Access ?>
								<h5 class="card-title">View your state's regions<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-map"></i></span></h5>
								<p class="card-text">View and edit the regions of your state.</p>
							<?php } elseif ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // JSF Employee and Admin Access ?>
								<h5 class="card-title">View the nation's regions<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-map"></i></span></h5>
								<p class="card-text">View and edit the regions of the ten states.</p>
							<?php } ?>
							<button class="btn btn-light" onClick="regions()">Open Region Editor</button>
						  </div>
						</div>
					</div>
				</div>
				<?php } ?>
			</div>
			<div id="chapters" style="display: none">
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-header">Add New Chapters</div>
						  <div class="card-body">
						   <?php if ($panel == PANEL_URLS[2]) { // Mayor Access ?>
								<h5 class="card-title">Add new chapters to your region<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-plus"></i></span></h5>
								<p class="card-text">Add new chapters to your region.</p>
							 <?php } elseif ($panel == PANEL_URLS[4]) { // Governor Access ?>
								<h5 class="card-title">Add new chapters to your state<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-plus"></i></span></h5>
								<p class="card-text">Add new chapters to your state and its regions.</p>
							<?php } elseif ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // JSF Employee and Admin Access ?>
							  	<h5 class="card-title">Add new chapters to a state<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-plus"></i></span></h5>
								<p class="card-text">Add new chapters to the ten states.</p>
							<?php } ?>
							<button class="btn btn-dark" data-toggle="modal" data-target="#addContent" data-id="chapters">Submit Chapters</button>
						  </div>
						</div>
					</div>
				</div><br>
				<div class="row">
					<div class="col-12">
						<div class="card">
						 <div class="card-header">Edit Existing Chapters</div>
						<div class="card-body">
							<h5 class="card-title">Edit chapters<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-pencil-alt"></i></span></h5>
							<p class="card-text">View and edit existing chapters.</p>
							<button href="#" class="btn btn-dark" data-toggle="modal" data-target="#editContent" data-id="chapters">Chapter Editor</button>
						  </div>
						</div>
					</div>
				</div><br>
				<button class="btn btn-light" onClick="home('#chapters')"><i class="fas fa-arrow-left"></i> Return to Settings</button>	
			</div>
			<?php if ($panel != PANEL_URLS[2]) { ?>
				<div id="regions" style="display: none">
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-header">Add New Regions</div>
							  <div class="card-body">
								 <?php if ($panel == PANEL_URLS[4]) { // Governor Access ?>
									<h5 class="card-title">Add new regions to your state<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-map-marked-alt"></i></span></h5>
									<p class="card-text">Add new regions to your state.</p>
								<?php } elseif ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // JSF Employee and Admin Access ?>
									<h5 class="card-title">Add new regions to a state<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-map-marked-alt"></i></span></h5>
									<p class="card-text">Add new regions to the ten states.</p>
								<?php } ?>
								<button class="btn btn-dark" data-toggle="modal" data-target="#addContent" data-id="regions">Submit Regions</button>
							  </div>
							</div>
						</div>
					</div><br>
					<div class="row">
						<div class="col-12">
							<div class="card">
							 <div class="card-header">Edit Existing Regions</div>
							<div class="card-body">
								<h5 class="card-title">Edit regions<span style="font-size: 3em; float:right; margin-right: 20px;"><i class="fas fa-map-signs"></i></span></h5>
								<p class="card-text">View and edit existing regions.</p>
								<button class="btn btn-dark" data-toggle="modal" data-target="#editContent" data-id="regions">Region Editor</button>
							  </div>
							</div>
						</div>
					</div><br>
					<button class="btn btn-light" onClick="home('#regions')"><i class="fas fa-arrow-left"></i> Return to Settings</button>	
				</div>
			<?php } ?>
				
				
			<div class="modal fade" id="addContent" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // JSF Employee and Admin Access ?>
					<div class="form-group">
						<label id="states" for="state"></label>
					   <select class="custom-select" id="state">
						<option value="1" id="state-1">NorCal</option>
						<option value="2" id="state-2">PNW</option>
						<option value="3" id="state-3">SoCal</option>
						<option value="4" id="state-4">Arizona</option>
						<option value="5" id="state-5">Midwest</option>
						<option value="6" id="state-6">Texas</option>
						<option value="7" id="state-7">ORV</option>
						<option value="8" id="state-8">Northeast</option>
						<option value="9" id="state-9">Mid-Atlantic</option>
						<option value="10" id="state-10">Southeast</option>
					  </select>
					  </div>
					 <?php } ?>
				  <div id="individual">
					  <div class="form-group">
						 <label for="name" id="name-desc">Chapter name</label> 
						<input type="text" class="form-control" id="name" placeholder="i.e. Example School (don't include 'chapter' in name)">
					  </div>
					  <?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
					  <div class="form-group" id="chapter-region">
						  <label for="region">Chapter region</label>
							<select class="custom-select" id="region">
							</select>
					  </div>
					   <div class="form-group" id="region-short">
						  <label for="code">Region code</label>
							<input type="text" class="form-control" id="code" placeholder="i.e. AR">
					  </div>
					  <?php } ?>
					  <div class="form-group">
						  <label for="head" id="head-desc">President's Full Name</label>
						  <input type="text" list="names" class="form-control" id="head" placeholder="Leave blank if president isn't registered on myTalk">
					  </div>
					  <datalist id="names">
					  </datalist>
				</div>
				 <?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
				<div id="bulk" style="display: none">
					<div class="form-group">
						<label for="list" id="list-desc">List of chapters<br><i>Format for each chapter listed (set id to 0 for no president)</i></label>
						<textarea class="form-control" id="list" rows="6" placeholder="{chapter name; chapter region; president myTalk id},{...}"></textarea>
					</div>
				</div>
				<?php } ?>
				</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?><button type="button" class="btn btn-primary" onClick="bulk()" id="switch">Switch to Bulk</button><?php } ?>
					<button type="button" class="btn btn-primary" id="save">Save changes</button>
				  </div>
				</div>
			  </div>
			</div>
				
			<div class="modal fade" id="editContent" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { // JSF Employee and Admin Access ?>
					<div class="form-group">
					<label id="states" for="selection-state"></label>
					   <select class="custom-select" id="selection-state">
						<option value="1" id="state-1">NorCal</option>
						<option value="2" id="state-2">PNW</option>
						<option value="3" id="state-3">SoCal</option>
						<option value="4" id="state-4">Arizona</option>
						<option value="5" id="state-5">Midwest</option>
						<option value="6" id="state-6">Texas</option>
						<option value="7" id="state-7">ORV</option>
						<option value="8" id="state-8">Northeast</option>
						<option value="9" id="state-9">Mid-Atlantic</option>
						<option value="10" id="state-10">Southeast</option>
					  </select>
					  </div>
					 <?php } ?>
					<div class="form-group">
						<label id="options" for="selections"></label>
					   <select class="custom-select" id="selections">
					  </select>
					  </div>
					  <div class="form-group">
						 <label for="selection-name" id="selection-name-desc">Chapter name</label> 
						<input type="text" class="form-control" id="selection-name">
					  </div>
					  <?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
					  <div class="form-group" id="selection-chapter-region">
						  <label for="selection-region">Chapter region</label>
							<select class="custom-select" id="selection-region">
							</select>
					  </div>
					   <div class="form-group" id="selection-region-short">
						  <label for="selection-code">Region code</label>
							<input type="text" class="form-control" id="selection-code">
					  </div>
					  <?php } ?>
					  <div class="form-group">
						  <label for="selection-head" id="selection-head-desc">President's Full Name</label>
						  <input type="text" list="selection-names" class="form-control" id="selection-head" placeholder="Leave blank if president isn't registered on myTalk">
					  </div>
					  <datalist id="selection-names">
					  </datalist>
				</div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					  <button type="button" class="btn btn-danger" data-dismiss="modal" data-toggle="modal" data-target="#warning">Delete</button>
					<button type="button" class="btn btn-primary" id="edit">Save changes</button>
				  </div>
				</div>
			  </div>
			</div>
				
			<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Added successfully</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p>Your addition has been successfully saved.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>	
				
			<div class="modal fade" id="failure" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Addition Failure</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p id="failure-reason"></p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>		
				
			<div class="modal fade" id="edit-success" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Edit successfully saved</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p>Your edit has been successfully saved.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>	
				
			<div class="modal fade" id="delete-success" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Deletion success</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p>Your requested deletion was successfully executed.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>	
				
			<div class="modal fade" id="edit-failure" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Edit Failure</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p id="edit-failure-reason"></p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>		
				
			<div class="modal fade" id="warning" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Deletion Warning</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p id="warning-reason">Are you <b>sure</b> you want to permanently delete this? Just to confirm, you are trying to delete the chapter. Once again, this action is <b>irreversible</b>.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-danger" id="confirm" data-dismiss="modal" onClick="delete_info()">Delete</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>		
				
			<?php include 'templates/javascript.php'; ?>
			<?php include 'templates/session.php'; ?>
			<script>
				
				$(document).ready(function(){ 
					window.isbulk = false;
				})
				
				
				function chapters(){
					$('#options').slideUp("slow", function(){
						$('#chapters').slideDown("slow");
						window.type = "chapter";
					});
				}
				
				<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
				function regions(){
					$('#options').slideUp("slow", function(){
						$('#regions').slideDown("slow");
						window.type = "region";
					});
				}
				<?php } ?>
				
				function home(type){
					$(type).slideUp("slow", function(){
						$('#options').slideDown("slow");	
					});
				}
				
				$('#head').on("input", function(){
					if ($("#head").val() != "") {
						$('#names option').remove();
						refresh();
					} else {
						$('#names option').remove();
					}
				})
				
				$('#selection-head').on("input", function(){
					if ($("#selection-head").val() != "") {
						$('#selection-names option').remove();
						refresh_sel();
					} else {
						$('#selection-names option').remove();
					}
				})
				
				$('#selections').on("change", function(){
					if ($('#editContent').find('#title').html() == "Edit Chapter") {
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/get-sel.php", 
							type: "post",
							data: "type=chapter" + "&chapter=" + $("#selections").find(":selected").val(),
							dataType: 'json',
							success:function(data){
								$('#editContent').find('option[selected]').attr('selected', false);
								$('#editContent').find('#selection-name').prop("placeholder",data.name);
								$('#editContent').find('#selection-head').val(data.head);
								$('#editContent').find('#selection-region').val(data.region);
						   }
						});
					} else {
						if ($('#editContent').find('#title').html() == "Edit Region") {
							$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/get-sel.php", 
							type: "post",
							data: "type=region" + "&region=" + $("#selections").find(":selected").html(),
							dataType: 'json',
							success:function(data){
								$('#editContent').find('#selection-name').attr("placeholder",data.name);
								$('#editContent').find('#selection-code').attr("placeholder",data.code);
								$('#editContent').find('#selection-head').val(data.head);
						   }
						});
						}
					}
				})
				
				<?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?>
				$('#state').on("change", function(){
					if ($('#addContent').find('#title').html() == "Add New Chapter") {
						$('#region option').remove();
						region_ref();
					}	
				})
				
				
				$('#selection-state').on("change", function(){
					if ($('#editContent').find('#title').html() == "Edit Chapter") {
						$('#selections option').remove();
						$('#selection-region option').remove();
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/chapters.php", 
							type: "post",
							data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> $("#selection-state").find(":selected").val() <?php } else { echo $_SESSION['state']; } ?>,
							dataType: 'json',
							success:function(chapter){
								$('#selections').append($('<option>').text("Select a chapter"));
								for (x in chapter) {
									$('#selections').append($('<option>').text(chapter[x].name).attr('value', chapter[x].id));
								}
						   }
						});
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/regions.php", 
							type: "post",
							data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> $("#selection-state").find(":selected").val() <?php } else { echo $_SESSION['state']; } ?>,
							dataType: 'json',
							success:function(region){
								for (x in region) {
									$('#selection-region').append($('<option>').text(region[x].name).attr('value', region[x].id));
								}
						   }
						});
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/get-sel.php", 
							type: "post",
							data: "type=chapter" + "&chapter=" + $("#selections").find(":selected").val(),
							dataType: 'json',
							success:function(data){
								$('#editContent').find('option[selected]').prop('selected', false);
								$('#editContent').find('#selection-name').attr("placeholder",data.name);
								$('#editContent').find('#selection-head').val(data.head);
								$('#editContent').find('#selection-region').val(data.region);
						   }
						});
					} else {
						$('#selections option').remove();
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/regions.php", 
							type: "post",
							data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> $("#selection-state").find(":selected").val() <?php } else { echo $_SESSION['state']; } ?>,
							dataType: 'json',
							success:function(region){
								$('#selections').append($('<option>').text("Select a region"));
								for (x in region) {
									$('#selections').append($('<option>').text(region[x].name).attr('value', region[x].id));
								}
						   }
						});
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/get-sel.php", 
							type: "post",
							data: "type=region" + "&region=" + $("#selections").find(":selected").html(),
							dataType: 'json',
							success:function(data){
								$('#editContent').find('#selection-name').attr("placeholder",data.name);
								$('#editContent').find('#selection-code').attr("placeholder",data.code);
								$('#editContent').find('#selection-head').val(data.head);
						   }
						});
					}	
				})
				<?php } ?>
				
				$('#addContent').on('show.bs.modal', function (event) { 
					<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
						$('#region option').remove();
						region_ref();
						$('#addContent').find('#code').val("");
					<?php } ?>
					$('#addContent').find('#name').val("");
					$('#addContent').find('#head').val("");
					$('#addContent').find('#list').val("");
					if ($(event.relatedTarget).data('id') == "chapters") {
						$('#addContent').find('#title').html("Add New Chapter");
						$('#addContent').find('#states').html("State to add chapter to");
						$('#addContent').find('#chapter-region').show();
						$('#addContent').find('#region-short').hide();
						$('#addContent').find('#name-desc').html("Chapter name");
						$('#addContent').find('#head-desc').html("President's full name");
						$('#addContent').find('#list-desc').html("List of chapters<br><i>Format for each chapter listed (set id to 0 for no president)</i>");
						$('#addContent').find('#name').attr("placeholder","i.e. School Name (don't include 'chapter' in name)");
						$('#addContent').find('#head').attr("placeholder","Leave blank if president isn't registered on myTalk");
						$('#addContent').find('#list').attr("placeholder","{chapter name; chapter region; president myTalk id},{...}");
						<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
					} else {
						$('#addContent').find('#title').html("Add New Region");
						$('#addContent').find('#states').html("State to add region to");
						$('#addContent').find('#chapter-region').hide();
						$('#addContent').find('#region-short').show();
						$('#addContent').find('#name-desc').html("Region name");
						$('#addContent').find('#head-desc').html("Mayor's full name");
						$('#addContent').find('#list-desc').html("List of regions<br><i>Format for each region listed (set id to 0 for no mayor)</i>");
						$('#addContent').find('#name').attr("placeholder","i.e. Name Region (remember to add 'Region' at end)");
						$('#addContent').find('#head').attr("placeholder","Leave blank if mayor isn't registered on myTalk");
						$('#addContent').find('#list').attr("placeholder","{region name; region code; mayor myTalk id},{...}");
						<?php } ?>
					}
					
				})
				
				$('#editContent').on('show.bs.modal', function (event) { 
					<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
						$('#selection-region option').remove();
					<?php } ?>
					$('#selections option').remove();
					$('#editContent').find('#selection-code').val("");
					$('#editContent').find('#selection-code').attr("placeholder","");
					$('#editContent').find('#selection-name').val("");
					$('#editContent').find('#selection-name').attr("placeholder","");
					$('#editContent').find('#selection-head').val("");
					if ($(event.relatedTarget).data('id') == "chapters") {
						window.type = "chapter";
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/chapters.php", 
							type: "post",
							data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> $("#selection-state").find(":selected").val() <?php } else { echo $_SESSION['state']; } ?>,
							dataType: 'json',
							success:function(chapter){
								$('#selections').append($('<option>').text("Select a chapter"));
								for (x in chapter) {
									$('#selections').append($('<option>').text(chapter[x].name).attr('value', chapter[x].id));
								}
						   }
						});
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/regions.php", 
							type: "post",
							data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> $("#selection-state").find(":selected").val() <?php } else { echo $_SESSION['state']; } ?>,
							dataType: 'json',
							success:function(region){
								for (x in region) {
									$('#selection-region').append($('<option>').text(region[x].name).attr('value', region[x].id));
								}
						   }
						});
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/get-sel.php", 
							type: "post",
							data: "type=chapter" + "&chapter=" + $("#selections").find(":selected").val(),
							dataType: 'json',
							success:function(data){
								$('#editContent').find('option[selected]').prop('selected', false);
								$('#editContent').find('#selection-name').attr("placeholder",data.name);
								$('#editContent').find('#selection-head').val(data.head);
								$('#editContent').find('#selection-region').val(data.region);
						   }
						});
						$('#editContent').find('#title').html("Edit Chapter");
						$('#editContent').find('#states').html("Show chapters from state");
						$('#editContent').find('#selection-chapter-region').show();
						$('#editContent').find('#selection-region-short').hide();
						$('#editContent').find('#selection-name-desc').html("Chapter name");
						$('#editContent').find('#options').html("Chapters");
						$('#editContent').find('#selection-head-desc').html("President's full name");
						$('#editContent').find('#selection-head').attr("placeholder","Leave blank if president isn't registered on myTalk");
						<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
					} else {
						window.type = "region";
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/regions.php", 
							type: "post",
							data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> $("#selection-state").find(":selected").val() <?php } else { echo $_SESSION['state']; } ?>,
							dataType: 'json',
							success:function(region){
								$('#selections').append($('<option>').text("Select a region"));
								for (x in region) {
									$('#selections').append($('<option>').text(region[x].name).attr('value', region[x].id));
								}
						   }
						});
						$.ajax({
							url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/get-sel.php", 
							type: "post",
							data: "type=region" + "&region=" + $("#selections").find(":selected").html(),
							dataType: 'json',
							success:function(data){
								$('#editContent').find('#selection-name').attr("placeholder",data.name);
								$('#editContent').find('#selection-code').attr("placeholder",data.code);
								$('#editContent').find('#selection-head').attr("placeholder",data.head);
						   }
						});
						$('#editContent').find('#title').html("Edit Region");
						$('#editContent').find('#states').html("Show regions for state");
						$('#editContent').find('#selection-chapter-region').hide();
						$('#editContent').find('#selection-region-short').show();
						$('#editContent').find('#selection-name-desc').html("Region name");
						$('#editContent').find('#options').html("Regions");
						$('#editContent').find('#selection-head-desc').html("Mayor's full name");
						$('#editContent').find('#selection-head').attr("placeholder","Leave blank if mayor isn't registered on myTalk");
						<?php } ?>
					}
					
				})
				<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
					function bulk(){
						if ($('#switch').html() == "Switch to Bulk") {
							window.isbulk = "true";
							$('#addContent').find('#switch').html("Switch to Individual");
							if ($('#title').html() == "Add New Chapter") {
								$('#addContent').find('#title').html("Add New Chapters");
								$('#addContent').find('#states').html("State to add chapters to");
								$('#addContent').find('#individual').hide();
								$('#addContent').find('#bulk').show();
								<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
							} else {
								$('#addContent').find('#title').html("Add New Regions");
								$('#addContent').find('#states').html("State to add regions to");
								$('#addContent').find('#individual').hide();
								$('#addContent').find('#bulk').show();
								<?php } ?>
							}
						} else {
							window.isbulk = "false";
							$('#addContent').find('#switch').html("Switch to Bulk");
							if ($('#title').html() == "Add New Chapters") {
								$('#addContent').find('#title').html("Add New Chapter");
								$('#addContent').find('#states').html("State to add chapter to");
								$('#addContent').find('#bulk').hide();
								$('#addContent').find('#individual').show();
								<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
							} else {
								$('#addContent').find('#title').html("Add New Region");
								$('#addContent').find('#states').html("State to add region to");
								$('#addContent').find('#bulk').hide();
								$('#addContent').find('#individual').show();
								<?php } ?>
							}
						}			
					} 
				<?php } ?>
				
				<?php if ($panel != PANEL_URLS[2]) { // No Mayor Access ?>
				function region_ref(){
					$.ajax({
						url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/regions.php", 
						type: "post",
						data: "state=" + <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> $("#state").find(":selected").val() <?php } else { echo $_SESSION['state']; } ?>,
						dataType: 'json',
						success:function(data){
							for (x in data) {
								$('#region').append($('<option>').text(data[x].name).attr('value', data[x].id));
							}
					   }
					});
				}
				<?php } ?>
				
				function refresh(){
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/users.php", 
						type: "post",
						data: "full=true" + "&name=" + $('#head').val() <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> + "&state=" + $("#state").find(":selected").val() <?php } ?>,
						dataType: 'json',
						async: false,
						success:function(data){
							if (data != "Couldn't load users.") {
								if (data.length != 0) {
									for (x in data) {
										if (x >= 6) {
											break;
										} else {
											if (data[x].level > <?php echo $_SESSION['level']; ?>) { 
												continue;
											} else {
												$('#names').append($('<option>').html(data[x].fullname));
											}
										}
									}
								} else {
									$('#names option').remove(); 
								}
							}		

					   }
					});	
				}
				
				function refresh_sel(){
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/users.php", 
						type: "post",
						data: "full=true" + "&name=" + $('#selection-head').val() <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> + "&state=" + $("#selection-state").find(":selected").val() <?php } ?>,
						dataType: 'json',
						async: false,
						success:function(data){
							if (data != "Couldn't load users.") {
								if (data.length != 0) {
									for (x in data) {
										if (x >= 6) {
											break;
										} else {
											if (data[x].level > <?php echo $_SESSION['level']; ?>) { 
												continue;
											} else {
												$('#selection-names').append($('<option>').html(data[x].fullname));
											}
										}
									}
								} else {
									$('#selection-names option').remove(); 
								}
							}		

					   }
					});	
				}
				
				$("#save").on("click", function(){ 
					$('#addContent').modal('hide');
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/add.php", 
						type: "post",
						data: "type=" + type + "&name=" + encodeURI($('#name').val()) + "&bulk=" + isbulk + "&list=" + encodeURI($('#list').val()) + "&head=" + encodeURI($('#head').val()) <?php if ($panel != PANEL_URLS[2]) {?> + "&region=" + $('#region').val() + "&code=" + $('#code').val() <?php } ?> <?php if($_SESSION['level'] >= 6){ ?> + "&state=" + $("#state").find(":selected").val()<?php } ?>,
						dataType: 'html',
						success:function(data){
							if (data == "0"){
								$('#success').modal('show');
							} else {
								$('#failure-reason').html(data);
								$('#failure').modal('show');
							}
					   }
					});	
				})
				
				$("#edit").on("click", function(){ 
					$('#editContent').modal('hide');
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/edit.php", 
						type: "post",
						data: "type=" + type + "&name=" + encodeURI($('#selection-name').val()) + "&head=" + encodeURI($('#selection-head').val()) + "&id=" + $("#selections").find(":selected").val() <?php if ($panel != PANEL_URLS[2]) {?> + "&region=" + $('#selection-region').val()+ "&code=" + $('#selection-code').val() <?php } ?> <?php if($_SESSION['level'] >= 6){ ?> + "&state=" + $("#selection-state").find(":selected").val()<?php } ?>,
						dataType: 'html',
						success:function(data){
							if (data == "0"){
								$('#edit-success').modal('show');
							} else {
								if (data == "1") {
									$('#edit-failure-reason').html("Unable to save edit. Please make sure your new name(s) are unique, and that you have selected a valid editable item.");
									$('#edit-failure').modal('show');
								} else {
									$('#edit-failure-reason').html(data);
									$('#edit-failure').modal('show');
								}
							}
					   }
					});	
				})
				
				$('#warning').on('show.bs.modal', function (event) { 
					$('#warning').find('#confirm').attr("onClick","delete_info('" + type + "'," + $("#selections").find(":selected").val() + ")");
					if (type == "chapter") {
						$('#warning').find('#warning-reason').html("Are you <b>sure</b> you want to permanently delete this chapter? Just to confirm, you are trying to delete the <b>" + $('#editContent').find('#selection-name').prop("placeholder") + "</b> chapter. This action is <b>irreversible</b>.");
					} else {
						if (type == "region") {
							$('#warning').find('#warning-reason').html("Are you <b>sure</b> you want to permanently delete this region? Just to confirm, you are trying to delete the <b>" + $('#editContent').find('#selection-name').prop("placeholder") + "</b>. This action is <b>irreversible</b>.");
						}
					}
					
				})
				
				function delete_info(type, id) {
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/delete.php", 
						type: "post",
						data: "type=" + type + "&id=" + id,
						dataType: 'html',
						success:function(data){
							if (data == "0"){
								$('#delete-success').modal('show');
							} else {
								$('#failure-reason').html(data);
								$('#failure').modal('show');
							}
					   }
					});	
				}
				
			</script>
			<div class="row">
				<div class="col-12">
				<?php include 'templates/footer.php'; ?>
				</div>
			</div>
			</div>
		</div>
		</body>	
	<?php } ?>