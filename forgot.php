<!DOCTYPE html>
<html>
	<head>
		<title>Forget Password</title>
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

		<h2>Forget Password</h2>

		<form id="form_login" onsubmit="return false">
	        <p>
	            <input id="email" name="email" type="email" placeholder="Enter your mail id" required>
	        </p>
	        <p>
	            <button type="submit" >Submit</button>
	        </p>
	        <p>
	            <a href="register.php" >New user !? </a>
	        </p>
	        <p>
	            <a href="login.php" >Already registered !? </a>
	        </p>
	    </form>

	<script type="text/javascript">
		
		$("button").click(function() {
			// alert('ere');
			var form = $("#form_login");
			var user = $("#user").val();
			var pwd = $("#pwd").val();

			if(user !='' && pwd !='') {

			    $.ajax({    //create an ajax request to 
			        type: "POST",
			        url: "backend/forgot-pwd.php", 
			        data: form.serialize(),
			        dataType: "json",   //expect json to be returned                
			        success: function(response){ 
			        	//$("#responsecontainer").html(response); 
			            if(response.id == 1){
			            	alert(response.msg);
							window.location.href = "index.php";
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
