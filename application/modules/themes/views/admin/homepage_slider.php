<div class="content-wrapper">
    <h3 class="slider-heading mb-4">Slider</h3>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="col-sm-3 col-sm-offset-3 pull-right no-padding">
                        
                        <a href="<?php echo site_url('admin/themes/slider/add');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add New Slider</a>
                    </div>
                    <!-- Search Form -->

                    <h5 class="card-title mb-4">All Slider &nbsp;&nbsp;</h5>
                    
                    <br>


                    <div class="table-responsive">
                       
                        <table id="slider-table" class="table table-striped center-aligned-table">
                        <thead>
                            <tr class="text-black">
                                <th>Order</th>
                                <th>Title</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th width="130px"><span class="pull-right">Actions</span></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($sliders)): if($sliders):?>
                                <?php foreach($sliders as $slider):?>
                                    <tr>
                                        <td><?php echo $slider->order_position;?></td>
                                        <td><?php echo anchor(site_url('admin/themes/slider/edit/'.$slider->id), $slider->title, 'class="post-title"');?></b></td>
                                        <td><?php echo $slider->added_by;?></td>
                                        <td><?php echo formatDate($slider->date_added).' '. formatTime($slider->date_added);?></td>
                                        <td class="pull-right">
                                            <a href="<?php echo site_url('admin/themes/slider/edit/'.$slider->id);?>" class="btn btn-primary btn-sm" title="Edit Page"><i class="fa fa-edit"></i></a> &nbsp; 
                                            <a href="#" class="btn btn-danger btn-sm delete-permanently pull-right" data-id="<?php echo $slider->id;?>" title="Delete Permanently"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else:?>
                                <tr><td colspan="7"> <p><br>No sliders found.</p></td></tr>
                            <?php endif;?>
                            <?php else:?>
                            <?php endif;?>
                        </tbody>
                    </table>

                  </div>
                  
                </div>
            </div>
        </div>
    </div><!--./row-->
</div><!--./content-wrapper-->



<!-- Datatables -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#slider-table').DataTable({
            "order": [[ 0, "asc" ]]
        });
    });
</script>

<!-- Le Javascripts -->
<script type="text/javascript">
    $(document).ready(function(){

        var base_url = '<?php echo site_url();?>';
        var slider_id;
        

        /**
         * Controls:: Delete Blog slider
        */
        $('.delete-permanently').click(function(){
            slider_id = $(this).data('id');
            showConfirmDeletePermanently(slider_id);
        });




        /**
         * Method:: Move slider to trash 
        */
        function deletesliderPermanently(slider_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/themes/slider/delete',
                dataType: 'json',
                data: {
                    slider_id: slider_id,
                    form_submit: true,
                }, 

                success: function(response){

                    if(response.success == true){
                        showDeletePermanentlySuccess();
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
        

        //delete permanently
        function showConfirmDeletePermanently(slider_id) {
            swal({
                title: "Are you sure?",
                text: "This slider will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                deletesliderPermanently(slider_id);
            });
        }

        function showDeletePermanentlySuccess() {
            swal({
                title: "Success!",
                text: "slider has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.href = base_url +'admin/themes/slider';
            });
        }

    });
</script>