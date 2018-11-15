<div class="content-wrapper">
    <h3 class="page-heading mb-4">Edit Category </h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                  	<h5 class="card-title mb-4">Category Information</h5>
                  	<form id="add-user-form">
                        <div class="form-group">
                            <label for="name"><b>Name *</b> </label>
                            <input type="text" class="form-control p-input" value="<?php echo $category->name;?>" name="name" id="name" placeholder="Enter category name">
                        </div>
                        <div class="form-group">
                            <label for="slug"><b>Slug *</b></label>
                            <input type="text" class="form-control p-input" value="<?php echo $category->slug;?>" name="slug" id="slug" placeholder="URL-friendly version of the name">
                        </div>
                       <div class="form-group">
                            <label for="slug"><b>Parent</b></label>
                            <select class="form-control" id="parent-id">
						      	<option value="0">-- None --</option>
						      	<?php if($form_categories): foreach($form_categories as $fcategory):?>
						      		<option value="<?php echo $fcategory->id;?>" <?php echo ($fcategory->id == $category->parent_id ? 'selected':'');?>><?php echo $fcategory->name;?></option>
						      	<?php endforeach; endif;?>
						    </select>
                        </div>

                        <div class="form-group">
                            <label for="description"><b>Description *</b></label>
                            <textarea class="form-control p-input" name="description" id="description" rows="5" placeholder="Please type the category description"><?php echo $category->description;?></textarea>
                        </div>

                        
                        <div class="form-group">
                            <input type="hidden" value="<?php echo $category->id;?>" id="category-id"/>
                            <button type="submit" id="btn-submit" class="btn btn-primary"><i class="fa fa-check-square-o"></i> Update Category</button>&nbsp;&nbsp;
                            <span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;</center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div><!--./row-->
</div><!--./content-wrapper-->



<!-- Le Javascripts -->
<script type="text/javascript">
	$(document).ready(function(){
	
		var base_url = '<?php echo site_url();?>';
        var name, slug, parent_id, description, category_id;

        /**
		 * Controls:: Update Category
        */
        $('#btn-submit').click(function(e){
       		e.preventDefault();
       		name = $('#name').val();
       		slug = $('#slug').val();
       		parent_id = $('#parent-id').val();
       		description = $('#description').val();
       		category_id = $('#category-id').val();

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
		 * Method:: Update Category
       	*/
       	function saveCategory(){
          $('.processing-loader').show();
       		$.ajax({
                type: "POST",
                url: base_url +'admin/blogs/save_category',
                dataType: 'json',
                data: {
                	category_id: category_id,
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


       	function showSuccessMessage() {
            swal({
                title: "Success!",
                text: "Blog category information has been updated.",
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