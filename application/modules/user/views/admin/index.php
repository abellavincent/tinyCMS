<div class="content-wrapper">
    <h3 class="page-heading mb-4">Users</h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  	<!-- Search Form -->
                    <div class="col-sm-3 col-sm-offset-3 pull-right no-paddding">
                        <!-- <form id="form-search" action="<?php echo site_url('admin/users/search');?>" method="post">  
                            <input type="hidden" name="form_submit" value="TRUE">
                            <div class="input-group">
                                <input class="form-control" id="search-keyword" name="search-keyword" value="<?php echo (isset($keyword) ? $keyword:'');?>" placeholder="Search ">
                                <div class="input-group-addon" id="btn-submit-search" style="cursor:pointer;"><i class="fa fa-search"></i></div>
                            </div>
                        </form> -->
                        <a href="<?php echo site_url('admin/users/add');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add New User</a>
                    </div>
                    <!-- Search Form -->

                    <h5 class="card-title mb-4">All Users &nbsp;&nbsp;</h5>
                  	
                    <!-- Users Role Counts Tab list -->
                    <div class="row clearfix" style="margin-bottom: 10px;">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a href="<?php echo site_url('admin/users/role/all');?>" class="status-tab-link"><?php echo set_navigation_active_user('all', 'All');?></a> <span class="text-muted">(<?php echo $users_count[0]->All;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/users/role/administrator');?>" class="status-tab-link"><?php echo set_navigation_active_user('administrator', 'Administrator');?></a> <span class="text-muted">(<?php echo $users_count[0]->totalAdmins;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/users/role/editor');?>" class="status-tab-link"><?php echo set_navigation_active_user('editor', 'Editor');?></a> <span class="text-muted">(<?php echo $users_count[0]->totalEditors;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/users/role/user');?>" class="status-tab-link"><?php echo set_navigation_active_user('user', 'User');?></a> <span class="text-muted">(<?php echo $users_count[0]->totalUser;?>)</span>
                        </div>                      
                    </div>

                    <br>
                    <div class="table-responsive">
                    
                        <?php if(isset($is_search)):?>
                            <p class="text-muted pull-right"><?php echo $results_count;?> results</p>
                            <p><b>Search results found for:</b> &nbsp; <i><?php echo $keyword;?></i></p>
                        <?php endif;?>

                    	<table id="users-table" class="table table-striped center-aligned-table">
                      	<thead>
                        	<tr class="text-black">
                        		  <th>Profile</th>
                          		<th>Username</th>
                          		<th>Name</th>
                          		<th>Email</th>
                          		<th>Role</th>
                          		<th>Last Login</th>
                          		<th>Status</th>
                          		<th width="100px"><span class="pull-right">Actions</span></th>
                          		
                        	</tr>
                      	</thead>
                      	<tbody>
                        	<?php if($users): foreach($users as $user):?>
                        		<tr class="">
                        			<td><img src="<?php echo site_url().$user->image;?>" alt="profile image" style="width: 50px;height:50px;border-radius: 50%;float: left;margin-right: 10px;"></td>
	                          		<td><b style="color: #5a5a5a;"><?php echo $user->username;?></b></td>
	                          		<td><?php echo $user->first_name .' '. $user->last_name;?></td>
	                          		<td><?php echo $user->email;?></td>
	                          		<td><?php echo $user->name;?></td>
	                          		<td><?php echo $user->last_login;?></td>
	                          		<td><?php echo setStatus($user->status);?></td>
	                          		<td class="pull-right">
	                          			<a href="<?php echo site_url('admin/users/edit/'. $user->user_id);?>" class="btn btn-primary btn-sm" title="Manage"><i class="fa fa-edit"></i></a> &nbsp; 
	                          			<a href="#" class="btn btn-danger btn-sm delete-user" data-id="<?php echo $user->user_id;?>" title="Delete"><i class="fa fa-trash-o"></i></a>
	                          		</td>
	                        	</tr>
                        	<?php endforeach; else:?>
                                <tr><td colspan="8"><p>No users found.</p></td></tr>
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
        $('#users-table').DataTable();
    });
</script>


<!-- Le Javascripts -->
<script type="text/javascript">
    $(document).ready(function(){

        var base_url = '<?php echo site_url();?>';
        var user_id;

        /**
         * Controls:: Delete User
        */
        $('body').on('click', '.delete-user', function() {
            user_id = $(this).data('id');
            showConfirmMessage(user_id);
           
        });


        /**
         * Method:: Delete User
        */
        function deleteUser(user_id){
             $.ajax({
                type: "POST",
                url: base_url +'admin/users/delete',
                dataType: 'json',
                data: {
                    user_id: user_id,
                }, 

                success: function(response){

                    if(response.success == true){
                        showDeleteSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    
                }
            });
        }



        /**
         * Search Form
        */
        $('#btn-submit-search').click(function(){
            var search_keyword = $('#search-keyword').val();
            if(search_keyword.length == 0){
                $('#search-keyword').focus();
                $('#search-keyword').css('border', '1px solid red');
            }else{
                $('#form-search').submit();
            }
           
        });




        /**
         * Sweet Alert - Pop Up 
         *
        */
        function showConfirmMessage(user_id) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this account.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            }, function () {
               //delete user after confirmation
                deleteUser(user_id);
            });
        }

        function showDeleteSuccess() {
            swal({
                title: "Deleted!",
                text: "User has been successfully deleted.",
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