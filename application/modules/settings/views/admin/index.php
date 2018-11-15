<div class="content-wrapper">
    <h3 class="page-heading mb-4">Settings</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">General Information</h5>
                    <form id="add-user-form">
                        <div class="form-group">
                            <label for="name"><b>Website Name *</b> </label>
                            <input type="text" class="form-control p-input" value="<?php echo $settings->site_name;?>" name="name" id="name" placeholder="Enter website name">
                        </div>

                        <div class="form-group">
                            <label for="name"><b>Tagline *</b> </label>
                            <input type="text" class="form-control p-input" value="<?php echo $settings->tagline;?>" name="tagline" id="tagline" placeholder="Enter tagline">
                            <p class="text-muted">In a few words, explain what this site is about.</p>
                        </div>

                        <div class="form-group">
                            <label for="slug"><b>Base Url *</b></label>
                            <input type="text" class="form-control p-input" value="<?php echo $settings->base_url;?>" name="base-url" id="base-url" placeholder="Your website address">
                        </div>
                        
                        <div class="form-group">
                            <label for="name"><b>Email *</b> </label>
                            <input type="text" class="form-control p-input" value="<?php echo $settings->email;?>" name="email" id="email" placeholder="Enter email address">
                            <p class="text-muted">This email address is used for admin purposes</p>
                        </div>

                        
                        <div class="form-group">
                            <input type="hidden" value="" id="category-id"/>
                            <button type="submit" id="btn-save-settings" class="btn btn-primary"><i class="fa fa-check-square-o"></i>&nbsp; Save</button>&nbsp;&nbsp;
                            <span class="processing-loader-general" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;</center>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-body">

                    <h5 class="card-title mb-4">Upload Logo</h5>
                    

                    <br>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="preview-logo">
                                <img src="<?php echo site_url().$settings->logo;?>" class="img-responsive" style="width: 250px;">   
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- upload button -->
                            <form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url('admin/gallery/upload_image');?>'>
                                <div class="fileUpload btn btn-success">
                                    <span id="btn-upload-img"><i class="fa fa-image"></i> Upload</span>
                                    <input type="file" class="upload" id="photoimg" name="photoimg" accept='image/*'/>
                                </div>
                            </form>
                            <!-- end upload button -->
                            <br style="clear:both;">
                            <p>Upload your custom logo. An image with transparent background logo color works best.</p>
                            
                            <div id="btn-save-logo-wrap" class="form-group" style="display:none;">
                                <input type="hidden" value="" id="logo-url">
                                <button type="submit" id="btn-save-logo" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save</button>&nbsp;&nbsp;
                                <a href="javascript:void()" onclick="location.reload()" class="btn btn-danger">Cancel</a><br><br>
                                <span class="processing-loader-logo" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                            </div>
                        </div>
                    </div>

                    <br>
                    <hr class="text-muted">
                    <br>
                    <h5 class="card-title mb-4">Website Favicon</h5>
                    <br>    
                    <div class="row">
                        <div class="col-md-6">
                            <div id="preview-favicon">
                                <img src="<?php echo site_url().$settings->favicon;?>" class="img-responsive" style="width: 64px;">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <form id="imageform-favicon" method="post" enctype="multipart/form-data" action='<?php echo site_url('admin/gallery/upload_image');?>'>
                                <div class="fileUpload btn btn-success">
                                    <span id="btn-upload-img-favicon"><i class="fa fa-image"></i> Upload</span>
                                    <input type="file" class="upload" id="photoimg-favicon" name="photoimg" accept='image/*'/>
                                </div>
                            </form>
                            <br>
                            <p>Upload a favicon image. Please use a square image that's less than 100KB.</p>
                            <p><a href="https://www.abeautifulsite.net/what-are-favicons" target="_blank">What is a favicon?</a></p>
                            <div id="btn-save-favicon-wrap" class="form-group" style="display:none;">
                                <input type="hidden" value="" id="favicon-url">
                                <button type="submit" id="btn-save-favicon" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save</button> &nbsp;&nbsp;
                                <a href="javascript:void()" onclick="location.reload()" class="btn btn-danger">Cancel</a><br><br>
                                <span class="processing-loader-favicon" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!--./row-->
</div><!--./content-wrapper-->


<!-- JS Lib For AJAX FORM -->
<script src="<?php echo site_url('assets/js/jquery.form.js');?>"></script>

<!-- Le Javascripts -->
<script type="text/javascript">
  $(document).ready(function(){
  
    var base_url = '<?php echo site_url();?>';
    var website_name, base_url, parent_id, description, category_id;

    
    /**
     * Change Logo
    */
    $('#photoimg').on('change', function(){ 
        $("#preview-logo").html('');
        $("#preview-logo").html('<br><br><br><img src="'+ base_url +'assets/images/loader.gif" alt="Uploading...."/><br><center>Uploading...</center><br><br><br>');
        $("#imageform").ajaxForm({
            dataType: 'json',
            success: function(response) {
                $('#btn-save-logo-wrap').show();
                $("#preview-logo").html('<img src="'+base_url +response.image_url +'" class="img-responsive" style="width: 250px;">');
                $("#btn-upload-img").html('<i class="fa fa-image"></i> Change');
                $("#logo-url").val(response.image_url);
                console.log(response);
            }

        }).submit();
               
    });



    /**
     * Change Favicon 
    */
    $('#photoimg-favicon').on('change', function(){ 
        $("#preview-favicon").html('');
        $("#preview-favicon").html('<br><br><br><img src="'+ base_url +'assets/images/loader.gif" alt="Uploading...."/><br><center>Uploading...</center><br><br><br>');
        $("#imageform-favicon").ajaxForm({
            dataType: 'json',
            success: function(response) {
                $('#btn-save-favicon-wrap').show();
                $("#preview-favicon").html('<img src="'+base_url +response.image_url +'" class="img-responsive" style="width: 64px;">');
                $("#btn-upload-img-favicon").html('<i class="fa fa-image"></i> Change');
                $("#favicon-url").val(response.image_url);
                console.log(response);
            },
            error: function(err){
                console.log(err);
            }

        }).submit();
    });





    /**
     * Save General Setting
    */
    $('#btn-save-settings').click(function(e){
        e.preventDefault();
        var site_name = $('#name').val();
        var tagline = $('#tagline').val();
        var base = $('#base-url').val();
        var email = $('#email').val();

        if(site_name.length == 0){
            $('#name').focus();
            $('#name').css('border', '1px solid red');
        }else if(tagline.length == 0){
            $('#tagline').focus();
            $('#tagline').css('border', '1px solid red');
        }else if(base.length == 0){
            $('#base-url').focus();
            $('#base-url').css('border', '1px solid red');
        }else if( !validateEmail(email)){
            $('#email').focus();
            $('#email').css('border', '1px solid red');
        }
        else{
            save_settings(site_name, tagline, base, email);
        }


    });


    function save_settings(site_name, tagline, base, email){
        $('.processing-loader-general').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/settings/update_general_info',
            dataType: 'json',
            data: {
                site_name: site_name, 
                tagline: tagline,
                base: base,
                email: email,
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-general').hide();
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
    /*#END# general settings*/



    
    /**
     * Method:: Check if email is valid
    */
    function validateEmail(email) {
      var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
      return regex.test(email);
    }





    /**
     * Save Logo
    */
    $('#btn-save-logo').click(function(){
        var logo = $('#logo-url').val();
        save_logo(logo);
    });

    function save_logo(logo){
        $('.processing-loader-logo').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/settings/save_logo',
            dataType: 'json',
            data: {
                logo: logo, 
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-logo').hide();
                if(response.success == true){
                    showSuccessLogoMessage();
                }else{
                    alert('Something went wrong. Please try again!');
                    location.reload();
                }
                //console.log(response);
            }
        });   
    }
    /*#END# save logo*/



    /**
     * Save Favicon
    */
    $('#btn-save-favicon').click(function(){
        var favicon = $('#favicon-url').val();
        save_favicon(favicon);
    });

    function save_favicon(favicon){
        $('.processing-loader-favicon').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/settings/save_favicon',
            dataType: 'json',
            data: {
                favicon: favicon, 
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-favicon').hide();
                if(response.success == true){
                    showSuccessFaviconMessage();
                }else{
                    alert('Something went wrong. Please try again!');
                    location.reload();
                }
                console.log(response);
            }
        });   
    }
    /*#END# Save Favicon*/




    /*Sweet Alert Pop Up*/
    function showSuccessMessage() {
        swal({
            title: "Success!",
            text: "General information has been successfully updated.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#4ed1f7",
            confirmButtonText: "OK",
            closeOnConfirm: false
        }, function () {
            location.reload(); //reload page after submitted
        });
    }

    function showSuccessLogoMessage() {
        swal({
            title: "Success!",
            text: "Website logo has been successfully updated.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#4ed1f7",
            confirmButtonText: "OK",
            closeOnConfirm: false
        }, function () {
            location.reload(); //reload page after submitted
        });
    }


    function showSuccessFaviconMessage() {
        swal({
            title: "Success!",
            text: "Website favicon has been successfully updated.",
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