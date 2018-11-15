<div class="content-wrapper">
    <h3 class="page-heading mb-4">Blog Categories</h3>

    <div class="row align-items-start">
	    
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                <div class="card-body my-card ">
                    <h5 class="card-title mb-4">Add New Category</h5>
                    
                        <form id="add-user-form">
                            <div class="form-group">
                                <label for="name"><b>Name *</b> </label>
                                <input type="text" class="form-control p-input" value="" name="name" id="name" placeholder="Enter category name">
                            </div>
                            <div class="form-group">
                                <label for="slug"><b>Slug *</b></label>
                                <span class="pull-right err-slug"></span>
                                <input type="text" class="form-control p-input" name="slug" id="slug" placeholder="URL-friendly version of the name">
                            </div>
                            <div class="form-group">
                                <label for="slug"><b>Parent </b></label>
                                <select class="form-control" id="parent-id">
                                  <option value="0">-- None --</option>
                                  <?php if($form_categories): foreach($form_categories as $fcategory):?>
                                    <option value="<?php echo $fcategory->id;?>"><?php echo $fcategory->name;?></option>
                                  <?php endforeach; endif;?>
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="slug"><b>Description </b></label>
                                <span class="pull-right err-description"></span>
                                <textarea class="form-control p-input" name="description" id="description" rows="5" placeholder="Please type the category description"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" id="btn-submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Save New Category</button>&nbsp;&nbsp;
                                <span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;</center>
                            </div>
                        </form>
                </div>
            </div>
            


            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card-body my-card ">
                    <h5 class="card-title">Blog Categories</h5>
                      <table class="table">
                            <thead>
                                <tr class="text-black">
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th style="width: 130px;"><span class="pull-right">Actions</span></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php if($categories): foreach($categories as $category):?>
                                  <tr>
                                        <td>
                                            <a href="<?php echo site_url('admin/blogs/categories/edit/'.$category->id);?>" title="Edit Category">
                                                <b style="color: #5a5a5a;"><?php echo $category->name;?></b>
                                            </a>
                                        </td>
                                        <td><?php echo $category->slug;?></td>
                                        <td>
                                          <a href="<?php echo site_url('category/post/'.$category->slug);?>" target="_blank" class="btn btn-secondary btn-sm" title="Preview"><i class="fa fa-eye" aria-hidden="true"></i></a> &nbsp; 
                                          <a href="<?php echo site_url('admin/blogs/categories/edit/'.$category->id);?>" class="btn btn-primary btn-sm" title="Edit Category"><i class="fa fa-edit"></i></a> &nbsp; 
                                          <a href="#" class="btn btn-danger btn-sm delete-category" data-id="<?php echo $category->id;?>" title="Delete"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                  </tr>
                                <?php endforeach; endif;?>
                            </tbody>
                      </table>
                </div>
            </div>
    
    </div><!--./row-->
</div><!--./content-wrapper-->




<!-- Le Javascripts -->
<script type="text/javascript">
    $(document).ready(function(){

        var base_url = '<?php echo site_url();?>';
        var name, slug, parent_id, description;
       	
       	/**
		 * Controls:: Save Category
       	*/
       	$('#btn-submit').click(function(e){
       		e.preventDefault();
       		name = $('#name').val();
       		slug = $('#slug').val();
       		parent_id = $('#parent-id').val();
       		description = $('#description').val();

       		if(name.length == 0){
       			$('#name').focus();
       			$('#name').css('border', '1px solid red');
       		}else if(slug.length == 0){
       			$('#slug').focus();
       			$('#slug').css('border', '1px solid red');
       		}else{
       			saveCategory();
       		}
       		
       	});



       	/**
	 	 * Controls:: Delete Category
       	*/
       	$('.delete-category').click(function(){
       		var id = $(this).data('id');
       		showConfirmMessage(id); //confirm to delete
       	});





       	/**
		 * Method:: Save Category
       	*/
       	function saveCategory(){
          $('.processing-loader').show();
       		$.ajax({
                type: "POST",
                url: base_url +'admin/blogs/save_category',
                dataType: 'json',
                data: {
                    name: name, 
                    slug: slug,
                    parent_id: parent_id,
                    description: description,
                    form_submit: true,
                }, 

                success: function(response){
                    if(response.success == true){
                      $('.processing-loader').hide();
                    	showSuccessMessage();
                    }else{
                    	alert('Something went wrong. Please try again!');
                    }
                    

                }
            });
       	}


       	/**
		 * Method:: Delete Category
       	*/
       	function deleteCategory(category_id){
	        $.ajax({
	            type: "POST",
	            url: base_url +'admin/blogs/delete_category',
	            dataType: 'json',
	            data: {
	                category_id: category_id,
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
         * Sweet Alert - Pop Up 
         *
        */
        function showConfirmMessage(id) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this category.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            }, function () {
               //delete after confirmation
                deleteCategory(id);
            });
        }

        function showDeleteSuccess() {
            swal({
                title: "Deleted!",
                text: "Category has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }

        function showSuccessMessage() {
            swal({
                title: "Success!",
                text: "New blog category has been added.",
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