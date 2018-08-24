$("#inputState").on('change',function(){
	if($(this).val() != '') {
		document.getElementById("onwards").removeAttribute("disabled");
	} else {
		document.getElementById("onwards").setAttribute("disabled","");
	}
})

$("#onwards").click(function () {

window.state = parseInt($("#inputState").val(), 10);

  $.ajax({
		url:"lib/functions/chapters.php", 
		type: "post",
		data: "state=" + state,
		dataType: 'json',
		success:function(data){
			for (x in data) {
				$('#inputChapter').append($('<option>').text(data[x].name).attr('value', data[x].id));
			}
	   }
	});

	switch (state){
		case 1:
			var text = "PNW";
			break;
		case 2:
			var text = "NorCal";
			break;
		case 3:
			var text = "SoCal";
			break;
		case 4:
			var text = "Arizona";
			break;
		case 5:
			var text = "Midwest";
			break;
		case 6:
			var text = "Texas";
			break;
		case 7:
			var text = "ORV";
			break;
		case 8:
			var text = "Northeast";
			break;
		case 9:
			var text = "Mid-Atlantic";
			break;
		case 10:
			var text = "Southeast";
			break;
		default:
			state = 0;
			var text = "Site";
			document.getElementById("inputChapter").setAttribute("disabled","");
			document.getElementById("inputChapterSelect").innerHTML = "Non-state account";
			document.getElementById("inputChapterSelect").value = "0";
			document.getElementById("inputGraduation").setAttribute("disabled","");
			document.getElementById("inputGradSelect").innerHTML = "Non-state account";
			document.getElementById("inputGradSelect").value = "0";
			$("#staffcode").show();
			break;

		} 

	document.getElementById("reg-tag").innerHTML = text + " Registration";

	  $("#first").hide();
	$("#second").show();
});

$("#repeatPassword").on('change',function(){
	if($(this).val() != document.getElementById("inputPassword").value) {
		document.getElementById("repeatPassword").classList.add("is-invalid");
		document.getElementById("incorrect-repeat").innerHTML = "Your passwords don't match.";
	} else if (document.getElementById("repeatPassword").classList.contains("is-invalid") && $(this).val() === document.getElementById("inputPassword").value){
		document.getElementById("repeatPassword").classList.remove("is-invalid");
		document.getElementById("incorrect-repeat").innerHTML = "";
	}
})

$("#inputPassword").on('change',function(){
	if(document.getElementById("repeatPassword").value != "") {
		if($(this).val() != document.getElementById("repeatPassword").value) {
			document.getElementById("repeatPassword").classList.add("is-invalid");
			document.getElementById("incorrect-repeat").innerHTML = "Your passwords don't match.";
		} else if (document.getElementById("repeatPassword").classList.contains("is-invalid") && $(this).val() === document.getElementById("inputPassword").value){
			document.getElementById("repeatPassword").classList.remove("is-invalid");
			document.getElementById("incorrect-repeat").innerHTML = "";
		}
}
})

$("#submit").click(function () { 

		document.getElementById("submit").setAttribute("disabled","");

		$.ajax({
			url:"lib/functions/register.php", 
			type: "post",
			data: "state=" + state + "&email=" + $('#inputEmail').val() + "&password=" + $('#inputPassword').val() + "&password_verify=" + $('#repeatPassword').val() + "&first=" + $('#inputFirst').val() + "&last=" + $('#inputLast').val() + "&chapter=" + $('#inputChapter').val() + "&graduation=" + $('#inputGraduation').val() + "&phone=" + $('#inputPhone').val() + "&recaptcha=" + grecaptcha.getResponse() + "&fileDir=" + getCookie("SITE") + "&staffcode=" + $('#inputCode').val(),
			dataType: 'html',
			success:function(data){
				if (data.indexOf("alert-danger") > -1) {
					document.getElementById("submit").removeAttribute("disabled");
					document.getElementById("error_message").innerHTML = data;
				} else {
					document.getElementById("error_message").innerHTML = data;
				}
		   },

			beforeSend: function () {
				$("#error_message").html("<p class='text-center'><img src='images/ajax-loader.gif'></p>");
			}
		});

})

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