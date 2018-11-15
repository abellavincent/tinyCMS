<div class="content-wrapper">
    <h3 class="page-heading mb-4">Routes</h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="col-sm-3 col-sm-offset-3 pull-right no-padding">
                        
                        <a href="<?php echo site_url('admin/routes/add');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add New Route</a>
                    </div>
                    <!-- Search Form -->

                  	<h5 class="card-title mb-4">All Routes &nbsp;&nbsp;</h5>
                  	
                    

                    <br>


                    <div class="table-responsive">

                    	<table id="page-table" class="table table-striped center-aligned-table">
                      	<thead>
                        	<tr class="text-black">
                        		<th>ID</th>
                          		<th>URI</th>
                                <th>Controller</th>
                          		<th>Type</th>
                          		<th width="130px"><span class="pull-right">Actions</span></th>
                        	</tr>
                      	</thead>
                      	<tbody>
                        	<?php if(isset($routes)): if($routes):?>
                                <?php foreach($routes as $route):?>
                                    <tr>
                                        <td><?php echo $route->id;?></td>
                                        <td><?php echo anchor(site_url('admin/routes/edit/'.$route->id), $route->uri, 'class="post-title"');?></b></td>
                                        <td><?php echo $route->controller;?></td>
                                        <td><?php echo $route->type;?></td>
                                       
                                        <td class="pull-right">
                                            
                                            <a href="<?php echo site_url('admin/routes/edit/'.$route->id);?>" class="btn btn-primary btn-sm" title="Edit Route"><i class="fa fa-edit"></i></a> &nbsp; 
                                            
                                            <a href="#" class="btn btn-danger btn-sm delete-route pull-right" data-id="<?php echo $route->id;?>" title="Delete route"><i class="fa fa-trash-o"></i></a>
                                          
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else:?>
                                <tr><td colspan="7"> <p><br>No routes found.</p></td></tr>
                            <?php endif;?>
                            <?php else:?>
                            <?php endif;?>
                      	</tbody>
                    </table>

                  </div>
                  <!-- <span class="pull-right"><?php echo (isset($pagination) ? $pagination:'');?></span> -->
                </div>
            </div>
        </div>
    </div><!--./row-->
</div><!--./content-wrapper-->



<!-- Datatables -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#page-table').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>

<!-- Le Javascripts -->
<script type="text/javascript">
    $(document).ready(function(){

        var base_url = '<?php echo site_url();?>';
        var page_id;
        


        /**
         * Controls:: Move to Trash
        */
        $('body').on('click', '.delete-route', function() {
            route_id = $(this).data('id');
            showConfirmMessage(route_id);
        });

       

        /**
         * Method:: Delete Routes
        */
        function deleteRoute(route_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/routes/delete',
                dataType: 'json',
                data: {
                    route_id: route_id,
                    form_submit: true,
                }, 

                success: function(response){

                    if(response.success == true){
                        showDeleteSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }




        /**
         * Sweet Alert - Pop Up 
         *
        */
        function showConfirmMessage(route_id) {
            swal({
                title: "Are you sure?",
                text: "This route will be deleted permanently. There is no UNDO!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes,Delete it!",
                closeOnConfirm: false
            }, function () {
                deleteRoute(route_id);
            });
        }

        function showDeleteSuccess() {
            swal({
                title: "Success!",
                text: "Route has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }


    });
</script>