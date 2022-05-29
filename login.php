<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<style>
		body {
			text-align: center;
		}
		html,body {
			height:100%;
			width:100%;
			margin:0;
		}
		form {
			margin:auto;
		}
		</style>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>

		<h2>Login</h2>

		<form id="form_login" onsubmit="return false">
	        <p>
	            <input id="user" name="user" type="text" placeholder="Username" required>
	        </p>
	        <p>
	            <input id="pass" name="pwd" type="password" placeholder="Password" required>
	        </p>
	        <p>
	            <button type="submit" >Login</button>
	        </p>
	        <p>
	            <a href="register.php" >New user !? </a>
	        </p>
	        <p>
	            <a href="forgot.php" >Forget Password !? </a>
	        </p>
	    </form>

	<script type="text/javascript">
		
		$("button").click(function() {
			// alert('ere');
			var form = $("#form_login");
			var user = $("#user").val();
			var pwd = $("#pass").val();

			if(user !='' && pwd !='') {

			    $.ajax({    //create an ajax request to 
			        type: "POST",
			        url: "backend/check-login.php", 
			        data: form.serialize(),
			        dataType: "json",   //expect json to be returned                
			        success: function(response){ 
			            if(response == 1){
							window.location.href = "products.php";
			            }else{
			            	alert('Wrong Username Or Password !');
			            }

			        }

			    });
			}
		});

	</script>


	</body>
</html>
