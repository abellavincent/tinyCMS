<div class="content-wrapper">
    <h3 class="page-heading mb-4">Edit User &nbsp;&nbsp;<a href="<?php echo site_url('admin/users/add');?>" class="btn btn-primary"><i class="fa fa-plus"></i> &nbsp;Add New User</a></h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  	<h5 class="card-title mb-4">User Information</h5>
                  	<form id="add-user-form">
                        <div class="form-group">
                            <label for="username"><b>Username *</b> </label>
                            <input disabled type="text" class="form-control p-input" value="<?php echo $user->username;?>" name="username" id="username" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="email"><b>Email address *</b></label>
                            <span class="pull-right err-email"></span>
                            <input type="email" class="form-control p-input" value="<?php echo $user->email;?>" name="emmail" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="first-name"><b>First Name *</b></label>
                            <input type="text" class="form-control p-input" value="<?php echo $user->first_name;?>" name="first-name" id="first-name" placeholder="Enter first name">
                        </div>

                        <div class="form-group">
                            <label for="last-name"><b>Last Name *</b></label>
                            <input type="text" class="form-control p-input" value="<?php echo $user->last_name;?>" name="last-name" id="last-name" placeholder="Enter last name">
                        </div>

                        <div class="form-group">
                            <label for="password"><b>Password *</b></label>
                            <span class="pull-right err-password"></span>
                            <input type="password" class="form-control p-input" name="password" id="password" placeholder="Password">
                            <p class="text-muted pull-right">If you would like to change the password type a new one. Otherwise leave this blank.</p>
                        </div>
                        <div class="form-group">
                            <label for="confirm-password"><b>Confirm Password *</b></label>
                            <input type="password" class="form-control p-input" name="confirm-password" id="confirm-password" placeholder="Password">
                            <p class="text-muted pull-right">Type your new password again.</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1"><b>Role *</b></label>
                            <select class="form-control" id="user-role">
                                <option value="0">Please select...</option>
                                <?php if($user_role): foreach($user_role as $role):?>
                                    <option value="<?php echo $role->id;?>" <?php echo ($role->id == $user->role_id) ? 'selected':'';?>><?php echo $role->name;?></option>
                                <?php endforeach; endif;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label>
                                    <input type="checkbox" id="status" class="form-check-input" <?php echo ($user->status == 'active') ? 'checked':'';?>>
                                    Automatically activate this account upon saving
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                
                        </div>
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $user->id;?>" id="user-id"/>
                            <button type="submit" id="btn-submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Update User</button> &nbsp;&nbsp;
                            <span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div><!--./row-->
</div><!--./content-wrapper-->





<!-- Le javascripts **********************************************************************************************-->
<script type="text/javascript">
    $(document).ready(function(){
        
        var base_url = '<?php echo site_url();?>';
        var email, first_name, last_name, password, confirm_password, status, role_id, user_id; 
        var username_exist = false;

        $('#btn-submit').click(function(e){
            e.preventDefault();
            email = $('#email').val();
            first_name = $('#first-name').val();
            last_name = $('#last-name').val();
            password = $('#password').val();
            confirm_password = $('#confirm-password').val();
            status = $('#status').is(':checked') ? 'active':'inactive';
            role_id = $('#user-role').val();
            user_id = $('#user-id').val();
            
            if(email.length == 0){
                $('#email').focus();
                $('#email').css('border', '1px solid red');
            }else if(first_name.length == 0){
                $('#first-name').focus();
                $('#first-name').css('border', '1px solid red');
            }else if(last_name.length == 0){
                $('#last-name').focus();
                $('#last-name').css('border', '1px solid red');
            }
            else if(role_id == 0){
                $('#user-role').focus();
                $('#user-role').css('border', '1px solid red');
            }else if(password != confirm_password){
                $('.err-password').html('<span style="color: red">Password do not match.</span>');
                $('#password').css('border', '1px solid red');$('#confirm-password').css('border', '1px solid red');
                $('#confirm-password').css('border', '1px solid red');
            }else if( !validateEmail(email)){
                $('#email').focus();
                $('#email').css('border', '1px solid red');
                $('.err-email').html('<span style="color: red">Invalid email address.</span>');
            }
            else{
                updateUser();
            }
            
        });




        /**
         * Method:: Update User
        */
        function updateUser(){
            $('.processing-loader').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/users/update',
                dataType: 'json',
                data: {
                    user_id: user_id,
                    email: email, 
                    first_name: first_name, 
                    last_name: last_name, 
                    password: password, 
                    role_id: role_id, 
                    status: status
                }, 

                success: function(data){
                    $('.processing-loader').hide();
                    //alert(data);
                    showUpdateSuccess();
                    
                }
            });
        }



        /**
         * Method:: Check if email is valid
        */
        function validateEmail(email) {
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          return regex.test(email);
        }


        /**
         * Sweet Alert - Pop Up 
         *
        */
        function showUpdateSuccess() {
            swal({
                title: "Success!",
                text: "User account has been successfully updated.",
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