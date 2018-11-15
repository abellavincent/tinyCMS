<div class="content-wrapper">
    <h3 class="page-heading mb-4">Add New Post </h3>

    <div class="row align-items-start">
            
            <!-- Left Main Content -->
    	    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
               <div class="card-body my-card">
                    <div class="col-md-12 no-padding">
                        <div class="form-group">
                            <label for="title"><h5>Title *</h5></label>
                            <span class="pull-right err-title"></span>
                            <input type="text" class="form-control p-input" value="" name="title" id="title" placeholder="Enter blog post title">
                        </div>
                    </div>
                </div>

                <div class="card-body my-card card-spacer">
                    <div class="col-md-12 no-padding">
                        <div class="form-group">
                            <label for="slug"><h5>Content *</h5></label>
                            <span class="pull-right err-content"></span>
                            <textarea class="form-control p-input" name="content" id="content" rows="5" placeholder="Please type the category description"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            

            <!-- Right Side Content -->
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card-body my-card ">
                    <div class="col-md-12 no-padding">
                        <div class="form-group">
                            <label for="slug"><h5>Publish</h5></label>
                            <p>Once all of your content is added you have an option to save as draft or publish immediately.</p>
                            <hr>
                            <button id="btn-draft" type="button" class="btn btn-default"><i class="fa fa-floppy-o"></i> Save Draft</button>

                            <span class="pull-right">
                                <button id="btn-publish" type="button" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Publish</button>
                            </span>
                            <center><span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;</center>
                        </div>
                    </div>
                </div>

                <div class="card-body my-card card-spacer">
                    <div class="col-md-12 no-padding">
                        <div class="form-group">
                            <label for="slug"><h5>Blog Categories *</h5></label>
                            <div class="form-group" style="height: 120px; overflow-y: scroll;">
                                <ul class="list-group category_list">
                                   
                                    <?php if($form_categories):?>
                                        <?php foreach($form_categories as $category):?>
                                            <li class="list-group-item" >
                                                <div class="form-check">
                                                    <label for="parent<?php echo $category->id;?>">
                                                        <input type="checkbox" value="<?php echo $category->id;?>" id="parent<?php echo $category->id;?>" class="form-check-input">
                                                        <?php echo $category->name;?> <i class="input-helper"></i>
                                                    </label>
                                                </div>
                                            </li>
                                        <?php endforeach;?>
                                    <?php else: ?>
                                        <p>No categories found.</p>
                                    <?php endif;?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body my-card card-spacer">
                    <div class="col-md-12 no-padding">
                        <div class="form-group">
                            <label for="slug"><h5>Featured Image *</h5></label>
                            <div class="form-group">
                                        <div id="image-styling" style="border: 2px dashed #ccc; padding: 10px;overflow: hidden;" class="col-sm-12">
                                            <center>
                                                <div id="preview">
                                                    <i class="fa fa-file-image-o" style="color: #ccc;margin-top: 80px;font-size: 40px;"></i><br/><br/>
                                                    <span style="color: #ccc;">No Image</span><br><br><br><br><br>
                                                </div>
                                               
                                            </center>
                                            <input type="hidden" id="image-url"/>
                                            <input type="hidden" id="thumb-url"/>
                                        </div>
                                        <br>
                                       <!--dynamic form upload-->
                                       
                                        <form id="imageform" method="post" enctype="multipart/form-data" action='<?php echo site_url('admin/gallery/upload_image');?>'>
                                            <div class="fileUpload btn btn-success">
                                                <span id="btn-upload-img"><i class="fa fa-file-image-o"></i>&nbsp; Upload Image</span>
                                                <input type="file" class="upload" id="photoimg" name="photoimg" accept='image/*'/>
                                            </div>
                                        </form>
                                        <br/>
                                        <p class="col-blue-grey" style="font-size: 11px;">
                                                Max file size: <b>5MB</b>.<br> 
                                                Recommended Dimension: <b>500 by 500 pixels</b><br>
                                                <b>JPG</b>, <b>PNG</b>, <b>GIF</b>, <b>BMP</b> or <b>GIF</b> allowed file types. 
                                            </p>
                                        <!--end dynamic form upload-->
                                    </div>
                        </div>
                    </div>
                </div>

            </div>


       
    </div><!--./row-->
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

<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/font_family.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/font_size.min.js');?>"></script>

<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/font_family.min.js');?>"></script>
<script type="text/javascript" src="<?php echo site_url('assets/plugins/froala-editor/js/plugins/font_size.min.js');?>"></script>

    <script>
        $(function() {
            $('#content').froalaEditor({
                //toolbars
                toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|', 'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-', 'insertLink', 'insertImage', 'insertVideo', 'insertFile', 'insertTable', 'undo', 'redo', 'clearFormatting', 'selectAll', 'html'],        
                heightMin: 770,
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
        var title, content, image, image_thumb, status;
        var category_selected = []; //selected category array

       

        /**
		 * Controls:: Save Posts
        */
        $('#btn-publish').click(function(e){
            status = 'publish';
       		e.preventDefault();
       		getVariables();
       	});

        $('#btn-draft').click(function(e){
            status = 'draft';
            e.preventDefault();
            getVariables();
        });


         /**
         * Method:: Get Form Data
        */
        function getVariables(){
            title = $('#title').val();
            content = $('#content').val();
            image = $('#image-url').val();
            image_thumb = $('#thumb-url').val();

            //get category selected
            $('ul.category_list').find("input:checkbox:checked").each(function () {
                category_selected.push($(this).val());
            });

            

            if(title.length == 0){
                $('#title').focus();
                $('#title').css('border', '1px solid red');
            } else if(content.length == 0){
                showMessage('Field Required', 'Please type in your post content.', 'warning');
                $('#content').focus();
            }else if(image.length == 0){
                showMessage('Image Required', 'Please upload a featured image.', 'warning');
            }else if($("ul.category_list input:checkbox:checked").length == 0){
                showMessage("Field Required", "Please select a post category.", "warning");
            }
            else{
                category_selected = JSON.stringify(category_selected); //format category_selected into json string
                savePost();
            }

        }



        /**
         * Method:: Save Blog Post
        */
        function savePost(){
            $(".processing-loader").show(); //show loader
            $("#btn-publish").prop('disabled', true);

            $.ajax({
                type: "POST",
                url: base_url +'admin/blogs/save_post',
                dataType: 'json',
                data: {
                    title: title, 
                    content: content, 
                    image: image, 
                    image_thumb: image_thumb, 
                    category_selected: category_selected,
                    status: status,
                    form_submit: true
                }, 
                success: function(response){
                    $(".processing-loader").hide(); //hide loader
                    
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
       	function showSuccessMessage(post_id) {
            swal({
                title: "Good Job!",
                text: "New post has been added!",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
                }, function () {
                    window.location.replace( base_url+"admin/blogs/edit/" +post_id);
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
            $("#preview").html('');
            $("#preview").html('<br><br><br><img src="'+ base_url +'assets/images/loader.gif" alt="Uploading...."/><br>Uploading...<br><br><br>');
            $("#imageform").ajaxForm({
                dataType: 'json',
                success: function(response) {
                    $("#image-styling").css('padding', '10');
                    $("#preview").html('<div class="center-cropped"><img src="'+base_url +response.image_url +'" class="img-responsive"></div>');
                    $("#btn-upload-img").html('<span class="glyphicon glyphicon-picture" aria-hidden="true"></span>&nbsp; Change Image');
                    $("#image-url").val(response.image_url);
                    $("#thumb-url").val(response.thumb_url);
                }

            }).submit();
                   
        });

       	
	});
</script>

