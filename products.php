<?php
session_start();
	if (!isset($_SESSION["user_name"])) {
		header("location: index.php");
} 
include('db/conn.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Products</title>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<p id="success"></p>
		<div class="table-wrapper">
			<div class="table-title">
				<div class="row">
					<div class="col-sm-6">
						<h3>Product Lists</h3>
					</div>
					<div class="col-sm-6">
						<a href="#addProductModal" class="btn btn-success" data-toggle="modal"><i class="material-icons">add_circle</i> <span>Add New Product</span></a>
						<a href="JavaScript:void(0);" class="btn btn-danger" id="delete_multiple"><i class="material-icons">remove_circle</i> <span>Delete</span></a>
						Welcome 
						<?php
						
						if (isset($_SESSION['user_name']) ){
							echo '<b>'.$_SESSION['user_name'].'</b>, ';
						} ?>
						<a href="logout.php" > Logout</a>
					</div>
				</div>
			</div>
			<table class="table table-striped table-hover">
				<thead>
					<tr>
						<th>
							<span class="custom-checkbox">
								<input type="checkbox" class="selectAll">
								<label for="selectAll"></label>
							</span>
						</th>
						<th>NAME</th>
						<th>PRICE</th>
						<th>UPC</th>
						<th>STATUS</th>
						<th>IMAGE</th>
						<th>ACTION</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$result = mysqli_query($conn,"SELECT * FROM products");
					$i=1;
					while($row = mysqli_fetch_array($result)) {
					?>
					<tr id="<?php echo $row['id']?>">
						<td>
							<span class="custom-checkbox">
								<input type="checkbox" class="user_checkbox" data-prod-id="<?php echo $row['id']?>">
								<label for="checkbox2"></label>
							</span>
						</td>
						<td><?php echo $row['name']?></td>
						<td><?php echo $row['price']?></td>
						<td><?php echo $row['upc']?></td>
						<td><?php echo ($row['status'] == '0' ? 'Active' : 'Deactive' )?></td>
						<td>
							<img src="images/<?php echo $row["image_name"] ?>" height="50" width="50"/>
						</td>
						<td>
							<a href="#editProductModal" class="edit" data-toggle="modal">
								<i class="material-icons update" data-toggle="tooltip" 
								data-id="<?php echo $row['id']; ?>"
								data-name="<?php echo $row['name']; ?>"
								data-price="<?php echo $row['price']; ?>"
								data-upc="<?php echo $row['upc']; ?>"
								data-status="<?php echo $row['status']; ?>"
								data-image="<?php echo $row['image_name']; ?>"
								title="Edit">create</i>
							</a>
							<a href="#deleteProductModal" class="delete" data-id="<?php echo $row['id']; ?>" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Delete">delete</i></a>
						</td>
					</tr>
					<?php
					$i++;
					}
					?>
				</tbody>
			</table>
		</div>
	</div>

<!-- Add Modal HTML -->
<div id="addProductModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="user_form" >
				<div class="modal-header">						
					<h4 class="modal-title">Add Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">					
					<div class="form-group">
						<label>NAME</label>
						<input type="text" id="name" name="name" class="form-control" required >

					</div>
					<div class="form-group">
						<label>PRICE</label>
						<input type="number" id="price" name="price" class="form-control" required>
					</div>
					<div class="form-group">
						<label>UPC</label>
						<input type="text" id="upc" name="upc" class="form-control" required>
					</div>
					<div class="form-group">
						<label>STATUS</label>
						<p>
							<input type="radio" class="check" name="check" checked value="0"><label>Active</label>
	                       	<input type="radio" class="check" name="check"  value="1"><label>Deactive</label>
						</p>
					</div>
					<div class="form-group">
						<label>IMAGE</label>
						<input type="file" id="image" name="image" class="form-control" required>
					</div>					
				</div>
				<div class="modal-footer">
					<input type="hidden" value="1" name="type" id="type1">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<button type="submit" class="btn btn-success" id="btn-add">Add</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Edit Modal HTML -->
<div id="editProductModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form id="update_form">
				<div class="modal-header">						
					<h4 class="modal-title">Edit Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id_u" name="id" class="form-control">					
					<div class="form-group">
						<label>NAME</label>
						<input type="text" id="name_u" name="name" class="form-control" required>
					</div>
					<div class="form-group">
						<label>PRICE</label>
						<input type="number" id="price_u" name="price" class="form-control" required>
					</div>
					<div class="form-group">
						<label>UPC</label>
						<input type="text" id="upc_u" name="upc" class="form-control" required>
					</div>
					<div class="form-group">
						<label>STATUS</label>
						<p>
							<input type="radio" class="check" id="rac" name="check_u" value="0"><label>Active</label>
	                       	<input type="radio" class="check" id="rde" name="check_u" value="1"><label>Deactive</label>
						</p>
					</div>
					<div class="form-group">
						<label>IMAGE</label>
						<input type="file" id="image_u" name="image" class="form-control" >
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" value="2" name="type" id="type2">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<button type="submit" class="btn btn-info" id="addupdate">Update</button>
				</div>

			</form>
		</div>
	</div>
</div>

<!-- Delete Modal HTML -->
<div id="deleteProductModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<form>
				<div class="modal-header">						
					<h4 class="modal-title">Delete Product</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="id_d" name="id" class="form-control">					
					<p>Are you sure you want to delete these Records?</p>
					<p class="text-warning"><small>This action cannot be undone.</small></p>
				</div>
				<div class="modal-footer">
					<input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<button type="button" class="btn btn-danger" id="delete">Delete</button>
				</div>
			</form>
		</div>
	</div>
</div>

</body>
<script src="ajax/ajax.js"></script>
</html>