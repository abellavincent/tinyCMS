<div class="content-wrapper">
    <h3 class="page-heading mb-4">Add New Slider </h3>

    <div class="row align-items-start">
            
            <!-- Left Main Content -->
    	    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card-body my-card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title"><h5>Title *</h5></label>
                                <span class="pull-right err-title"></span>
                                <input type="text" class="form-control p-input" value="" name="title" id="title" placeholder="Enter slider title">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="link"><h5>Url Link *</h5></label>
                                <span class="pull-right err-link"></span>
                                <input type="text" class="form-control p-input" value="" name="link" id="link" placeholder="Enter url address">
                            </div>
                        </div>
                    </div>
                </div>


                <div class="card-body my-card card-spacer">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description"><h5>Description *</h5></label>
                                <span class="pull-right err-description"></span>
                                <textarea class="form-control p-input" maxlength="230" name="description" id="description" rows="5" placeholder="Please type the slider description"></textarea>
                                <div id="charNum"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order_position"><h5>Order Position *</h5></label>
                                <span class="pull-right err-order_position"></span>
                                <input type="text" class="form-control p-input" value="" name="order_position" id="order_position" placeholder="Enter order position of slider" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                            </div>
                        </div>
                    </div>
                </div>


               

                <div class="card-body my-card card-spacer">
                    <div class="col-md-12 no-padding">
                        <form id="imageform" class="pull-right" method="post" enctype="multipart/form-data" action='<?php echo site_url('admin/gallery/upload_image');?>' style="margin-top: -10px;">
                            <div class="fileUpload btn btn-success">
                                <span id="btn-upload-img"><i class="fa fa-file-image-o"></i> Upload   </span>
                                <input type="file" class="upload" id="photoimg" name="photoimg" accept='image/*'/>
                            </div>
                        </form>

                        <div class="form-group">
                            <label for="description"><h5>Upload Image *</h5></label>
                            <p class="col-blue-grey" style="font-size: 11px;">
                                Max file size: <b>5MB</b>.<br> 
                                Min Dimension: <b>1600 by 600 pixels</b><br>
                                <b>JPG</b>, <b>PNG</b>, <b>GIF</b>, <b>BMP</b> or <b>GIF</b> allowed file types. 
                            </p>
                            <span class="pull-right err-description"></span>
                            <p id="img-preview"><img src="<?php echo base_url(); ?>/assets/images/1600x600.png" style="width: 100%;"></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="hidden" value="" id="image-url">
                        <button type="button" id="btn-save-slider" class="btn btn-primary">
                            <i class="fa fa-check-square-o"></i> Save New Slider
                        </button>
                        &nbsp;&nbsp;
                        <span class="processing-loader" style="display:none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
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
        var title, link, order_position, description, image_url;
    

       

        /**
		 * Controls:: Save Slider
        */
        $('#btn-save-slider').click(function(e){
            e.preventDefault();
            title = $('#title').val();
            link = $('#link').val();
            order_position = $('#order_position').val();
            description = $('#description').val();
            image_url = $('#image-url').val();


            //validations
            if(title.length == 0){
                $('#title').focus();
                $('#title').css('border', '1px solid red');
            }else if(link.length == 0){
                $('#link').focus();
                $('#link').css('border', '1px solid red');
            }else if(order_position.length == 0){
                $('#order_position').focus();
                $('#order_position').css('border', '1px solid red');
            }else if(description.length == 0){
                $('#description').focus();
                $('#description').css('border', '1px solid red');
            }else if(image_url.length == 0){
                $('#image-url').focus();
                showMessage('Image Required', 'Please upload an image', 'warning');
            }
            else{
                saveSlider();
            }

           
        });



        /**
         * Method:: Save Slider
        */
        function saveSlider(){
            $(".processing-loader").show(); //show loader
            $("#btn-save-slider").prop('disabled', true);

            $.ajax({
                type: "POST",
                url: base_url +'admin/themes/slider/save',
                dataType: 'json',
                data: {
                    title: title, 
                    link: link, 
                    order_position: order_position, 
                    description: description, 
                    image_url: image_url,
                    form_submit: true
                }, 
                success: function(response){
                    $(".processing-loader").hide(); //hide loader
                    console.log(response);
                    if(response.success == true){
                        showSuccessMessage(response.id);
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    
                }
            });
        }





        /**
         * Method:: SweetAlert Pop Ups
        */
       	function showSuccessMessage(slider_id) {
            swal({
                title: "Good Job!",
                text: "New slider has been added!",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
                }, function () {
                    window.location.replace( base_url+"admin/themes/slider/edit/" +slider_id);
            });
        }

        //general pop up
        function showMessage(title, description, status) {
            swal(title, description, status);
        }


        /**
         * upload featured image  and return the url
         *
         */
        $('#photoimg').on('change', function(){ 
        $("#img-preview").html('');
        $("#img-preview").html('<br><br><br><center><img src="'+ base_url +'assets/images/loader.gif" alt="Uploading...."/><br>Uploading...</center><br><br><br>');
        $("#imageform").ajaxForm({
            dataType: 'json',
            success: function(response) {
                $("#img-preview").html('<img src="'+base_url +response.image_url +'" style="width: 100%">');
                $("#btn-upload-img").html('<i class="fa fa-check"></i></span> Change');
                $("#image-url").val(response.image_url);
               console.log(response);
            }

        }).submit();
               
        });



        //character counter
        $('#description').keyup(function () {
          var max = 200;
          var len = $(this).val().length;
          if (len >= max) {
            $('#charNum').text(' You have reached the limit.');
          } else {
            var char = max - len;
            $('#charNum').text(char + ' characters left');
          }
        });

       	
	});
</script>

