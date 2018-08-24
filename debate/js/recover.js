	
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
			
			$("#submit").click(function(){
				var $_GET=[];
				window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(a,name,value){$_GET[name]=value;});
				document.getElementById("submit").setAttribute("disabled","");
				$.ajax({
						url:"lib/functions/recover.php", 
						type: "post",
						data: "code=" + $_GET['code'] + "&password=" + $('#inputPassword').val() + "&repeatPassword=" + $('#repeatPassword').val(),
						dataType: 'html',
						success:function(data){
							if (data.indexOf("alert-danger") > -1) {
								document.getElementById("submit").removeAttribute("disabled");
								document.getElementById("message").innerHTML = data;
							} else {
								document.getElementById("submit").removeAttribute("disabled");
								document.getElementById("message").innerHTML = data;
								$("#submit").hide();
								$("#home").show();
							}
					   }
					})
			})