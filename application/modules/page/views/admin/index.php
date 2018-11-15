<div class="content-wrapper">
    <h3 class="page-heading mb-4">Pages</h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="col-sm-3 col-sm-offset-3 pull-right no-padding">
                        
                        <a href="<?php echo site_url('admin/pages/add');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add New Page</a>
                    </div>
                    <!-- Search Form -->

                  	<h5 class="card-title mb-4">All Pages &nbsp;&nbsp;</h5>
                  	
                    <!--Post All, Publish, Draft, Trash > Set font bold-->
                    <div class="row clearfix" style="margin-bottom: 10px;">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a href="<?php echo site_url('admin/pages/status/publish');?>" class="status-tab-link"><?php echo set_navigation_active('publish', 'Published');?></a> <span class="text-muted">(<?php echo $pages_count[0]->totalPublish;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/pages/status/all');?>" class="status-tab-link"><?php echo set_navigation_active('all', 'All');?></a> <span class="text-muted">(<?php echo $pages_count[0]->All;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/pages/status/draft');?>" class="status-tab-link"><?php echo set_navigation_active('draft', 'Draft');?></a> <span class="text-muted">(<?php echo $pages_count[0]->totalDraft;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/pages/status/trash');?>" class="status-tab-link"><?php echo set_navigation_active('trash', 'Trash');?></a> <span class="text-muted">(<?php echo $pages_count[0]->totalTrash;?>)</span>
                        </div>                      
                    </div>

                    <br>


                    <div class="table-responsive">
                        <?php if(isset($is_search)):?>
                            <p class="text-muted pull-right"><?php echo $results_count;?> results</p>
                            <p><b>Search results found for:</b> &nbsp; <i><?php echo $keyword;?></i></p>
                        <?php endif;?>

                    	<table id="page-table" class="table table-striped center-aligned-table">
                      	<thead>
                        	<tr class="text-black">
                        		<th>ID</th>
                          		<th>Title</th>
                                <th>Status</th>
                          		<th>Author</th>
                          		<th>Date</th>
                          		<th width="130px"><span class="pull-right">Actions</span></th>
                        	</tr>
                      	</thead>
                      	<tbody>
                        	<?php if(isset($pages)): if($pages):?>
                                <?php foreach($pages as $page):?>
                                    <tr>
                                        <td><?php echo $page->id;?></td>
                                        <td><?php echo anchor(site_url('admin/pages/edit/'.$page->id), $page->title, 'class="post-title"');?></b></td>
                                        <td><?php echo set_status_color($page->status);?></td>
                                        <td><?php echo $page->username;?></td>
                                        <td><?php echo formatDate($page->date_created).' '. formatTime($page->date_created);?></td>
                                        <td class="pull-right">
                                            <a href="<?php echo site_url('page/'.$page->id.'/'.$page->slug);?>" target="_blank" class="btn btn-secondary btn-sm" title="Preview"><i class="fa fa-eye" aria-hidden="true"></i></a> &nbsp;
                                            <a href="<?php echo site_url('admin/pages/edit/'.$page->id);?>" class="btn btn-primary btn-sm" title="Edit Page"><i class="fa fa-edit"></i></a> &nbsp; 
                                            
                                            <?php if(isTrashUri() == TRUE):?>
                                                <a href="#" class="btn btn-danger btn-sm delete-permanently pull-right" data-id="<?php echo $page->id;?>" title="Delete Permanently"><i class="fa fa-trash-o"></i></a>
                                            <?php else:?>
                                                <a href="#" class="btn btn-danger btn-sm delete-page pull-right" data-id="<?php echo $page->id;?>" title="Move to Trash"><i class="fa fa-trash-o"></i></a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else:?>
                                <tr><td colspan="7"> <p><br>No pages found.</p></td></tr>
                            <?php endif;?>
                            <?php else:?>
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
        $('#page-table').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>

<!-- Le Javascripts -->
<script type="text/javascript">
    $(document).ready(function(){

        var base_url = '<?php echo site_url();?>';
        var page_id;
        


        /**
         * Controls:: Move to Trash
        */
        $('body').on('click', '.delete-page', function() {
            page_id = $(this).data('id');

            showConfirmMessage(page_id);
        });



        /**
         * Controls:: Delete Blog page
        */
        $('body').on('click', '.delete-permanently', function() {
            page_id = $(this).data('id');
            showConfirmDeletePermanently(page_id);
        });



        /**
         * Method:: Move page to trash 
        */
        function deletePage(page_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/pages/move_to_trash',
                dataType: 'json',
                data: {
                    page_id: page_id,
                    form_submit: true,
                }, 

                success: function(response){

                    if(response.success == true){
                        showDeleteSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }



        /**
         * Method:: Move page to trash 
        */
        function deletePagePermanently(page_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/pages/delete_page',
                dataType: 'json',
                data: {
                    page_id: page_id,
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
        function showConfirmMessage(page_id) {
            swal({
                title: "Are you sure?",
                text: "This page will be move to trash.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Move it!",
                closeOnConfirm: false
            }, function () {
                deletePage(page_id);
            });
        }

        function showDeleteSuccess() {
            swal({
                title: "Success!",
                text: "Page has been successfully moved to trash.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }


        //delete permanently
        function showConfirmDeletePermanently(page_id) {
            swal({
                title: "Are you sure?",
                text: "This page will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                deletePagePermanently(page_id);
            });
        }

        function showDeletePermanentlySuccess() {
            swal({
                title: "Success!",
                text: "Page has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.href = base_url +'admin/pages/status/trash';
            });
        }

    });
</script>