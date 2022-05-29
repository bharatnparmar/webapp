<!DOCTYPE html>
<html>
	<head>
		<title>Registration</title>
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

	<h2>Register</h2>

		<form id="form_login" onsubmit="return false">
	        <p>
	            <input id="email" name="email" type="email" placeholder="E-mail" value="sam@wtotn.com" required="required">
	        </p>
	        <p>
	            <input id="user" name="uname" type="text" placeholder="Username" required="required">
	        </p>
	        <p>
	            <input id="pwd" name="pswd" type="password" placeholder="Password" required="required">
	        </p>
	        <p>
	            <input id="cpwd" name="cpswd" type="password" placeholder="Confirm Password" required="required">
	        </p>
	        <p>
	        	<button type="submit" name="regi">Sign up</button>
	        </p>
	        <p>
	            <a href="login.php" >Already registered !? </a>
	        </p>
	    </form>

	<script type="text/javascript">
		
		$("button").click(function() {
			var form = $("#form_login");
			var user = $("#user").val();
			var pwd = $("#pwd").val();
			var cpwd = $("#cpwd").val();

			if(cpwd == pwd ) {

			    $.ajax({    //create an ajax request to 
			        type: "POST",
			        url: "backend/register-user.php", 
			        data: form.serialize(),
			        dataType: "json",   //expect json to be returned                
			        success: function(response){ 
			            if(response.id == 1){
			            	alert('User created successfully')
							window.location.href = "login.php";
			            }else{
			            	alert(response.msg);
			            }
			        }
			    });
			}else{
				alert("Both passwords doesn't match");
			}
		});

	</script>

	</body>
</html>
