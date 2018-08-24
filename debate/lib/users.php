<?php 

function adminUsers($panel, $base, $fileDir) {
	include 'header.php';	
	include 'templates/header.php';
	?><meta name="viewport" content="width=device-width, initial-scale=1.0"><link href="<?php echo $fileDir; ?>/css/admin.css" rel="stylesheet">
	<style>
		@media (max-width: 500px) {
			td.trigger{
				display:none;  
			} 
			
			th.trigger{
				display:none;  
			} 
		}
	</style>
	<title>User Panel</title>
	<body>
		<div class="jumbotron vertical-center" style="background-color:inherit;">
			<div class="container">
			<div class="row">
				<div class="col-8">
					<a href="<?php echo $base . $fileDir . "/" . $panel; ?>" style="border-bottom: none;"><img style="width: 100%; height: auto;" src="<?php echo $fileDir; ?>/images/user-panel.png" alt=""></a>
				</div>
			</div><br>
			<div class="row">
				<div class="col-12">
					<b style="color:white">Start typing in the input fields to get user results.</b>
				</div>
			</div><br>
			<div class="row">
				<div class="col-12">
					<div class="input-group">
					  <div class="input-group-prepend">
						<span class="input-group-text" id="">First name</span>
					  </div>
					  <input type="text" id="first" class="form-control">
					</div>
				</div>
			</div><br>
			<div class="row">
				<div class="col-12">
					<div class="input-group">
					  <div class="input-group-prepend">
						<span class="input-group-text" id="">Last name</span>
					  </div>
					  <input type="text" id="last" class="form-control">
					</div>
				</div>
			</div><br>
			<div class="row">
				<div class="col-12">
					<div class="input-group">
					  <div class="input-group-prepend">
						<span class="input-group-text" id="">Email</span>
					  </div>
					  <input type="email" id="email" class="form-control">
					</div>
				</div>
			</div>
			 <?php if ($panel == PANEL_URLS[6]) {?>
				<br>
			 <div class="row">
				<div class="col-12">
					<div class="input-group">
					  <div class="input-group-prepend">
						<span class="input-group-text" id="">State</span>
						  </div>
						<select class="custom-select" id="findstate">
							<option value="" selected>No specific state</option>
							<option value="1" id="1">NorCal</option>
							<option value="2" id="2">PNW</option>
							<option value="3" id="3">SoCal</option>
							<option value="4" id="4">Arizona</option>
							<option value="5" id="5">Midwest</option>
							<option value="6" id="6">Texas</option>
							<option value="7" id="7">ORV</option>
							<option value="8" id="8">Northeast</option>
							<option value="9" id="9">Mid-Atlantic</option>
							<option value="10" id="10">Southeast</option>
					  	</select>
					</div>
				</div>	
			</div>
			<?php } ?>
			<hr>
			<div class="row">
				<div class="col-12">	
					<div id="spinner"></div>
					<p id="info" style="color:white">The results will appear here as you start typing.</p>
						<table class="table bg-light table-hover" id="table" style="display:none">
							<thead>
								<tr>
								  <th scope="col mb-3">First</th>
								  <th scope="col mb-3">Last</th>
								  <th scope="col mb-3" class="trigger">Email</th>
								  <th scope="col mb-3"></th>
								</tr>
							  </thead>
							<tbody id="users">
							</tbody>
						</table>
					<div id="overflow" style="color:white"></div>
				</div>
				</div>
				
			<div class="modal fade" id="userEdit" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="userEditTitle">Edit User</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					  <p id="id" hidden></p>
					  <div class="form-group">
						  <label for="firstname">First name</label>
						<input type="text" class="form-control" id="firstname">
					  </div>
					  <div class="form-group">
						  <label for="lastname">Last name</label>
						<input type="text" class="form-control" id="lastname">
					  </div>
					  <div class="form-group">
						  <label for="useremail">Email</label>
						<input type="email" class="form-control" id="useremail">
					  </div>
					  <div class="form-group">
						  <label for="graduation">Graduation</label>
						<input type="text" class="form-control" id="graduation">
					  </div>
					  <div class="form-group">
						  <label for="phone">Phone</label>
						<input type="text" class="form-control" id="phone">
					  </div>
					  <div class="form-group">
					   <label for="chapter">Chapter</label>
						<select class="custom-select" id="chapter">
					  	</select>
					  </div>
					<?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?>
					  <div class="form-group">
						<label for="state">State</label>
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
						<option value="0" id="state-0">No state assigned</option>
					  </select>
					  </div>
					<?php } ?>
					  <div class="form-group">
						<label for="chapter">Permission Level</label>
					   <select class="custom-select" id="role">
						<option value="1" id="perm-1">Member</option>
						<option value="2" id="perm-2">Cabinet</option>
						<option value="3" id="perm-3">Mayor</option>
						<option value="4" id="perm-4">Debate Director</option>
						   <?php if ($panel == PANEL_URLS[4] || $panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?>
						<option value="5" id="perm-5">Governor</option>
						   <?php } if ($panel == PANEL_URLS[6]) {?>
						<option value="6" id="perm-6">JSF Employee</option>
						   <?php } ?>
						   
					  </select>
					  </div>
					  <div class="form-group form-check">
						  <input type="checkbox" class="form-check-input" id="verified">
					 	  <label class="form-check-label" for="verified">Verified</label>
					  </div>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" id="save">Save changes</button>
				  </div>
				</div>
			  </div>
			</div>	
				
			<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">User Edit Success</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="location.reload()">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p>User edited successfully.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="location.reload()">Close</button>
				  </div>
				</div>
			  </div>
			</div>	
				
			<div class="modal fade" id="failure" tabindex="-1" role="dialog" aria-hidden="true">
			  <div class="modal-dialog" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">User Edit Failure</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close" onClick="location.reload()">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<p>User could not be edited at this time due to various errors. Please make sure that the first and last name are under 60 characters, you have entered a valid and unused email, and have put a correct graduation date.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="location.reload()">Close</button>
				  </div>
				</div>
			  </div>
			</div>		
				
			<?php include 'templates/javascript.php'; ?>
			<script>
				$('#first').on("input", function(){
					if ($("#first").val() != "") {
						refresh();
					} else {
						if ($("#last").val() == "" && $("#email").val() == "") {
							clear();
						}
					}
				})

				$('#last').on("input", function(){
					if ($("#last").val() != "") {
						refresh();
					} else {
						if ($("#first").val() == "" && $("#email").val() == "") {
							clear();
						} 
					}
				})	

				$('#email').on("input",function(){
					if ($("#email").val() != "") {
						refresh();
					} else {
						if ($("#first").val() == "" && $("#last").val() == "") {
							clear();
						} 
					}
				})	
				
				$('#findstate').on("change",function(){
					if ($("#first").val() == "" && $("#last").val() == "" && $("#email").val() == "") {
					} else {
						refresh();
					}
				})	

				function refresh(){
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/users.php", 
						type: "post",
						data: "first=" + $('#first').val() + "&last=" + $('#last').val() + "&email=" + $('#email').val() <?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?> + "&state=" + $("#findstate").find(":selected").val() <?php } ?>,
						dataType: 'json',
						async: false,
						success:function(data){
							$('#table').hide();
							$('#table tbody tr').remove(); 
							$('#spinner').hide();
							if (data == "Couldn't load users.") {
								$('#info').html = (data);
								$('#table').hide();
								$('#info').show();
							} else {
								if (data.length != 0) {
									for (x in data) {
										if (x >= 15) {
											$('#overflow').append("<p color=\"white\"><b>Note:</b> Only first 15 records shown, refine search for other options.</p>");
											break;
										} else {
											<?php if ($panel == PANEL_URLS[5] || $panel == PANEL_URLS[6]) { ?>
												$('#table').append($('<tr>').html("<td>" + data[x].first + "</td><td>" + data[x].last + "</td><td class=\"trigger\">" + data[x].email + "</td>" + "<td><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#userEdit\" data-id=" + data[x].id + ">Edit User</button></td>"));
											<?php } else { ?>
												if (data[x].level >= <?php echo $_SESSION['level']; ?>) {
													$('#table').append($('<tr>').html("<td>" + data[x].first + "</td><td>" + data[x].last + "</td><td class=\"trigger\">" + data[x].email + "</td><td></td>"));
												} else {
													$('#table').append($('<tr>').html("<td>" + data[x].first + "</td><td>" + data[x].last + "</td><td class=\"trigger\">" + data[x].email + "</td>" + "<td><button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#userEdit\" data-id=" + data[x].id + ">Edit User</button></td>"));
												}
											<?php } ?>
										}
									}
									$('#table').show();
								} else {
									$('#table').hide();
									$('#table tbody tr').remove(); 
									$('#info').html("Could not find any users.");
									$('#info').show();
								}
							}		

					   },
						beforeSend: function () {
							$('#table').hide();
							$('#info').hide();
							$('#overflow').empty();
							$("#spinner").show();
							$("#spinner").html("<p class='text-center'><img src='<?php echo $base . $fileDir . "/"; ?>images/ajax-loader.gif'></p>");
						}
					});	
				}	

				function clear(){
					$('#table').hide();
					$('#overflow').empty(); 
					$("#table tbody tr").remove(); 
					document.getElementById("info").innerHTML = "The results will appear here as you start typing.";
					$('#info').show();
				}
				
				$('#userEdit').on('show.bs.modal', function (event) { 
					$(this).closest('#userEdit').find("input[type=text], email").val("");
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/user.php", 
						type: "post",
						data: "id=" + $(event.relatedTarget).data('id') + "&type=get",
						dataType: 'json',
						async: false,
						success:function(data){
							$('#spinner').hide();
							$('#userEdit').find('option').removeAttr("selected");
							$("#chapter option").remove(); 

							if (data != "Couldn't load user.") {
								$.ajax({
									url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/chapters.php", 
									type: "post",
									data: "state=" + data.state,
									dataType: 'json',
									async: false,
									success:function(chapters){
										for (x in chapters) {
											$('#chapter').append($('<option>').text(chapters[x].name).attr('id', 'chapter-' + chapters[x].id).attr('value', chapters[x].id));
										}
								   }
								});
								$('#userEdit').find('#id').html($(event.relatedTarget).data('id'));
								$('#userEdit').find('#userEditTitle').html('Edit User: ' + data.fullname);
								$('#userEdit').find('#firstname').attr("placeholder",data.first);
								$('#userEdit').find('#lastname').attr("placeholder",data.last);
								$('#userEdit').find('#useremail').attr("placeholder",data.email);
								$('#userEdit').find('#graduation').attr("placeholder",data.graduation);
								$('#userEdit').find('#phone').attr("placeholder",data.phone);
								$('#userEdit').find('#state-' + data.state).attr("selected", "");
								$('#userEdit').find('#perm-' + data.level).attr("selected", "");
								if (data.verified == 1) {
									$('#userEdit').find('#verified').attr("checked", "");
								} else {
									$('#userEdit').find('#verified').removeAttr("checked");
								}
								$('#userEdit').find('#chapter-' + data.chapter).attr("selected", "");
							} else {
								$('#userEdit').find('#userEditTitle').text('User could not be loaded.');
							}

					   },
						beforeSend: function () {
							$("#spinner").show();
							$("#spinner").html("<p class='text-center'><img src='<?php echo $base . $fileDir . "/"; ?>images/ajax-loader.gif'></p>");
						}
					});	
				})
				
				$("#save").on("click", function(){ 
					$('#userEdit').modal('hide');
					if ($("#verified").is(':checked')) {
						var verified = 1;
					} else {
						var verified = 0;
					}
					$.ajax({
						url: "<?php echo $base . $fileDir . "/"; ?>lib/functions/user.php", 
						type: "post",
						data: "id=" + $('#id').html() + "&first=" + $('#firstname').val() + "&last=" + $('#lastname').val() + "&email=" + $('#useremail').val() + "&graduation=" + $('#graduation').val() + "&chapter=" + $("#chapter").find(":selected").val() + "&phone=" + $('#phone').val() + "&verified=" + verified + "&level=" + $("#role").find(":selected").val() + <?php if($_SESSION['level'] >= 6){ ?> "&state=" + $("#state").find(":selected").val() + <?php } ?> "&type=put",
						dataType: 'html',
						success:function(data){
							if (data == "0"){
								$('#success').modal('show');
							} else {
								$('#failure').modal('show');
							}
					   }
					});	
				})
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