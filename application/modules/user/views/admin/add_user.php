<div class="content-wrapper">
    <h3 class="page-heading mb-4">Add New User</h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  	<h5 class="card-title mb-4">User Information</h5>
                  	<form id="add-user-form">
                        <div class="form-group">
                            <label for="username"><b>Username *</b> </label>
                            <span id="check-username" class="pull-right" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Checking availability...</span>
                            <input type="text" class="form-control p-input" value="" name="username" id="username" placeholder="Enter username">
                        </div>
                        <div class="form-group">
                            <label for="email"><b>Email address *</b></label>
                            <span class="pull-right err-email"></span>
                            <input type="email" class="form-control p-input" name="emmail" id="email" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="first-name"><b>First Name *</b></label>
                            <input type="text" class="form-control p-input" name="first-name" id="first-name" placeholder="Enter first name">
                        </div>

                        <div class="form-group">
                            <label for="last-name"><b>Last Name *</b></label>
                            <input type="text" class="form-control p-input" name="last-name" id="last-name" placeholder="Enter last name">
                        </div>

                        <div class="form-group">
                            <label for="password"><b>Password *</b></label>
                            <span class="pull-right err-password"></span>
                            <input type="password" class="form-control p-input" name="password" id="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password"><b>Confirm Password *</b></label>
                            <span class="pull-right err-password"></span>
                            <input type="password" class="form-control p-input" name="confirm-password" id="confirm-password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleSelect1"><b>Role *</b></label>
                            <select class="form-control" id="user-role">
                                <option value="0">Please select...</option>
                                <?php if($user_role): foreach($user_role as $role):?>
                                    <option value="<?php echo $role->id;?>"><?php echo $role->name;?></option>
                                <?php endforeach; endif;?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <label>
                                    <input type="checkbox" id="status" class="form-check-input">
                                    Automatically activate this account upon saving
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                
                        </div>
                        <div class="form-group">
                            <button type="submit" id="btn-submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save New User</button>&nbsp;&nbsp;
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
        var username, email, first_name, last_name, password, confirm_password, status, role_id; 
        var username_exist = false;


        /**
         * Controls:: Save New User
        */
        $('#btn-submit').click(function(e){
            e.preventDefault();
            username = $('#username').val();
            email = $('#email').val();
            first_name = $('#first-name').val();
            last_name = $('#last-name').val();
            password = $('#password').val();
            confirm_password = $('#confirm-password').val();
            status = $('#status').is(':checked') ? 'active':'inactive';
            role_id = $('#user-role').val();
            
            if(username.length == 0 || username_exist == true){
                $('#username').focus();
                $('#username').css('border', '1px solid red');
            }else if(email.length == 0){
                $('#email').focus();
                $('#email').css('border', '1px solid red');
            }else if(first_name.length == 0){
                $('#first-name').focus();
                $('#first-name').css('border', '1px solid red');
            }else if(last_name.length == 0){
                $('#last-name').focus();
                $('#last-name').css('border', '1px solid red');
            }else if(password.length == 0){
                $('#password').focus();
                $('#password').css('border', '1px solid red');
            }else if(confirm_password.length == 0){
                $('#confirm-password').focus();
                $('#confirm-password').css('border', '1px solid red');
            }
            else if(role_id == 0){
                $('#user-role').focus();
                $('#user-role').css('border', '1px solid red');
            }else if(password != confirm_password){
                $('.err-password').html('<span style="color: red">Password do not match.</span>');
                $('#password').css('border', '1px solid red');$('#confirm-password').css('border', '1px solid red');
                $('#confirm-password').css('border', '1px solid red');
            }else if( !validateEmail(email)){
                $('#username').focus();
                $('#email').css('border', '1px solid red');
                $('.err-email').html('<span style="color: red">Invalid email address.</span>');
            }
            else{
                saveUser();
            }
            
        });




        /**
         * Method:: Save New User 
        */
        function saveUser(){
            $('.processing-loader').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/users/save',
                dataType: 'json',
                data: {
                    username: username, 
                    email: email, 
                    first_name: first_name, 
                    last_name: last_name, 
                    password: password, 
                    role_id: role_id, 
                    status: status
                }, 

                success: function(response){
                    $('.processing-loader').hide();
                    if(response.success == true){
                        var url = base_url +'admin/users/edit/'+response.id;
                        showUpdateSuccess(url);
                    }else{
                        alert('Something went wrong. Please try again.');
                        location.reload();
                    }
                    
                }
            });
        }




        /**
         * Method:: Check username exist on keyup
        */
        $('#username').keyup(function(){
            $('#check-username').show();
            var username = $(this).val();
            checkUsernameExist(username);
            return false;
        });
          
      
        function checkUsernameExist(username){
            $.ajax({
                type: "POST",
                url: base_url +'admin/users/is_username_exist',
                dataType: 'json',
                data: {
                    username: username, 
                }, 

                success: function(response){
                   if(response.exist == true){
                        $('#check-username').html('<span style="color: red;"><i class="fa fa-remove" aria-hidden="true"></i> Username not available</span>');
                        username_exist = true;
                   }else{
                        $('#check-username').html('<span style="color: #00cc33;"><i class="fa fa-check" aria-hidden="true"></i> Available</span>');
                        username_exist = false;
                   }
                
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
        function showUpdateSuccess(url) {
            swal({
                title: "Success!",
                text: "User account has been successfully updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                $(location).attr('href', url);
            });
        }


    });
</script>