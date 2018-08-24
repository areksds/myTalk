function submit(){
	document.getElementById("submit").setAttribute("disabled","");
	$.ajax({
			url:"lib/functions/forgot.php", 
			type: "post",
			data: "email=" + $('#email').val() + "&recaptcha=" + grecaptcha.getResponse() + "&fileDir=" + getCookie("SITE"),
			dataType: 'html',
			success:function(data){
				if (data.indexOf("alert-danger") > -1) {
					document.getElementById("submit").removeAttribute("disabled");
					document.getElementById("message").innerHTML = data;
					grecaptcha.reset();
				} else {
					document.getElementById("message").innerHTML = data;
				}
		   },

			beforeSend: function () {
				$("#message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>");
			}

		});
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}