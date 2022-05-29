<?php
include('../db/conn.php'); 

// add records
if(count($_POST)>0){
	
	if($_POST['type']==1){

		$name = $_POST['name'];
		$price = $_POST['price'];
		$upc = $_POST['upc'];
		$status = $_POST['status'];
    
	    $filename = $_FILES["image"]["name"];
		$tempname = $_FILES["image"]["tmp_name"];    
		$folder = "../images/".$filename;

		move_uploaded_file($tempname, $folder);

		$sql = "INSERT INTO `products`( `name`, `price`, `upc`, `status`, `image_name`) 
		VALUES ('$name', '$price', '$upc', '$status', '$filename')";

		/*$sql = "INSERT INTO `crud`( `name`, `email`,`phone`,`city`) 
		VALUES ('$name','$email','$phone','$city')";*/


		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

//update records
if(count($_POST)>0){

	if($_POST['type']==2){

	$id = $_POST['id'];
	$name = $_POST['name'];
	$price = $_POST['price'];
	$upc = $_POST['upc'];
	$status = $_POST['status'];

	if(isset($_FILES["image"]["name"])){
	 
		$filename = $_FILES["image"]["name"];
		$tempname = $_FILES["image"]["tmp_name"];    
		$folder = "../images/".$filename;
		$query = mysqli_query($conn,"SELECT image_name FROM products WHERE id = $id");
		$res = mysqli_fetch_assoc($query);
		$image_name = '';
		$image_name = '../images/'.trim($res['image_name']);

		if (file_exists($image_name)) {
			unlink($image_name);
	    }

		move_uploaded_file($tempname, $folder);
		$q = " ,`image_name` = '".$filename." ' ";

	}else{
		$q = '';
	}

		$sql = "UPDATE `products` SET `name`='$name',`price`='$price',`upc`='$upc',`status`='$status' ".$q." WHERE id=$id";
		
		if (mysqli_query($conn, $sql)) {
			echo json_encode(array("statusCode"=>200));
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

//delete records
if(count($_POST)>0) {
	if($_POST['type']==3) {
		$id=$_POST['id'];
		$sql = "DELETE FROM `products` WHERE id=$id ";

		// remove image from folder
		$query = mysqli_query($conn,"SELECT image_name FROM products WHERE id = $id");
		$res = mysqli_fetch_assoc($query);
		$image_name = '../images/'.trim($res['image_name']);
		if (file_exists($image_name)) {
			unlink($image_name);
	    }

		if (mysqli_query($conn, $sql)) {
			echo $id;
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}
if(count($_POST)>0){
	if($_POST['type']==4){

		$ids = $_POST['id'];
		$var = explode(',',$ids);

		foreach($var as $id)
		{
			$query = mysqli_query($conn,"SELECT image_name FROM products WHERE id = $id");
			$res = mysqli_fetch_assoc($query);
			$image_name = '../images/'.trim($res['image_name']);
			if (file_exists($image_name)) {
				unlink($image_name);
			}
		}

		$sql = "DELETE FROM products WHERE id in ($ids)";
		if (mysqli_query($conn, $sql)) {
			echo $ids;
		} 
		else {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		}
		mysqli_close($conn);
	}
}

?>