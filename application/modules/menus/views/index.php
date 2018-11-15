<div class="content-wrapper">
    <h3 class="page-heading mb-4">Menu Manager</h3>

    <div class="row">
        <div class="col-md-12">
           
            <ul id="nav-menu-type" class="nav nav-tabs">

                <?php if($menu_types): foreach($menu_types as $menu_type):?>
                    
                    <li class="nav-item">
                        <a class="nav-link <?php echo ($menu_type === reset($menu_types) ? 'active':'');?>"  href="<?php echo site_url('menus/admin/menus/edit_menu/'.$menu_type->id);?>"><?php echo $menu_type->name;?></a>
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
                <div class="card-body my-card ">
                    <h5 class="card-title mb-4">Add New Item</h5>
                    
                        <form id="add-item-form">
                            <div class="form-group">
                                <label for="title"><b>Title *</b> </label>
                                <input type="text" class="form-control p-input" value="" name="title" id="title" placeholder="Enter menu item title">
                            </div>
                            <div class="form-group">
                                <label for="url"><b>Url *</b></label>
                                <input type="text" class="form-control p-input" name="url" id="url" placeholder="Enter menu item url">
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

                            <div class="form-group">
                                <input type="hidden" id="menu-type" value="<?php echo $menu_type_data_first->id;?>">
                                <input type="submit" id="btn-add-menu-item" class="btn btn-primary" value="Add Menu Item">&nbsp;&nbsp;
                                <span class="processing-loader-save-item" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>
                            </div>
                        </form>
                </div>
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
                                    <button type="button" class="btn btn-primary btn-save-menu-items">Save Menu</button>
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
                                                        <?php echo $item->title;?>
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
                                <br><br>
                                <span class="pull-right">
                                    <span class="processing-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span> &nbsp;&nbsp;
                                    <button type="button" class="btn btn-primary btn-save-menu-items">Save Menu</button>
                                </span>
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
                url: base_url +'menus/admin/menus/save_menu_type',
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
                url: base_url +'menus/admin/menus/save_menu_item',
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
                url: base_url +'menus/admin/menus/save_menugroup_items',
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
            getMenuItemsInfo(item_id);
            $('#modal-edit-menu-item').modal('show');
        });


        /**
         * Method:: GetMenuItem Info
        */
        function getMenuItemsInfo(item_id){
            $('.loader-' +item_id).show();
            var data = $.parseJSON(
            $.ajax({
                type: "POST", 
                url: base_url +'menus/admin/menus/get_menu_item_info',
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

            if(title.length == 0){
                $('#edit-menu-title').focus();
                $('#edit-menu-title').css('border', '1px solid red');
            }else if(url.length == 0){
                $('#edit-menu-url').focus();
                $('#edit-menu-url').css('border', '1px solid red');
            }else{
                updateMenuItemInfo(title, url, css, keyword, icon, item_id);              
            }
            
        });

        /**
         * Method:: Update Menu Item
        */
        function updateMenuItemInfo(title, url, css, keyword, icon, item_id){
            $('.processing-loader-modal').show();
            $.ajax({
                type: "POST",
                url: base_url +'menus/admin/menus/update_menu_item',
                 dataType: 'json',
                data: {
                    title: title,
                    url: url,
                    css: css,
                    keyword: keyword,
                    icon: icon,
                    item_id: item_id,
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
                url: base_url +'menus/admin/menus/delete_menu_item',
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
                url: base_url +'menus/admin/menus/update_menutype_name',
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
                url: base_url +'menus/admin/menus/delete_menutype',
                data: {
                    menu_type_id: menu_type_id,
                    form_submit: true,
                },
                dataType: 'json',
                success: function(response){
                    console.log(response);
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