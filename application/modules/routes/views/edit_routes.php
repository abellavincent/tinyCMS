<div class="content-wrapper">
    <h3 class="page-heading mb-4">Edit Route &nbsp;&nbsp; <a href="<?php echo site_url('admin/routes/add');?>" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp;Add New Route</a></h3>



    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Route Information</h5>
            
            <div class="form-group">
                <label for="uri"><b>URI *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $route->uri;?>" name="uri" id="uri" placeholder="Enter website URI">
            </div>

            <div class="form-group">
                <label for="controller"><b>Controller *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $route->controller;?>" name="controller" id="controller" placeholder="Enter modules controller">
            </div>

            <div class="form-group">
                <label for="controller"><b>Type *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $route->type;?>" name="type" id="type" placeholder="Enter routes type">
            </div>


            <div class="form-group">
                <input type="hidden" name="route_id" value="<?php echo $route->id;?>" id="route_id">
                <button type="submit" id="btn-save-route" class="btn btn-primary"><i class="fa fa-check-square-o"></i>&nbsp; Save Route</button>&nbsp;&nbsp;
                <span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;</center>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
	$(document).ready(function(){
		var base_url = '<?php echo base_url();?>';
		var uri, controller, type, route_id;

		//get vars
		$('#btn-save-route').click(function(){
			uri = $('#uri').val();
			controller = $('#controller').val();
			type = $('#type').val();
            route_id = $('#route_id').val();

			//alert(uri +"\n" +controller +"\n" +type);
			if(uri.length == 0){
				showMessage('Field Required', 'Please enter website URI', 'warning');
				$('#uri').focus();
			}else if(controller.length == 0){
				showMessage('Field Required', 'Please enter module controller', 'warning');
				$('#controller').focus();
			}else if(type.length == 0){
				showMessage('Field Required', 'Please enter type', 'warning');
				$('#type').focus();
			}else{
				save_route();
			}
			
		});



		//save new route
		function save_route(){
			$(".processing-loader").show(); //hide loader
			$.ajax({
                type: "POST",
                url: base_url +'admin/routes/update',
                dataType: 'json',
                data: {
                    route_id: route_id,
                    uri: uri, 
                    controller: controller, 
                    type: type,
                    form_submit: true
                }, 
                success: function(response){
                    $(".processing-loader").hide(); //hide loader
                    
                    if(response.success == true){
                        showSuccessMessage();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                    
                }
            });
		}



		//sweetalert popup
		function showSuccessMessage() {
            swal({
                title: "Good Job!",
                text: "Route has been successfully updated!",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
                }, function () {
                    location.reload();
            });
        }

        //general pop up
        function showMessage(title, description, status) {
            swal(title, description, status);
        }

	});
</script>