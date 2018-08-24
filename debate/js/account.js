$("#email").on('change',function(){
	if($(this).val() != '') {
		document.getElementById("submit").removeAttribute("disabled");
	} else {
		document.getElementById("submit").setAttribute("disabled","");
	}
})

$("#first").on('change',function(){
	if($(this).val() != '') {
		document.getElementById("submit").removeAttribute("disabled");
	} else {
		document.getElementById("submit").setAttribute("disabled","");
	}
})

$("#last").on('change',function(){
	if($(this).val() != '') {
		document.getElementById("submit").removeAttribute("disabled");
	} else {
		document.getElementById("submit").setAttribute("disabled","");
	}
})

$("#phone").on('change',function(){
	if($(this).val() != '') {
		document.getElementById("submit").removeAttribute("disabled");
	} else {
		document.getElementById("submit").setAttribute("disabled","");
	}
})

$("#password").on('change',function(){
	if($(this).val() != '') {
		document.getElementById("submit").removeAttribute("disabled");
	} else {
		document.getElementById("submit").setAttribute("disabled","");
	}
})

$("#submit").click(function(){
	document.getElementById("submit").setAttribute("disabled","");
	$.ajax({
			url:"lib/functions/account.php", 
			type: "post",
			data: "email=" + $('#email').val() + "&emailpassword=" + $('#email-password').val() + "&first=" + $('#first').val() + "&last=" + $('#last').val() + "&phone=" + $('#phone').val() + "&currentpassword=" + $('#current-password').val() + "&newpassword=" + $('#password').val() + "&repeatpassword=" + $('#repeat-password').val() + "&fileDir=" + getCookie("SITE"),
			dataType: 'html',
			success:function(data){
				if (data.indexOf("alert-danger") > -1) {
					location.hash = 'message';
					document.getElementById("submit").removeAttribute("disabled");
					document.getElementById("message").innerHTML = data;
				} else {
					location.hash = 'message';
					document.getElementById("message").innerHTML = data;
					setTimeout(function(){ location.reload(); },1000)
				}
		   },

			beforeSend: function () {
				$("#message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>");
			}

		});
});

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