<div class="content-wrapper">
    <h3 class="page-heading mb-4">Theme Options</h3>


    <div class="vertical-tab">
        <ul class="nav nav-tabs tab-basic" role="tablist">
            <li class="nav-item">
                <a class="nav-link active show" id="tab-3-1" data-toggle="tab" href="#home-3-1" role="tab" aria-controls="home-3-1" aria-selected="true">General Info</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-3-2" data-toggle="tab" href="#profile-3-2" role="tab" aria-controls="profile-3-2" aria-selected="false">Social Media</a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" id="tab-3-3" data-toggle="tab" href="#contact-3-3" role="tab" aria-controls="contact-3-3" aria-selected="false">Backgrounds</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-3-4" data-toggle="tab" href="#contact-3-4" role="tab" aria-controls="contact-3-4" aria-selected="false">Promo Content</a>
            </li> -->
        </ul>


        <div class="tab-content tab-content-basic">
            
            <div class="tab-pane fade active show" id="home-3-1" role="tabpanel" aria-labelledby="tab-3-1">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">General Information</h5>
                        <form id="save-options-form">
                            <div class="form-group">
                                <label for="contact"><b>Contact No. *</b> </label>
                                <input type="text" class="form-control p-input" value="<?php echo $theme_options->contact;?>" name="contact" id="contact" placeholder="Enter contact number">
                            </div>

                            <div class="form-group">
                                <label for="email"><b>Email *</b> </label>
                                <input type="text" class="form-control p-input" value="<?php echo $theme_options->email;?>" name="email" id="email" placeholder="Enter email address">
                                <p class="text-muted">This email address is displayed in public view.</p>
                            </div>

                            <div class="form-group">
                                <label for="address"><b>Address </b></label>
                                <textarea class="form-control p-input" name="address" id="address" rows="5" placeholder="Please enter your company address"><?php echo $theme_options->address;?></textarea>
                            </div>
                        
                            <div class="form-group">
                                <label for="copyright"><b>Copyright *</b> </label>
                                <input type="text" class="form-control p-input" value="<?php echo $theme_options->copyright;?>" name="copyright" id="copyright" placeholder="Enter copyright information">
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


            <div class="tab-pane fade" id="profile-3-2" role="tabpanel" aria-labelledby="tab-3-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Social Media</h5>
                        <form id="save-social-form">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="facebook-area"><i class="fa fa-facebook"></i></span>
                                    <input type="text" id="facebook" value="<?php echo $theme_options->facebook;?>" class="form-control" placeholder="Facebook page link" aria-describedby="facebook-area">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="twitter-area"><i class="fa fa-twitter"></i></span>
                                    <input type="text" id="twitter" class="form-control" value="<?php echo $theme_options->twitter;?>" placeholder="Twitter page link" aria-describedby="twitter-area">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="instagram-area"><i class="fa fa-instagram"></i></span>
                                    <input type="text" id="instagram" class="form-control" value="<?php echo $theme_options->instagram;?>" placeholder="Instagram page link" aria-describedby="instagram-area">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="youtube-area"><i class="fa fa-youtube-play"></i></span>
                                    <input type="text" id="youtube" class="form-control" value="<?php echo $theme_options->youtube;?>" placeholder="Youtube channel link" aria-describedby="youtube-area">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon" id="google-plus-area"><i class="fa fa-google-plus"></i></span>
                                    <input type="text" id="google-plus" class="form-control" value="<?php echo $theme_options->google_plus;?>" placeholder="Google plus page link" aria-describedby="google-plus-area">
                                </div>
                            </div>


                            
                            <div class="form-group">
                                <input type="hidden" value="" id="category-id"/>
                                <button type="submit" id="btn-save-social" class="btn btn-primary"><i class="fa fa-check-square-o"></i>&nbsp; Save</button>&nbsp;&nbsp;
                                <span class="processing-loader-social" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;</center>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade" id="contact-3-3" role="tabpanel" aria-labelledby="tab-3-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form id="imageform" class="pull-right" method="post" enctype="multipart/form-data" action='<?php echo site_url('admin/gallery/upload_image');?>' style="margin-top: -10px;">
                                    <div class="fileUpload btn btn-success">
                                        <span id="btn-upload-img"><i class="fa fa-file-image-o"></i> Change   </span>
                                        <input type="file" class="upload" id="photoimg" name="photoimg" accept='image/*'/>
                                    </div>
                                </form>

                                <h5 class="card-title mb-4">
                                    Homepage Background
                                </h5>
                                <p id="home_bg_preview"><img src="<?php echo site_url().$theme_options->home_background;?>" style="width:100%"></p>
                            
                                <div id="btn-save-avatar" class="form-group" style="text-align: center;display:none;">
                                    <input type="hidden" value="" id="image-url-home-bg">
                                    <button type="submit" id="btn-save-home-bg" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save New Background</button><br><br>
                                    <span class="processing-loader-home-bg" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <form id="imageform-promo" class="pull-right" method="post" enctype="multipart/form-data" action='<?php echo site_url('admin/gallery/upload_image');?>' style="margin-top: -10px;">
                                    <div class="fileUpload btn btn-success">
                                        <span id="btn-upload-img-promo"><i class="fa fa-file-image-o"></i> Change </span>
                                        <input type="file" class="upload" id="photoimg-promo" name="photoimg" accept='image/*'/>
                                    </div>
                                </form>

                                <h5 class="card-title mb-4">
                                    Promo Background
                                </h5>
                                <p id="promo_bg_preview"><img src="<?php echo site_url().$theme_options->promo_background;?>" style="width:100%"></p>
                            
                                <div id="btn-save-promo" class="form-group" style="text-align: center;display:none;">
                                    <input type="hidden" value="" id="image-url-promo">
                                    <button type="submit" id="btn-save-promo" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save New Background</button><br><br>
                                    <span class="processing-loader-promo" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="tab-pane fade" id="contact-3-4" role="tabpanel" aria-labelledby="tab-3-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Promo Content</h5>
                        <textarea class="form-control p-input" name="content" id="content" rows="5" placeholder="Please type the page content"><?php echo $theme_options->promo_content;?></textarea>
                        <br>
                        <div class="form-group">
                            <button type="submit" id="btn-save-promo-content" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save Content</button>&nbsp;&nbsp; 
                            <span class="processing-loader-promo-content" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

</div><!--./content-wrapper-->



<!--START FROALA RICH TEXT EDITOR-->
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/froala_editor.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/froala_style.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/plugins/code_view.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/plugins/image_manager.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/plugins/image.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/plugins/table.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/plugins/video.css');?>">
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/froala-editor/css/codemirror.min.css');?>">
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/codemirror.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/xml.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/froala_editor.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/align.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/code_beautifier.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/code_view.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/draggable.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/image.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/image_manager.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/link.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/lists.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/paragraph_format.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/paragraph_style.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/table.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/video.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/url.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/entities.min.js');?>"></script>

<script>
    $(function() {
        $('#content').froalaEditor({
            //toolbars
            toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],        
            heightMin: 275,
            heightMax: 2000,
            pastePlain: true
        });

    });
</script>
<!--#END# FROALA RICH TEXT EDITOR-->


<!-- JS Lib For AJAX FORM -->
<script src="<?php echo site_url('assets/js/jquery.form.js');?>"></script>

<!-- Le Javascripts -->
<script type="text/javascript">
  $(document).ready(function(){
  
    var base_url = '<?php echo site_url();?>';
   
    /**
     * Save General Setting
    */
    $('#btn-save-settings').click(function(e){
        e.preventDefault();
        var contact = $('#contact').val();
        var email = $('#email').val();
        var address = $('#address').val();
        var copyright = $('#copyright').val();

        if(contact.length == 0){
            $('#contact').focus();
            $('#contact').css('border', '1px solid red');
        }else if( !validateEmail(email)){
            $('#email').focus();
            $('#email').css('border', '1px solid red');
        }else if(address.length == 0){
            $('#address').focus();
            $('#address').css('border', '1px solid red');
        }else if(copyright.length == 0){
            $('#copyright').focus();
            $('#copyright').css('border', '1px solid red');
        }
        else{
            save_options(contact, email, address, copyright);  
        }
        
    });


    function save_options(contact, email, address, copyright){
        $('.processing-loader-general').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/themes/save_options',
            dataType: 'json',
            data: {
                contact: contact, 
                email: email,
                address: address,
                copyright: copyright,
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-general').hide();
                if(response.success == true){
                    showSuccessMessage();
                }else{
                    alert('Something went wrong. Please try again!');
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
     * Save Social Media Settings
    */
    $('#btn-save-social').click(function(e){
        e.preventDefault();
        var facebook = $('#facebook').val();
        var twitter = $('#twitter').val();
        var instagram = $('#instagram').val();
        var youtube = $('#youtube').val();
        var google_plus = $('#google-plus').val();

        save_social(facebook, twitter, instagram, youtube, google_plus);
    });

    function save_social(facebook, twitter, instagram, youtube, google_plus){
        $('.processing-loader-social').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/themes/save_social',
            dataType: 'json',
            data: {
                facebook: facebook, 
                twitter: twitter,
                instagram: instagram,
                youtube: youtube,
                google_plus: google_plus,
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-social').hide();
                if(response.success == true){
                    showSuccessSocialMessage();
                }else{
                    alert('Something went wrong. Please try again!');
                }
                //console.log(response);
            }
        });
    }
     /*#END# social media settings*/





     /**
     * Save Promo Content
    */
    $('#btn-save-promo-content').click(function(e){
        e.preventDefault();
        var content = $('#content').val();
        save_promo_content(content);
    });

    function save_promo_content(content){
        $('.processing-loader-promo-content').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/themes/save_promo_content',
            dataType: 'json',
            data: {
                content: content, 
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-promo-content').hide();
                if(response.success == true){
                    showSuccessPromoContentMessage();
                }else{
                    alert('Something went wrong. Please try again!');
                }
                //console.log(response);
            }
        });
    }
     /*#END# social media settings*/




    /**
     * Save Promo Background
    */
    $('#btn-save-promo').click(function(){
        var promo_background = $('#image-url-promo').val();
        save_promo_background(promo_background);
    });
    function save_promo_background(promo_background){
        $('.processing-loader-promo').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/themes/save_promo_bg',
            dataType: 'json',
            data: {
                promo_background: promo_background, 
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-promo').hide();
                console.log(response);
                if(response.success == true){
                    showSuccessPromoBGMessage();
                }else{
                    alert('Something went wrong. Please try again!');
                }
                //console.log(response);
            }
        });
    }




    /**
     * Save Home Background
    */
    $('#btn-save-home-bg').click(function(){
        var home_background = $('#image-url-home-bg').val();
        save_home_background(home_background);
    });
    function save_home_background(home_background){
        $('.processing-loader-home-bg').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/themes/save_home_bg',
            dataType: 'json',
            data: {
                home_background: home_background, 
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-home-bg').hide();
                console.log(response);
                if(response.success == true){
                    showSuccessHomeBGMessage();
                }else{
                    alert('Something went wrong. Please try again!');
                }
                //console.log(response);
            }
        });
    }
   


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

    function showSuccessSocialMessage() {
        swal({
            title: "Success!",
            text: "Social media settings has been successfully updated.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#4ed1f7",
            confirmButtonText: "OK",
            closeOnConfirm: false
        }, function () {
            location.reload(); //reload page after submitted
        });
    }

    function showSuccessHomeBGMessage() {
        swal({
            title: "Success!",
            text: "Homepage background has been successfully updated.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#4ed1f7",
            confirmButtonText: "OK",
            closeOnConfirm: false
        }, function () {
            location.reload(); //reload page after submitted
        });
    }

    function showSuccessPromoBGMessage() {
        swal({
            title: "Success!",
            text: "Promo background has been successfully updated.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#4ed1f7",
            confirmButtonText: "OK",
            closeOnConfirm: false
        }, function () {
            location.reload(); //reload page after submitted
        });
    }


    function showSuccessPromoContentMessage() {
        swal({
            title: "Success!",
            text: "Promo content has been successfully updated.",
            type: "success",
            showCancelButton: false,
            confirmButtonColor: "#4ed1f7",
            confirmButtonText: "OK",
            closeOnConfirm: false
        }, function () {
            location.reload(); //reload page after submitted
        });
    }


    //BACKGROUND settings update
    /**
     * Change Avatar
     */
    $('#photoimg').on('change', function(){ 
        $("#home_bg_preview").html('');
        $("#home_bg_preview").html('<br><br><br><center><img src="'+ base_url +'assets/images/loader.gif" alt="Uploading...."/><br>Uploading...</center><br><br><br>');
        $("#imageform").ajaxForm({
            dataType: 'json',
            success: function(response) {
                $('#btn-save-avatar').show();
                $("#home_bg_preview").html('<img src="'+base_url +response.image_url +'" style="width: 100%">');
                $("#btn-upload-img").html('<i class="fa fa-check"></i></span>');
                $("#image-url-home-bg").val(response.image_url);
               console.log(response);
            }

        }).submit();
               
    });


     /**
     * Change Avatar
     */
    $('#photoimg-promo').on('change', function(){ 
        $("#promo_bg_preview").html('');
        $("#promo_bg_preview").html('<br><br><br><center><img src="'+ base_url +'assets/images/loader.gif" alt="Uploading...."/><br>Uploading...</center><br><br><br>');
        $("#imageform-promo").ajaxForm({
            dataType: 'json',
            success: function(response) {
                $('#btn-save-promo').show();
                $("#promo_bg_preview").html('<img src="'+base_url +response.image_url +'" style="width: 100%">');
                $("#btn-upload-img-promo").html('<i class="fa fa-check"></i></span>');
                $("#image-url-promo").val(response.image_url);
               console.log(response);
            }

        }).submit();
               
    });
        
  });
</script>