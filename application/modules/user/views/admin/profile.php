<div class="content-wrapper">
    <h3 class="page-heading mb-4">Edit Profile</h3>

    <div class="row">


        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">

                    <form id="imageform" class="pull-right" style="margin-top: -10px;" method="post" enctype="multipart/form-data" action='<?php echo site_url('admin/gallery/upload_image');?>'>
                        <div class="fileUpload btn btn-success">
                            <span id="btn-upload-img"><i class="fa fa-camera"></i></span>
                            <input type="file" class="upload" id="photoimg" name="photoimg" accept='image/*'/>
                        </div>
                    </form>

                    <h5 class="card-title mb-4">Change Avatar</h5>


                    <div class="user-profile col-md-12 col-sm-12 no-padding">
                        <div class="user-img col-md-12 col-sm-12 no-padding">
                            <img src="<?php echo site_url().$user->image;?>" class="img-responsive">
                        </div>
                        <div class="user-name col-md-12 col-sm-12 no-padding"><p><?php echo $user->first_name ." ". $user->last_name;?></p></div>
                        <div class="user-role col-md-12 col-sm-12 no-padding"><p><?php echo $this->session->userdata('user_role');?></p></div>
                    </div>

                    <div id="btn-save-avatar" class="form-group" style="text-align: center;display:none;">
                        <input type="hidden" value="" id="image-url">
                        <button type="submit" id="btn-save-avatar" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save New Avatar</button><br><br>
                        <span class="processing-loader-avatar" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                    </div>

                </div>
            </div>
        </div>




	    <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                  	<h5 class="card-title mb-4">User Information</h5>
                  	<form id="edit-userinfo-form">
                        <div class="form-group">
                            <label for="username"><b>Username *</b> </label>
                            <input type="text" class="form-control p-input" value="<?php echo $user->username;?>" name="username" id="username" placeholder="Enter username" disabled="">
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
                            <button type="submit" id="btn-save-info" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Update Info</button> &nbsp;&nbsp;
                            <span class="processing-loader-info" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        





        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Change Password</h5>
                    <p style="margin-bottom: 25px;">Use this form to change your password. Once changed, your new password will be in effect next time you login.</p>

                    <form id="change-password-form">
                        <div class="form-group">
                            <label for="password"><b>Old Password *</b></label>
                            <span class="pull-right err-authenticate"></span>
                            <input type="password" class="form-control p-input" name="password" id="old-password" placeholder="Password">
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
                            <button type="submit" id="btn-change-password" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Change Password</button>&nbsp;&nbsp;
                            <span class="processing-loader-password" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Processing...</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div><!--./row-->
</div><!--./content-wrapper-->


<!-- JS Lib For AJAX FORM -->
<script src="<?php echo site_url('assets/js/jquery.form.js');?>"></script>



<!-- Le javascripts **********************************************************************************************-->
<script type="text/javascript">
    $(document).ready(function(){
        
        var base_url = '<?php echo site_url();?>';
        
       
        /**
         * Change Avatar
         */
        $('#photoimg').on('change', function(){ 
            $(".user-img").html('');
            $(".user-img").html('<br><br><br><img src="'+ base_url +'assets/images/loader.gif" alt="Uploading...."/><br><center>Uploading...</center><br><br><br>');
            $("#imageform").ajaxForm({
                dataType: 'json',
                success: function(response) {
                    $('#btn-save-avatar').show();
                    $(".user-img").html('<img src="'+base_url +response.image_url +'" class="img-responsive">');
                    $("#btn-upload-img").html('<i class="fa fa-check"></i></span>');
                    $("#image-url").val(response.image_url);
                   console.log(response);
                }

            }).submit();
                   
        });



        //save avatar
        $('#btn-save-avatar').click(function(){
            var image = $('#image-url').val();
            save_avatar(image);
        });


        function save_avatar(image){
            $('.processing-loader-avatar').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/users/update_avatar',
                dataType: 'json',
                data: {
                    image: image, 
                    form_submit: true
                }, 
                success: function(response){
                    $('.processing-loader-avatar').hide();
                    if(response.success == true){
                        showUpdateAvatarSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }
        /**
         * END Change Avatar
         */





        /**
         * Edit User Info  
        */
        $('#btn-save-info').click(function(e){
            e.preventDefault();
            var email = $('#email').val();
            var first_name = $('#first-name').val();
            var last_name = $('#last-name').val(); 

            if(!validateEmail(email)){
                $('#email').focus();
                $('#email').css('border', '1px solid red');
                $('.err-email').html('<span style="color: red">Invalid email address.</span>');
            }else if(first_name.length == 0){
                $('#first-name').focus();
                $('#first-name').css('border', '1px solid red');
            }else if(last_name.length == 0){
                $('#last-name').focus();
                $('#last-name').css('border', '1px solid red'); 
            }
            else{
                update_user_info(email, first_name, last_name);
            }
            
        });

        function update_user_info(email, first_name, last_name){
            $('.processing-loader-info').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/users/update_user_info',
                dataType: 'json',
                data: {
                    email: email, 
                    first_name: first_name,
                    last_name: last_name,
                    form_submit: true
                }, 
                success: function(response){
                    $('.processing-loader-info').hide();
                    if(response.success == true){
                        showUpdateInfoSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });   
        }

        function validateEmail(email) {
          var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          return regex.test(email);
        }   
        /**
         * #END# Edit User Info  
        */




        /**
         * Change Password
        */
        $('#btn-change-password').click(function(e){
            e.preventDefault();
            var old_password = $('#old-password').val();
            var new_password = $('#password').val();
            var new_password_confirm = $('#confirm-password').val();

            if(new_password != new_password_confirm){
                $('.err-password').html('<span style="color: red">Password do not match.</span>');
                $('#password').css('border', '1px solid red');$('#confirm-password').css('border', '1px solid red');
                $('#confirm-password').css('border', '1px solid red');
            }else{
                change_password(old_password, new_password);
            }
            
        });

        function change_password(old_password, new_password){
            $('.processing-loader-password').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/users/change_password',
                dataType: 'json',
                data: {
                    old_password: old_password, 
                    new_password: new_password,
                    form_submit: true
                }, 
                success: function(response){
                    $('.processing-loader-password').hide();
                    if(response.success == 'authenticate_failed'){
                        $('#old-password').focus();
                        $('#old-password').css('border', '1px solid red');
                        $('.err-authenticate').html('<span style="color: red">Invalid password.</span>');
                    }else if(response.success == true){
                        showUpdatePasswordSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    console.log(response.success);
                }
            });      
        }
        /**
         * #END# Change Password
        */



        /**
         * Sweet Alert - Pop Up 
         *
        */
        function showUpdateAvatarSuccess() {
            swal({
                title: "Success!",
                text: "Please logout for the changes to take effect.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload();
            });
        }

        function showUpdateInfoSuccess() {
            swal({
                title: "Success!",
                text: "Your profile information has been successfully updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload();
            });
        }

        function showUpdatePasswordSuccess() {
            swal({
                title: "Success!",
                text: "Please logout for the changes to take effect.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload();
            });
        }


    });
</script>