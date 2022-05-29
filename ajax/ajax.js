
// submit add product modal
$(document).on('click','#btn-add',function(e) {
	$("#user_form").valid();
});

	// click on edit icon from listing, open modal
	$(document).on('click','.update',function(e) {
		var id=$(this).attr("data-id");
		var name=$(this).attr("data-name");
		var price=$(this).attr("data-price");
		var upc=$(this).attr("data-upc");
		
		$('#id_u').val(id);
		$('#name_u').val(name);
		$('#price_u').val(price);
		$('#upc_u').val(upc);

		if($('#rac').val() == $(this).attr("data-status")) {
			// $("#rac").prop("checked", true);
			$("#rac").attr('checked', 'checked');
		}else{
			$("#rde").attr('checked', 'checked');
			// $("#rde").prop("checked", true);
		}
	});
	
	// update button click from update modal 
	$(document).on('click','#addupdate',function(e) {

		$("#update_form").valid();
		
	});
	$(document).on("click", ".delete", function() { 
		var id=$(this).attr("data-id");
		$('#id_d').val(id);
		
	});

	// remove single record
	$(document).on("click", "#delete", function() { 
		$.ajax({
			url: "backend/save.php",
			type: "POST",
			cache: false,
			data:{
				type:3,
				id: $("#id_d").val()
			},
			success: function(dataResult){
					$('#deleteProductModal').modal('hide');
					$("#"+dataResult).remove();
			
			}
		});
	});

	$(document).on("click", "#delete_multiple", function() {
		var user = [];
		$(".user_checkbox:checked").each(function() {
			user.push($(this).data('prod-id'));
		});
		console.log(user);
		if(user.length <=0) {
			alert("Please select records."); 
		} 
		else { 
			WRN_PROFILE_DELETE = "Are you sure you want to delete "+(user.length>1?"these rows":"this row")+" ?";
			var checked = confirm(WRN_PROFILE_DELETE);
			if(checked == true) {
				var selected_values = user.join(",");
				console.log(selected_values);
				$.ajax({
					type: "POST",
					url: "backend/save.php",
					cache:false,
					data:{
						type: 4,						
						id : selected_values
					},
					success: function(response) {
						var ids = response.split(",");
						for (var i=0; i < ids.length; i++ ) {	
							$("#"+ids[i]).remove(); 
						}
						$(".selectAll").prop("checked", false);
					} 
				}); 
			}  
		} 
	});

	$(document).ready(function(){

		//add product form validation
		$("#user_form").validate({
		   rules: {
		      name: "required",
		      price: "required",
		      upc: "required",
		      image: {
		      	required:true,
		      	extension: "jpg|jpeg|png|ico|bmp"
		      }
		    },
		    messages: {
		    	image: {
	        		required: "Please upload file.",
	            	extension: "Please upload file in these format only (jpg, jpeg, png, bmp)."
	        	}
		    },
		    ignore: "",
		    errorClass: 'fieldError',
		    onkeyup: false,
		    onblur: false,
		    errorElement: 'label',
		    submitHandler: function () {
				// alert("alert");
				var form_data = new FormData();
				form_data.append("image", document.getElementById('image').files[0]);
				form_data.append("name",$("#name").val());
				form_data.append("price",$("#price").val());
				form_data.append("upc",$("#upc").val());
				form_data.append("status",$("input:radio[name='check']:checked").val());
				form_data.append('type',$("#type1").val());

			    var data = $("#user_form").serialize();
				$.ajax({
					data: form_data,
					type: "post",
					url: "backend/save.php",
					processData: false,
					contentType: false,
					cache: false,
					success: function(dataResult){
						var dataResult = JSON.parse(dataResult);
						if(dataResult.statusCode==200){
							$('#addProductModal').modal('hide');
							alert('Data added successfully !'); 
	                        location.reload();						
						}
						else if(dataResult.statusCode==201){
						   alert(dataResult);
						}
					}
				});

		    }
	  	});

		//edit product form validation
		$("#update_form").validate({
			rules: {
			name: "required",
			price: "required",
			upc: "required",
			image: {
				required:false,
		      	extension: "jpg|jpeg|png|ico|bmp"
		      }
		    },
		    messages: {
		    	image: {
	        		required: "Please upload file.",
	            	extension: "Please upload file in these format only (jpg, jpeg, png, bmp)."
	        	}
		    },
		    ignore: "",
		    errorClass: 'fieldError1',
		    onkeyup: false,
		    onblur: false,
		    errorElement: 'label',
		    submitHandler: function () {
				var form_data1 = new FormData();
				form_data1.append("image", document.getElementById('image_u').files[0]);
				form_data1.append("name",$("#name_u").val());
				form_data1.append("price",$("#price_u").val());
				form_data1.append("upc",$("#upc_u").val());
				form_data1.append("status",$("input:radio[name='check_u']:checked").val());
				form_data1.append('type',$("#type2").val());
				form_data1.append("id",$("#id_u").val());

				var data = $("#update_form").serialize();
				$.ajax({
					data: form_data1,
					type: "post",
					url: "backend/save.php",
					processData: false,
					contentType: false,
					cache: false,
					success: function(dataResult){
							var dataResult = JSON.parse(dataResult);
							if(dataResult.statusCode==200){
								$('#editProductModal').modal('hide');
								alert('Data updated successfully !'); 
		                        location.reload();						
							}
							else if(dataResult.statusCode==201){
							   alert(dataResult);
							}
					}
				});

		    }
		});

		$('[data-toggle="tooltip"]').tooltip();
		var checkbox = $('table tbody input[type="checkbox"]');

		//select all checkboxes
		$(".selectAll").click(function(){
			if(this.checked){
				checkbox.each(function(){
					this.checked = true;                        
				});
			} else{
				checkbox.each(function(){
					this.checked = false;                        
				});
			} 
		});
		checkbox.click(function(){
			if(!this.checked){
				$(".selectAll").prop("checked", false);
			}
		});
	});