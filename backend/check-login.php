<?php
include('../db/conn.php');

if (isset($_POST['user'])  && isset($_POST['pwd'])) {

    function validate($data){

       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);

       return $data;
    }

    $uname = validate($_POST['user']);
    $pass = validate($_POST['pwd']);

    $sql = "SELECT * FROM user WHERE user_name='$uname' AND password='".md5($pass)."' ";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {

        $row = mysqli_fetch_assoc($result);

        if ($row['user_name'] === $uname && $row['password'] === md5($pass) ) {

			session_start();
            $_SESSION['user_name'] = $row['user_name'];
            $res = '1';

        }else{
			$res = '0';
        }
    }else{
		$res = '0';
    }
}else{
    $res = '0';
}
echo json_encode($res);exit;

?>