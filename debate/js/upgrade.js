function install () {

	document.getElementById("installation").setAttribute("disabled","");
	document.getElementById("installation").innerHTML = "Upgrading";

	  $.ajax({
		url:"lib/installer/installer.php", 
		type: "post", 
		data: "upgrade",
		dataType: 'html',
		success:function(data){
			if (data == 1) {
				$("#error").html("");
				document.getElementById("installation").innerHTML = "Upgrade complete";
				setTimeout(function(){
					document.getElementById("installation").innerHTML = "Refreshing..."; 
					$("#error").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>");
					setTimeout(function(){
						location.reload()},
					   2000)},
					2000);
			} else {
				document.getElementById("installation").innerHTML = "Upgrade";
				document.getElementById("installation").removeAttribute("disabled","");
				document.getElementById("error").innerHTML = "<br><div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">" +
															  data +
															  "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">" +
																"<span aria-hidden=\"true\">&times;</span>" +
															  "</button>" +
															"</div>";

			}
	   },

		beforeSend: function () {
			$("#error").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>");
		}
	 });
 }