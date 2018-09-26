<div class="modal fade" id="loggedout" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
	<div class="modal-content">
	  <div class="modal-header">
		<h5 class="modal-title">Logged Out</h5>
	  </div>
	  <div class="modal-body">
		<p>Your login session has expired. Please log in again.</p>
	  </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-secondary" data-dismiss="modal" onClick="location.reload()">Log in</button>
	  </div>
	</div>
  </div>
</div>		

<script>
	
function check_login_active() {
	$.ajax({
		url:"<?php echo $base . $fileDir . "/"; ?>lib/functions/session.php", 
		type: "post",
		dataType: 'html',
		success:function(data){
			if(data === 0) {
				$('#loggedout').modal({backdrop: 'static', keyboard: false}); 
			} 
			setTimeout(function(){check_login_active();}, 5000);
		}
	});
}

$(function(){check_login_active();});
</script>