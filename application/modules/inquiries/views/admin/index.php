<div class="content-wrapper">
    <h3 class="page-heading mb-4">Inquiries</h3>

    <div class="row">
	    <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Search Form -->
                    <div class="col-sm-3 col-sm-offset-3 pull-right">
                        <!-- <form id="form-search" action="<?php echo site_url('admin/inquiries/search');?>" method="post">  
                            <input type="hidden" name="form_submit" value="TRUE">
                            <div class="input-group">
                                <input class="form-control" id="search-keyword" name="search-keyword" value="<?php echo (isset($keyword) ? $keyword:'');?>" placeholder="Search ">
                                <div class="input-group-addon" id="btn-submit-search" style="cursor:pointer;"><i class="fa fa-search"></i></div>
                            </div>
                        </form> -->
                    </div>
                    <!-- Search Form -->

                  	<h5 class="card-title mb-4">All Inquiries</h5>
                  	
                    <!--Post All, Publish, Draft, Trash > Set font bold-->
                    <div class="row clearfix" style="margin-bottom: 10px;">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <a href="<?php echo site_url('admin/inquiries/status/new');?>" class="status-tab-link"><?php echo set_navigation_active('new', 'New');?></a> <span class="text-muted">(<?php echo $inquiries_count[0]->totalNew;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/inquiries/status/all');?>" class="status-tab-link"><?php echo set_navigation_active('all', 'All');?></a> <span class="text-muted">(<?php echo $inquiries_count[0]->All;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/inquiries/status/read');?>" class="status-tab-link"><?php echo set_navigation_active('read', 'Opened');?></a> <span class="text-muted">(<?php echo $inquiries_count[0]->totalRead;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/inquiries/status/replied');?>" class="status-tab-link"><?php echo set_navigation_active('replied', 'Replied');?></a> <span class="text-muted">(<?php echo $inquiries_count[0]->totalReplied;?>)</span> &nbsp; | &nbsp;
                            <a href="<?php echo site_url('admin/inquiries/status/trash');?>" class="status-tab-link"><?php echo set_navigation_active('trash', 'Trash');?></a> <span class="text-muted">(<?php echo $inquiries_count[0]->totalTrash;?>)</span>
                        </div>                      
                    </div>

                    <br>


                    <div class="table-responsive">
                        <?php if(isset($is_search)):?>
                            <p class="text-muted pull-right"><?php echo $results_count;?> results</p>
                            <p><b>Search results found for:</b> &nbsp; <i><?php echo $keyword;?></i></p>
                        <?php endif;?>

                    	<table id="inquiries-table" class="table table-striped center-aligned-table">
                      	<thead>
                        	<tr class="text-black">
                                <th>ID</th>
                        		<th>Name</th>
                                <th>Subject</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Email</th>
                          		<th width="130px"><span class="pull-right">Actions</span></th>
                        	</tr>
                      	</thead>
                      	<tbody>
                        	<?php if(isset($inquiries)): if($inquiries):?>
                                <?php foreach($inquiries as $inquiry):?>
                                    <tr>
                                        <td><?php echo $inquiry->id;?></td>
                                        <td><?php echo anchor(site_url('admin/inquiries/view/'.$inquiry->id), $inquiry->name, 'class="post-title"');?></b></td>
                                        <td><?php echo $inquiry->subject;?></td>
                                        <td><?php echo formatDate($inquiry->date_sent).' '. formatTime($inquiry->date_sent);?></td>
                                        <td><?php echo set_inquiry_status($inquiry->status);?></td>
                                        <td><?php echo $inquiry->email;?></td>
                                        
                                        <td class="pull-right">
                                            <a href="#" class="btn btn-success btn-reply btn-sm" title="Inquiry Reply" data-id="<?php echo $inquiry->id;?>" data-name="<?php echo $inquiry->name; ?>" data-email="<?php echo $inquiry->email;?>" data-datesent="<?php echo $inquiry->date_sent;?>" data-message="<?php echo $inquiry->message;?>"><i class="fa fa-reply"></i></a> &nbsp; 

                                            <a href="<?php echo site_url('admin/inquiries/view/'.$inquiry->id);?>" class="btn btn-primary btn-sm" title="View Inquiry"><i class="fa fa-eye"></i></a> &nbsp; 
                                            
                                            <?php if(isTrashUri() == TRUE):?>
                                                <a href="#" class="btn btn-danger btn-sm delete-permanently pull-right" data-id="<?php echo $inquiry->id;?>" title="Delete Permanently"><i class="fa fa-trash-o"></i></a>
                                            <?php else:?>
                                                <a href="#" class="btn btn-danger btn-sm trash-inquiry pull-right" data-id="<?php echo $inquiry->id;?>" title="Move to Trash"><i class="fa fa-trash-o"></i></a>
                                            <?php endif;?>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            <?php else:?>
                                <tr><td colspan="7"> <p><br>No inquiries found.</p></td></tr>
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





<!-- Modal:: Inquiries Reply -->
<div class="modal fade" id="modal-inquiries-reply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Reply to <span id="reply-name"></span> <br><small id="reply-email"></small></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="col-md-12 no-padding">
                    <div class="container">
                      <img src="<?php echo base_url(); ?>/assets/images/default-profile-pic.png" alt="Avatar">
                      <p id="reply-message"></p>
                      <span class="time-right" id="reply-date"></span>
                    </div>

                    <div class="form-group">
                        <label for="menu-type-name"><b>Message: </b></label>
                        <span class="pull-right err-menu-name"></span>
                        <textarea class="form-control" rows="5" id="email-message" placeholder="Your reply message ..."></textarea>
                    </div>
                </div>
            </div>
        
            <div class="modal-footer">
                <input type="hidden" class="form-control p-input" value="" name="email" id="email-reply" placeholder="Email address">
                <input type="hidden" class="form-control p-input" value="" name="email" id="inquiry-id">
                <span class="processing-loader-modal" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Sending...</span> &nbsp;&nbsp;
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-send-message" class="btn btn-primary">Send Message</button>
            </div>
        </div>
    </div>
</div>





<!-- Datatables -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#inquiries-table').DataTable({
            "order": [[ 0, "desc" ]]
        });
    });
</script>


<!-- Le Javascripts -->
<script type="text/javascript">
    $(document).ready(function(){

        var base_url = '<?php echo site_url();?>';



        /**
         * Reply to Inquiry
        */
        $('body').on('click', '.btn-reply', function() {
            $('#email-reply').val('');
            $('#email-message').val('');
            $('#email-message').css('border', '1px solid rgba(0, 0, 0, 0.15)');


            var inquiry_id = $(this).data('id');
            var email = $(this).data('email');
            var message = $(this).data('message');
            var date_sent = $(this).data('datesent');
            var name = $(this).data('name');

            //set values to modal
            $('#reply-name').text(name);
            $('#reply-email').text(email);
            $('#reply-message').text(message);
            $('#reply-date').text(date_sent);
            $('#email-reply').val(email);
            $('#inquiry-id').val(inquiry_id);

            //load modal
            $('#modal-inquiries-reply').modal('show');
        });


        $('#btn-send-message').click(function(){
            var email = $('#email-reply').val();
            var message = $('#email-message').val();
            var inquiry_id = $('#inquiry-id').val();
            var inquiry_msg = $('#reply-message').text();

            if(message.length == 0){
                $('#email-message').focus();
                $('#email-message').css('border', '1px solid red');
            }else{
                send_message(inquiry_id, email, message, inquiry_msg);
            }
        });


        function send_message(inquiry_id, email, message, inquiry_msg){
            $('.processing-loader-modal').show();
            $.ajax({
                type: "POST",
                url: base_url +'admin/inquiries/reply',
                dataType: 'json',
                data: {
                    inquiry_id: inquiry_id,
                    email: email,
                    message: message,
                    inquiry_msg: inquiry_msg,
                    form_submit: true,
                }, 

                success: function(response){
                    $('.processing-loader-modal').hide();
                    console.log(response);
                    if(response.success == true){
                        showReplySuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    
                }
            });
        }






      
        /**
         * Move to Trash
        */
        $('body').on('click', '.trash-inquiry', function() {
            var inquiry_id = $(this).data('id');
            showConfirmTrash(inquiry_id);
        });


        function move_to_trash(inquiry_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/inquiries/move_to_trash',
                dataType: 'json',
                data: {
                    inquiry_id: inquiry_id,
                    form_submit: true,
                }, 

                success: function(response){
                    if(response.success == true){
                        showTrashSuccess();
                    }else{
                        alert('Something went wrong. Please try again!');
                        location.reload();
                    }
                    //console.log(response);
                }
            });
        }
        /**
         * #END# Move to Trash
        */




        /**
         * Delete Inquiry Permanently
        */
        $('body').on('click', '.delete-permanently', function() {
            var inquiry_id = $(this).data('id');
            showConfirmDelete(inquiry_id);
        });

        function delete_permanently(inquiry_id){
            $.ajax({
                type: "POST",
                url: base_url +'admin/inquiries/delete_inquiry',
                dataType: 'json',
                data: {
                    inquiry_id: inquiry_id,
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
         * #END# Delete Inquiry Permanently
        */






        /**
         * Sweet Alert - Pop Up 
         *
        */
        function showConfirmTrash(inquiry_id) {
            swal({
                title: "Are you sure?",
                text: "This inquiry will be move to trash.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, Move it!",
                closeOnConfirm: false
            }, function () {
                move_to_trash(inquiry_id);
            });
        }

        function showTrashSuccess() {
            swal({
                title: "Success!",
                text: "Inquiry has been successfully moved to trash.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.reload(); //reload page after submitted
            });
        }


        function showReplySuccess() {
            swal({
                title: "Success!",
                text: "Message has been successfully sent.",
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
        function showConfirmDelete(inquiry_id) {
            swal({
                title: "Are you sure?",
                text: "This inquiry will be deleted permanently.",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            }, function () {
                delete_permanently(inquiry_id);
            });
        }

        function showDeleteSuccess() {
            swal({
                title: "Success!",
                text: "Inquiry has been successfully deleted.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#4ed1f7",
                confirmButtonText: "OK",
                closeOnConfirm: false
            }, function () {
                location.href = base_url +'admin/inquiries/status/trash';
            });
        }

    });
</script>