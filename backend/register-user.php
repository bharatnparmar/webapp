<?php
include('../db/conn.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_POST["email"];
    $uname = $_POST["uname"];
    $pswd = md5($_POST["pswd"]);

    $sql1 = "SELECT * FROM user WHERE user_name='$uname' ";
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) === 1) {
        $res['id'] = '0';
        $res['msg'] = 'user already exist!';
    }else{
        $sql = "INSERT INTO user (user_name, email, password) VALUES ('$uname','$email','$pswd')";
        mysqli_query($conn, $sql);
        $res['id'] = '1';
    }

}else{

	$res['id'] = '0';
    $res['msg'] = 'something went wrong!';

}
echo json_encode($res);exit;
?>