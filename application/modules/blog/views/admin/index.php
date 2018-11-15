

<div class="content-wrapper">
    <h3 class="page-heading mb-4">Blogs</h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <!-- Search Form -->
                    <div class="col-sm-3 col-sm-offset-3 pull-right no-padding">
                        <!--<form id="form-search" action="<?php echo site_url('admin/blogs/search');?>" method="post">  
                            <input type="hidden" name="form_submit" value="TRUE">
                            <div class="input-group">
                                <input class="form-control" id="search-keyword" name="search-keyword" value="<?php echo (isset($keyword) ? $keyword:'');?>" placeholder="Search ">
                                <div class="input-group-addon" id="btn-submit-search" style="cursor:pointer;"><i class="fa fa-search"></i></div>
                            </div>
                        </form>-->
                        <a href="<?php echo site_url('admin/blogs/add');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> &nbsp;Add New Post</a>
                    </div>
                    <!-- Search Form -->

                  	<h5 class="card-title mb-4">All Posts &nbsp;&nbsp;</h5>
                    
                    <!--Post All, Publish, Draft, Trash > Set font bold-->
                    <div class="row clearfix" style="margin-bottom: 10px;">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a href="<?php echo site_url('admin/blogs/status/publish');?>" class="status-tab-link"><?php echo set_navigation_active('publish', 'Published');?></a> <span class="text-muted">(<?php echo $posts_count[0]->totalPublish;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/blogs/status/all');?>" class="status-tab-link"><?php echo set_navigation_active('all', 'All');?></a> <span class="text-muted">(<?php echo $posts_count[0]->All;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/blogs/status/draft');?>" class="status-tab-link"><?php echo set_navigation_active('draft', 'Draft');?></a> <span class="text-muted">(<?php echo $posts_count[0]->totalDraft;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/blogs/status/trash');?>" class="status-tab-link"><?php echo set_navigation_active('trash', 'Trash');?></a> <span class="text-muted">(<?php echo $posts_count[0]->totalTrash;?>)</span>
                        </div>                      
                    </div>

                    <br>
                    <div class="table-responsive">
                        <?php if(isset($is_search)):?>
                            <p class="text-muted pull-right"><?php echo $results_count;?> results</p>
                            <p><b>Search results found for:</b> &nbsp; <i><?php echo $keyword;?></i></p>
                        <?php endif;?>

                    	<table id="blog-table"  class="table table-striped center-aligned-table">
                      	<thead>
                        	<tr class="text-black table-heads">
                        		<th>ID</th>
                          		<th width="350px">Title</th>
                                <th>Status</th>
                          		<th>Author</th>
                          		<th>Category</th>
                          		<th>Date</th>
                          		<th width="130px"><span class="pull-right">Actions</span></th>
                        	</tr>
                      	</thead>
                      	<tbody>

                            
                        	<?php if(isset($posts)): if($posts):?>
                                <?php foreach($posts as $post):?>
                                    <tr>
                                        <td><?php echo $post->id;?></td></td>
                                        <td><?php echo anchor(site_url('admin/blogs/edit/'.$post->id), $post->title, 'class="post-title"');?></b></td>
                                        <td><?php echo set_status_color($post->status);?></td>
                                        <td><?php echo $post->username;?></td>
                                        <td><?php echo $post->catname;?></td>
                                        <td><?php echo formatDate($post->date_created).' '. formatTime($post->date_created);?></td>
                                        <td class="pull-right">
                                            <a href="<?php echo site_url('post/'.$post->id.'/'.$post->slug);?>" target="_blank" class="btn btn-secondary btn-sm" title="Preview"><i class="fa fa-eye" aria-hidden="true"></i></a> &nbsp; 
                                            <a href="<?php echo site_url('admin/blogs/edit/'.$post->id);?>" class="btn btn-primary btn-sm" title="Edit Post"><i class="fa fa-edit"></i></a> &nbsp; 
                                            
                                            <?php if(isTrashUri() == TRUE):?>
                                                <a href="#" class="btn btn-danger btn-sm delete-permanently" data-id="<?php echo $post->id;?>" title="Delete Permanently"><i class="fa fa-trash-o"></i></a>
                                            <?php else:?>
                                                <a href="#" class="btn btn-danger btn-sm delete-post trash-post" data-id="<?php echo $post->id;?>" title="Move to Trash"><i class="fa fa-trash-o"></i></a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else:?>
                                <tr><td colspan="7"> <p><br>No posts found.</p></td></tr>
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
        $('#blog-table').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>


<!-- Le Javascripts -->
<script type="text/javascript">
    
    $(document).ready(function(){


        var base_url = '<?php echo site_url();?>';
        var post_id;
        
        /**
         * Controls:: Delete Blog Post
        */
        $('body').on('click', '.delete-post', function() {
            post_id = $(this).data('id');
            showConfirmMessage(post_id);
        });




        /**
         * Controls:: Delete Blog Post Permanently
        */
        $('body').on('click', '.delete-permanently', function() {
            post_id = $(this).data('id');
            showConfirmDeletePermanently(post_id);
        });




        /**
         * Method:: Delete Post / Move to Trash
        */
        function deletePost(post_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/blogs/move_to_trash',
                dataType: 'json',
                data: {
                    post_id: post_id,
                    form_submit: true,
                }, 

                success: function(response){

                    if(response.success == true){
                        showDeleteSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
           
                }
            });
        }


        /**
         * Method:: Delete Post Permanently from database
        */
        function deletePostPermanently(post_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/blogs/delete_post',
                dataType: 'json',
                data: {
                    post_id: post_id,
                    form_submit: true,
                }, 

                success: function(response){

                    if(response.success == true){
                        showDeletePermanentlySuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
           
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
        function showConfirmMessage(post_id) {
            swal({
                title: "Are you sure?",
                text: "This blog post will be move to trash.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Move it!",
                closeOnConfirm: false
            }, function () {
                deletePost(post_id);
            });
        }

        function showDeleteSuccess() {
            swal({
                title: "Success!",
                text: "Post has been successfully moved to trash.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }


        function showConfirmDeletePermanently(post_id) {
            swal({
                title: "Are you sure?",
                text: "This blog post will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            }, function () {
                deletePostPermanently(post_id);
            });
        }

        function showDeletePermanentlySuccess() {
            swal({
                title: "Deleted!",
                text: "Post has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.href = base_url +'admin/blogs/status/trash'; //reload page after submitted
            });
        }


    });
</script>