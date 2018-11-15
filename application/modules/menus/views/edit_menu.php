<div class="content-wrapper">
    
    <!-- Admin Modules -->
    <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-right: 5px;">
            <i class="fa fa-cog" aria-hidden="true"></i>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="<?php echo site_url('admin/menus/edit/4');?>">Admin Menu</a>
            <a class="dropdown-item" href="<?php echo site_url('admin/menus/edit/5');?>">Editor Menu</a>
            <a class="dropdown-item" href="<?php echo site_url('admin/menus/edit/6');?>">User Menu</a>
        </div>
    </div>

    <h3 class="page-heading mb-4">Menu Manager</h3>

    <div class="row">
        <div class="col-md-12">
        
           <!-- nav tabs menu type -->
            <ul id="nav-menu-type" class="nav nav-tabs">

                <?php if($menu_types): foreach($menu_types as $menu_type):?>
                    
                    <li class="nav-item">
                        <a class="nav-link <?php echo set_menu_active($menu_type->id);?>"  href="<?php echo site_url('admin/menus/edit/'.$menu_type->id);?>"><?php echo $menu_type->name;?></a>
                    </li>
                <?php endforeach; endif;?>
                <li class="nav-item" id="add-menu-type">
                    <a class="nav-link" href="#"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp;New</a>
                </li>
              
            </ul>

        </div>
    </div>


    <div class="row align-items-start menu-wrap">
            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"  style="margin-top: 20px;">
    
                <!-- accordion -->
                <div class="card-body my-card" style="padding: 0;">
                    <div id="accordion" role="tablist" aria-multiselectable="true">
                        
                        





                        <div class="card">
                            <div class="card-header mb-2 border-bottom-0" role="tab" id="headingTwo">
                                <p class="mb-0" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <b>Post</b>
                                </p>
                            </div>

                            <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo">
                                <div class="card-body no-padding">
                                    
                                    <ul class="nav nav-tabs" id="Demo-tab1" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#posts" role="tab">Posts</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#categories" role="tab">Categories</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="posts" role="tabpanel">
                                            <div class="form-group" style="height: 200px; overflow-y: scroll;">
                                                <ul class="posts list-group category_list">
                                                    
                                                    <?php if($posts): foreach($posts as $post):?>
                                                        <li class="list-group-item" title="<?php echo $post->title;?>">
                                                            <div class="form-check">
                                                                <label for="post<?php echo $post->id;?>">
                                                                    <input value="<?php echo $post->id;?>" id="post<?php echo $post->id;?>" class="form-check-input" type="checkbox">
                                                                    <?php echo truncateStringWords($post->title, 35);?>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endforeach;?>
                                                    <?php else:?>  
                                                        <center><p>No posts found.</p></center>  
                                                    <?php endif;?>                         
                                                </ul>

                                            </div>

                                            <div class="form-group pull-right">
                                                <span class="processing-loader-save-item-post" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;
                                                <button type="submit" id="btn-item-from-post" class="btn btn-primary">Add to Menu <i class="fa fa-arrow-right" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                            </div>
                                            <br><br>
                                        </div>

                                        <div class="tab-pane" id="categories" role="tabpanel">
                                            <div class="form-group" style="height: 200px; overflow-y: scroll;">
                                                <ul class="categories list-group category_list">
                                                    <?php if($categories): foreach($categories as $category):?>
                                                        <li class="list-group-item" title="<?php echo $category->name;?>">
                                                            <div class="form-check">
                                                                <label for="category<?php echo $category->id;?>">
                                                                    <input value="<?php echo $category->id;?>" id="category<?php echo $category->id;?>" class="form-check-input" type="checkbox">
                                                                    <?php echo truncateStringWords($category->name, 35);?>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endforeach;?>
                                                    <?php else:?>  
                                                        <center><p>No categories found.</p></center>  
                                                    <?php endif;?>     
                                                </ul>
                                            </div>

                                            <div class="form-group pull-right">
                                                <span class="processing-loader-save-item-category" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;
                                                <button type="submit" id="btn-item-from-category" class="btn btn-primary">Add to Menu <i class="fa fa-arrow-right" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                            </div>
                                            <br><br>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>








                        <div class="card">
                            <div class="card-header mb-2 border-bottom-0" role="tab" id="headingThree">
                                <p class="mb-0" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <b>Page</b>
                                </p>
                                
                            </div>
                            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree">
                                <div class="card-body no-padding">
                                    
                                    <ul class="nav nav-tabs" id="Demo-tab1" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#pages" role="tab">Pages</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="pages" role="tabpanel">
                                            <div class="form-group" style="height: 200px; overflow-y: scroll;">
                                                <ul class="pages list-group category_list">
                                                    <?php if($pages): foreach($pages as $page):?>
                                                        <li class="list-group-item" title="<?php echo $page->title;?>">
                                                            <div class="form-check">
                                                                <label for="page<?php echo $page->id;?>">
                                                                    <input value="<?php echo $page->id;?>" id="page<?php echo $page->id;?>" class="form-check-input" type="checkbox">
                                                                    <?php echo truncateStringWords($page->title, 35);?>
                                                                </label>
                                                            </div>
                                                        </li>
                                                    <?php endforeach;?>
                                                    <?php else:?>  
                                                        <center><p>No pages found.</p></center>  
                                                    <?php endif;?>     
                                                </ul>
                                            </div>

                                            <div class="form-group pull-right">
                                                <span class="processing-loader-save-item-page" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;
                                                <button type="submit" id="btn-item-from-page" class="btn btn-primary">Add to Menu <i class="fa fa-arrow-right" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                            </div>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>







                        <div class="card">
                            <div class="card-header mb-2 border-bottom-0" role="tab" id="headingFour">
                                <p class="mb-0" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseThree">
                                    <b>Module</b>
                                </p>
                                
                            </div>
                            <div id="collapseFour" class="collapse" role="tabpanel" aria-labelledby="headingFour">
                                <div class="card-body no-padding">
                                    
                                    <ul class="nav nav-tabs" id="Demo-tab1" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#module" role="tab">Modules</a>
                                        </li>
                                    </ul>

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="module" role="tabpanel">
                                            <div class="form-group" style="height: 200px; overflow-y: scroll;">
                                                
                                                <?php echo format_modules($modules);?>
                                                
                                            </div>

                                            <div class="form-group pull-right">
                                                <span class="processing-loader-save-item-module" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;
                                                <button type="submit" id="btn-item-from-module" class="btn btn-primary">Add to Menu <i class="fa fa-arrow-right" aria-hidden="true"></i></button>&nbsp;&nbsp;
                                            </div>
                                            <br><br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>








                        <div class="card">
                            <div class="card-header mb-2 border-bottom-0" role="tab" id="headingOne">
                                <p class="mb-0" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    <b>Custom</b>
                                </p>
                            </div>

                            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                <div class="card">
                                    <form id="add-item-form">
                                        <div class="form-group">
                                            <label for="title"><b>Title *</b> </label>
                                            <input type="text" class="form-control p-input" value="" name="title" id="title" placeholder="Enter link name">
                                        </div>
                                        <div class="form-group">
                                            <label for="url"><b>Url *</b></label>
                                            <input type="text" class="form-control p-input" name="url" id="url" placeholder="Enter url">
                                        </div>

                                        <!-- ADVANCE *******************************************************************************-->
                                        <div id="menu-toggle-container" class="collapse">
                                            <div class="form-group">
                                                <label for="css-class"><b>Css Class </b></label>
                                                <input type="text" class="form-control p-input" name="css-class" id="css-class" placeholder="(optional)">
                                            </div>
                                            <div class="form-group">
                                                <label for="icon"><b>Icon </b></label>
                                                <input type="text" class="form-control p-input" name="icon" id="icon" placeholder="(optional)">
                                            </div>
                                            <div class="form-group">
                                                <label for="keyword"><b>Keyword </b></label>
                                                <input type="text" class="form-control p-input" name="keyword" id="keyword" placeholder="(optional)">
                                            </div>
                                        </div>
                                        <div style="margin-bottom: 20px;">
                                            <a href="#" style="text-decoration: none;" data-toggle="collapse" data-target="#menu-toggle-container">
                                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                                                More Options...
                                            </a>
                                        </div>

                                        <div class="form-group pull-right">
                                            <input type="hidden" id="menu-type" value="<?php echo $menu_type_data_first->id;?>">
                                            <span class="processing-loader-save-item" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;
                                            <button type="submit" id="btn-add-menu-item" class="btn btn-primary">Add to Menu <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                        </div>
                                    </form>
                                </div> 
                            </div>
                        </div>

                        <br><br>
                    </div>
                </div>
                <!-- end accordion -->
            </div>
            


            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12" style="border-left: 1px solid #f5f5f5;margin-top: 20px;">
                <div class="card-body my-card ">

                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title mb-4">
                                <input id="menu-name" type="text" value="<?php echo $menu_type_data_first->name;?> " style="border: 0;background: transparent;" disabled>
                                <br>
                                <small style="">
                                    <span style="color: #999;font-size: 12px;">( ID: <strong id="menu-type-id"><?php echo $menu_type_data_first->id;?></strong> )
                                    <a id="edit-menu-name" href="javascript:void(0);">Edit</a> &nbsp;|&nbsp; <a id="delete-menu-name" href="javascript:void(0)">Delete</a></span>
                                </small>
                            </h5>
                        </div>
                        
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 pull-right" style="font-size: 12px;border-left: 1px solid #ccc;">
                            <p>Drag the menu list to re-order, and click <br/><strong>Save Menu</strong> to save the position.</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                                <span class="pull-right">
                                    <span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span> &nbsp;&nbsp;
                                    <button type="button" class="btn btn-primary btn-save-menu-items"><i class="fa fa-check-square-o"></i> Save Menu</button>
                                </span>
                              
                                <div class="clearfix"></div>

                                <!--menu draggable content-->
                                <div class="dd nestable-with-handle" id='nestableMenu'>
                                    <ol class="dd-list">

                                        <?php if($menu_items):?>
                                            <?php foreach($menu_items as $item):?>
                                                <li class="dd-item dd3-item" data-id="<?php echo $item->id;?>">
                                                    <div class="dd-handle dd3-handle"></div>
                                                    <div class="dd3-content">
                                                        <?php echo $item->title;?> <!--<span class="url-title"><?php echo $item->url;?></span>-->
                                                        <span class='pull-right'>
                                                            <span class="loader-<?php echo $item->id;?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i> &nbsp;&nbsp;</span>
                                                            <a href='javascript:void(0);' data-id='<?php echo $item->id;?>' class='edit-menu-item'><i class="fa fa-edit" aria-hidden="true" style='color: #2196F3;cursor: pointer;'></i></a> &nbsp;&nbsp;
                                                            <a href='javascript:void(0);' data-id='<?php echo $item->id;?>' class='delete-menu-item'><i class="fa fa-close" aria-hidden="true" style='color: red;cursor: pointer;'></i></a>
                                                        </span>
                                                    </div>
                                                    <?php
                                                        get_menu_nested($item->id); // get nested
                                                    ?>
                                                </li>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            <p>No menu items found.</p>
                                        <?php endif;?>

                                    </ol>
                                </div>
                                <!--menu draggable content-->

                              

                                <textarea id='nestableMenu-output' style='display:none;'></textarea>
                                <br>
                                <hr>
                                <span class="pull-right">
                                    <span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span> &nbsp;&nbsp;
                                    <button type="button" class="btn btn-primary btn-save-menu-items"><i class="fa fa-check-square-o"></i> Save Menu</button>
                                </span>
                                <p>After making updates to your menu items, <br>click the <b>Save Menu</b> button to save your changes.</p>
                        </div>
                    </div>
                                      
                </div>
            </div>

    
    </div><!--./row-->
</div><!--./content-wrapper-->


<!-- Modal:: Add Menu Type -->
<div class="modal fade" id="modal-add-menu-type" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                 <div class="col-md-12 no-padding">
                    <div class="form-group">
                        <label for="menu-type-name"><b>Menu Name *</b></label>
                        <span class="pull-right err-menu-name"></span>
                        <input type="text" class="form-control p-input" value="" name="menu-type-name" id="menu-type-name" placeholder="Enter menu name">
                    </div>
                </div>
            </div>
        
            <div class="modal-footer">
                <span class="processing-loader-modal" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span> &nbsp;&nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-save-menu" class="btn btn-primary">Save Menu</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal:: Edit Menu Item -->
<div class="modal fade" id="modal-edit-menu-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Menu Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                 <div class="col-md-12 no-padding">
                    <div class="form-group">
                        <label for="edit-menu-title"><b>Title *</b></label>
                        <input type="text" class="form-control p-input" value="" name="edit-menu-title" id="edit-menu-title" placeholder="Enter menu title">
                    </div>
                    <div class="form-group">
                        <label for="edit-menu-url"><b>Url *</b></label>
                        <input type="text" class="form-control p-input" value="" name="edit-menu-url" id="edit-menu-url" placeholder="Enter menu url or link">
                    </div>
                    <div class="form-group">
                        <label for="edit-menu-target"><b>Target</b></label>
                        <select class="form-control" id="edit-menu-target">
                            <option value="parent">Parent</option>
                            <option value="blank">Blank</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-menu-css"><b>CSS Class</b></label>
                        <input type="text" class="form-control p-input" value="" name="edit-menu-css" id="edit-menu-css" placeholder="(optional)">
                    </div>
                    <div class="form-group">
                        <label for="edit-menu-icon"><b>Icon</b></label>
                        <input type="text" class="form-control p-input" value="" name="edit-menu-icon" id="edit-menu-icon" placeholder="(optional)">
                    </div>
                    <div class="form-group">
                        <label for="edit-menu-keyword"><b>Keyword</b></label>
                        <input type="text" class="form-control p-input" value="" name="edit-menu-keyword" id="edit-menu-keyword" placeholder="(optional)">
                    </div>
                   
                </div>
            </div>
        
            <div class="modal-footer">
                <input type="hidden" value="" id="edit-menu-item-id" />
                <span class="processing-loader-modal" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span> &nbsp;&nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-edit-menu-item" class="btn btn-primary">Save Menu</button>
            </div>
        </div>
    </div>
</div>






<!-- Load Sortable Plugins-->
<link rel="stylesheet" href="<?php echo site_url('assets/plugins/menu-manager/css/sortable.css');?>" />
<script src="<?php echo site_url('assets/plugins/menu-manager/js/jquery.nestable.js');?>"></script>
<script>
    $(document).ready(function(){
        
        /* The output is meant to update the nestableMenu-output textarea
         * 
        */
       
        var updateOutput = function(e){
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        
        // activate Nestable for list menu
        $('#nestableMenu').nestable({
            group: 1
        })
        .on('change', updateOutput);
        
        
        
        // output initial serialised data
        updateOutput($('#nestableMenu').data('output', $('#nestableMenu-output')));

        $('#nestable-menu').on('click', function(e){
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });

    });
</script>


<!-- Le Javascripts -->
<script type="text/javascript">
    $(document).ready(function(){

        var base_url = '<?php echo site_url();?>';



        /**
         * Controls:: Add Menu Type *********************************
        */
        $('#add-menu-type').click(function(){
            $('#modal-add-menu-type').modal('show');
        });

        $('#btn-save-menu').click(function(){
            var menu_name = $('#menu-type-name').val();
            if(menu_name.length == 0){
                $('#menu-type-name').focus();
                $('#menu-type-name').css('border', '1px solid red');
            }else{
                save_menu_type(menu_name);
              
            }
           
        });




        /**
         * Method:: Add Menu Type
        */
       function save_menu_type(menu_name){
            $('.processing-loader-modal').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/save_menu_type',
                dataType: 'json',
                data: {
                    menu_name: menu_name, 
                    form_submit: true
                }, 
                success: function(response){
                    $('.processing-loader-modal').hide();
                    if(response.success == true){
                        $('#modal-add-menu-type').modal('hide');
                        showSuccessMessageMenuType();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                  
                 
                }
            });
           
        }

    


        /**
         * Controls:: Add Menu Item
        */
        $('#btn-add-menu-item').click(function(e){
            e.preventDefault();

            var title, url, css, icon, keyword, menu_type; 
            
            title = $('#title').val();
            url = $('#url').val();
            css = $('#css-class').val();
            icon = $('#icon').val();
            keyword = $('#keyword').val();
            menu_type = $('#menu-type').val();

            if(title.length == 0){
                $('#title').focus();
                $('#title').css('border', '1px solid red');
            }else if(url.length == 0){
                $('#url').focus();
                $('#url').css('border', '1px solid red');
            }else{
                addMenuItem(title, url, css, icon, keyword, menu_type);                
            }
            
        });



        /**
         * Method:: Add Menu Item
        */
        function addMenuItem(title, url, css, icon, keyword, menu_type){
            $('.processing-loader-save-item').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/save_menu_item',
                dataType: 'json',
                data: {
                    title: title,
                    url: url,
                    css: css,
                    icon: icon,
                    keyword: keyword,
                    menu_type: menu_type,
                    form_submit: true
                }, 
                success: function(response){
                    $('.processing-loader-save-item').hide();
                    if(response.success == true){
                        showSuccessMessageSaveItem();
                    }else{
                        alert("Something went wrong. Please try again!");
                        location.reload();
                    }
                }
            });
        }





        /**
         * Update Menu Items Order and Position
        */
        $(".btn-save-menu-items").click(function(){
            var menu_items = $("#nestableMenu-output").val();
            var menu_type_id = $("#menu-type-id").html(); //use to get module access by user

            saveMenuGroupItems(menu_items, menu_type_id);
        });


        function saveMenuGroupItems(menu_items, menu_type_id){
            $(".processing-loader").show(); //show loader
            $(".btn-save-menu-items").prop('disabled', true);
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/save_menugroup_items',
                 dataType: 'json',
                data: {
                    jsonstring: menu_items, 
                    menu_type_id: menu_type_id,
                    form_submit: true,
                }, 
                success: function(response){
                    $(".processing-loader").hide(); //show loader
                    if(response.success == true){
                        showSuccessMessageSaveMenuGroupItems();
                        console.log(response.id);
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                }
            });
        }
        /**
         * #END# Update Menu Items
        */


        /**
         * Controls:: Edit Menu Item
        */
        $('.edit-menu-item').click(function(){
            var item_id = $(this).data('id');
            $('.loader-' +item_id).show();
            getMenuItemsInfo(item_id);
            $('#modal-edit-menu-item').modal('show');
        });


        /**
         * Method:: GetMenuItem Info
        */
        function getMenuItemsInfo(item_id){
           
            var data = $.parseJSON(
            $.ajax({
                type: "POST", 
                url: base_url +'admin/menus/get_menu_item_info',
                async: false,
                data: {
                    item_id: item_id, 
                    form_submit: true,
                }, 
                dataType: 'json'
                }).responseText
            );
            
            //assign values to modal    
            $("#edit-menu-title").val(data.title);
            $("#edit-menu-url").val(data.url);
            $("#edit-menu-css").val(data.class);
            $("#edit-menu-keyword").val(data.keyword);
            $("#edit-menu-icon").val(data.icon);
            $("#edit-menu-item-id").val(data.id);
            $("#edit-menu-target").val(data.target);
            $('.loader-' +item_id).hide();
        }

        /**
         * Controls:: Update Menu Item
        */
        $('#btn-edit-menu-item').click(function(){
            var title =  $("#edit-menu-title").val();
            var url = $("#edit-menu-url").val();
            var css = $("#edit-menu-css").val();
            var keyword = $("#edit-menu-keyword").val();
            var icon = $("#edit-menu-icon").val();
            var item_id = $("#edit-menu-item-id").val();
            var target = $("#edit-menu-target").val();

            if(title.length == 0){
                $('#edit-menu-title').focus();
                $('#edit-menu-title').css('border', '1px solid red');
            }else if(url.length == 0){
                $('#edit-menu-url').focus();
                $('#edit-menu-url').css('border', '1px solid red');
            }else{
                updateMenuItemInfo(title, url, css, keyword, icon, item_id, target);              
            }
            
        });

        /**
         * Method:: Update Menu Item
        */
        function updateMenuItemInfo(title, url, css, keyword, icon, item_id, target){
            $('.processing-loader-modal').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/update_menu_item',
                 dataType: 'json',
                data: {
                    title: title,
                    url: url,
                    css: css,
                    keyword: keyword,
                    icon: icon,
                    item_id: item_id,
                    target: target,
                    form_submit: true,
                }, 
                success: function(response){
                    $('.processing-loader-modal').hide();
                    $('#modal-edit-menu-item').modal('hide');

                    if(response.success == true){
                        showSuccessMessageUpdateItem();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }



        /**
         * Controls:: Delete Menu Item
        */
        $('.delete-menu-item').click(function(){
            var item_id = $(this).data('id');
            showConfirmMessage(item_id);
        });


        /**
         * Method:: Delete Menu Item
        */
        function deleteMenuItem(item_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/delete_menu_item',
                dataType: 'json',
                data: {
                    item_id: item_id,
                    form_submit: true,
                }, 
                success: function(response){
                    console.log(response);
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
         * Edit Menu Group Name
        */
        $("#edit-menu-name").click(function(){
            //alert("set textbox editable");
            $("#menu-name").prop('disabled', false);
            $("#menu-name").css({"border":"1px solid #ccc", "padding":"5px"});

            //focus input at the end of text
            var FocusInput = $("#menu-name"); 
            FocusInput.val(FocusInput.val());
            var strLength= FocusInput.val().length;
            FocusInput.focus();
            FocusInput[0].setSelectionRange(strLength, strLength);
        });
        
        //save menu details on enter key
        $("#menu-name").bind("enterKey",function(e){
            var menu_name = $(this).val();
            var menu_id = $("#menu-type-id").html();
            updateMenuName(menu_id, menu_name); //execute update function
        });
        $("#menu-name").keyup(function(e){
            if(e.keyCode == 13){
                $(this).trigger("enterKey");
            }
        });

        function updateMenuName(menu_id, menu_name){
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/update_menutype_name',
                dataType: 'json',
                data: {
                    menu_id: menu_id, 
                    menu_name: menu_name,
                    form_submit: true
                }, 
                success: function(response){
                    if(response.success == true){
                        location.reload(); //reload page if success
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                }
            });
        }
        /**
         * #END# Edit Menu Group Name
        */


        /**
         *  Delete Menu Type
        */
        $("#delete-menu-name").click(function(){
            var menu_type_id = $("#menu-type-id").html();
            showConfirmDeleteMenuType(menu_type_id); //show confirm pop
        });

        function deleteMenuType(menu_type_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/delete_menutype',
                data: {
                    menu_type_id: menu_type_id,
                    form_submit: true,
                },
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    showSuccessMessageDeleteMenuType();
                }
            });
        }
        /**
         *  #END# Delete Menu Type
        */



        /**
         * Sweet Alert - Pop Up 
         *
        */
        function showConfirmMessage(id) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this menu item.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            }, function () {
               //delete after confirmation
                deleteMenuItem(id);
            });
        }

        function showDeleteSuccess() {
            swal({
                title: "Deleted!",
                text: "Menu item has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }


        function showSuccessMessageMenuType() {
            swal({
                title: "Success!",
                text: "New menu has been created.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }

        function showSuccessMessageSaveItem() {
            swal({
                title: "Success!",
                text: "New menu item has been added.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }

        function showSuccessMessageSaveMenuGroupItems() {
            swal({
                title: "Success!",
                text: "Menu order and position has been successfully updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }

        function showSuccessMessageUpdateItem() {
            swal({
                title: "Success!",
                text: "Menu item has been successfully updated.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }

        function showConfirmDeleteMenuType(id) {
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this menu and all associated menu items.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Delete it!",
                closeOnConfirm: false
            }, function () {
               //delete after confirmation
                deleteMenuType(id);
            });
        }

        function showSuccessMessageDeleteMenuType() {
            swal({
                title: "Success!",
                text: "Menu group has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }




        /**
         * Load Menu Item from Other Modules
         * Module:: Posts
        */
        $('#btn-item-from-post').click(function(){
            var posts_selected = [];
            var menu_type_id = $("#menu-type-id").html();
            $('ul.posts').find("input:checkbox:checked").each(function () {
                posts_selected.push($(this).val());
            });

            if($("ul.posts input:checkbox:checked").length == 0){
                showMessage("Field Required", "Please select an item to add on this menu.", "warning");
            }else{
                posts_selected = JSON.stringify(posts_selected); //format posts_selected into json string
                save_menu_item_from_post(menu_type_id, posts_selected);   
            }
            
        });

        function save_menu_item_from_post(menu_type_id, posts_selected){
            $('.processing-loader-save-item-post').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/save_menu_item_from_post',
                data: {
                    menu_type_id: menu_type_id,
                    posts_selected: posts_selected,
                    form_submit: true,
                },
                dataType: 'json',
                success: function(response){
                    $('.processing-loader-save-item-post').hide();
                    if(response.success == true){
                        showSuccessMessageItemSave();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                }
            });
        }


        /**
         * Load Menu Item from Other Modules
         * Module:: Categories
        */
        $('#btn-item-from-category').click(function(){
            var category_selected = [];
            var menu_type_id = $("#menu-type-id").html();
            $('ul.categories').find("input:checkbox:checked").each(function () {
                category_selected.push($(this).val());
            });

            if($("ul.categories input:checkbox:checked").length == 0){
                showMessage("Field Required", "Please select an item to add on this menu.", "warning");
            }else{
                category_selected = JSON.stringify(category_selected); //format category_selected into json string
                save_menu_item_from_category(menu_type_id, category_selected);   
            }
            
        });

        function save_menu_item_from_category(menu_type_id, category_selected){
            $('.processing-loader-save-item-category').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/save_menu_item_from_post_category',
                data: {
                    menu_type_id: menu_type_id,
                    category_selected: category_selected,
                    form_submit: true,
                },
                dataType: 'json',
                success: function(response){
                    $('.processing-loader-save-item-category').hide();
                    if(response.success == true){
                        showSuccessMessageItemSave();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }


        /**
         * Load Menu Item from Other Modules
         * Module:: Page
        */
        $('#btn-item-from-page').click(function(){
            var page_selected = [];
            var menu_type_id = $("#menu-type-id").html();
            $('ul.pages').find("input:checkbox:checked").each(function () {
                page_selected.push($(this).val());
            });

            if($("ul.pages input:checkbox:checked").length == 0){
                showMessage("Field Required", "Please select an item to add on this menu.", "warning");
            }else{
                page_selected = JSON.stringify(page_selected); //format page_selected into json string
                save_menu_item_from_page(menu_type_id, page_selected);   
            }
            
        });

        function save_menu_item_from_page(menu_type_id, page_selected){
            $('.processing-loader-save-item-page').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/save_menu_item_from_page',
                data: {
                    menu_type_id: menu_type_id,
                    page_selected: page_selected,
                    form_submit: true,
                },
                dataType: 'json',
                success: function(response){
                    $('.processing-loader-save-item-page').hide();
                    if(response.success == true){
                        showSuccessMessageItemSave();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }



        /**
         * Load Menu Item from Other Modules
         * Module:: Module
        */
        $('#btn-item-from-module').click(function(){
            var module_selected = [];
            var menu_type_id = $("#menu-type-id").html();
            $('ul.modules').find("input:checkbox:checked").each(function () {
                module_selected.push($(this).val());
            });

            if($("ul.modules input:checkbox:checked").length == 0){
                showMessage("Field Required", "Please select an item to add on this menu.", "warning");
            }else{
                module_selected = JSON.stringify(module_selected); //format module_selected into json string
                save_menu_item_from_module(menu_type_id, module_selected);   
            }
            
        });

        function save_menu_item_from_module(menu_type_id, module_selected){
            $('.processing-loader-save-item-module').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/menus/save_menu_item_from_module',
                data: {
                    menu_type_id: menu_type_id,
                    module_selected: module_selected,
                    form_submit: true,
                },
                dataType: 'json',
                success: function(response){
                    $('.processing-loader-save-item-module').hide();
                    if(response.success == true){
                        showSuccessMessageItemSave();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }






        //sweet alerts popup
        //general pop up
        function showMessage(title, description, status) {
            swal(title, description, status);
        }

        function showSuccessMessageItemSave() {
            swal({
                title: "Success!",
                text: "Menu item has been successfully added.",
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


<script type="text/javascript">
    $(function () {
        $('.dd').nestable();


        $('.dd').on('change', function () {
            var $this = $(this);
            var serializedData = window.JSON.stringify($($this).nestable('serialize'));
     
            $('#nestableMenu-output').val(serializedData);
        });
    });
</script>