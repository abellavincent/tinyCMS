<div class="content-wrapper">
    <h3 class="page-heading mb-4">All Themes</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Available Themes</h5>
                    <div class="row">
                        <?php if(count($themes)): foreach($themes as $theme):?>
                            <div class="col-md-3" style="margin-bottom: 30px;">
                                <div class="center-cropped-thumb">
                                    <img src="<?php echo $theme->image;?>">
                                </div>
                                <div class="clearfix"></div>

                                <center style="margin-top: 15px;">
                                    <h5><?php echo $theme->name;?></h5>
                                    <p style="margin-top: 15px;">
                                        <?php if($theme->is_active == 1): ?>
                                            <button class="btn btn-primary">Active</button>&nbsp;&nbsp;
                                        <?php else: ?>
                                            <button class="btn btn-outline-primary activate" data-id="<?php echo $theme->id;?>">
                                                <span class="processing-loader-<?php echo $theme->id;?>" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                                                Activate
                                            </button>&nbsp;&nbsp;     
                                        <?php endif; ?>
                                        <a class="btn btn-outline-success preview" href="<?php echo $theme->preview_screenshot;?>" target="_blank">Preview</a>
                                    </p>
                                </center>
                            </div>
                        <?php endforeach; endif; ?>
                        
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
   
    /**
     * Save General Setting
    */
    $('.activate').click(function(e){
        e.preventDefault();
        var theme_id = $(this).data('id');
        activate_theme(theme_id);
    });


    function activate_theme(theme_id){
        $('.processing-loader-'+theme_id).show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/themes/activate_themes',
            dataType: 'json',
            data: {
                theme_id: theme_id, 
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-'+theme_id).hide();
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





    /*Sweet Alert Pop Up*/
    function showSuccessMessage() {
        swal({
            title: "Success!",
            text: "Theme has been successfully activate.",
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