<?php
error_reporting(0);
include('../db/conn.php'); 

function generatePassword($length) {
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }
    return $result;
}

if(isset($_POST) & !empty($_POST)){

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$sql = "SELECT * FROM `user` WHERE email = '$email'";
	$res = mysqli_query($conn, $sql);
	$count = mysqli_num_rows($res);
	if($count == 1){
		$generate_pwd = generatePassword(8);
		$newpass = md5($generate_pwd);

		$r = mysqli_fetch_assoc($res);
		$userid = $r['id'];
		$to = $r['email'];
		$subject = "Your Recovered Password";
		 

		$updateqry = "UPDATE `user` SET `password`='$newpass' WHERE id=$userid";
		
		if (mysqli_query($conn, $updateqry)) {

			$message = "Please use this password to login ".$generate_pwd;
			
			$headers =  'MIME-Version: 1.0' . "\r\n"; 
			$headers .= 'From: admin <admin@webapp.com>' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
			
			if(mail($to, $subject, $message, $headers)){
				$response['id'] = '1';
				$response['msg'] = "Your Password has been sent to your email id";
			}else{
				$response['id'] = '1';
				$response['msg'] = "Your Password has been sent to your email id. New Password:".$generate_pwd;
			}

		} else{
			$response['id'] = '0';
    		$response['msg'] = 'something went wrong!';
		}

	}else{
		$response['id'] = '0';
    	$response['msg'] = 'something went wrong!';
	}

}else{
	$response['id'] = '0';
    $response['msg'] = 'something went wrong!';
}
echo json_encode($response);exit;
?>