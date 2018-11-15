<div class="content-wrapper">
    <h3 class="page-heading mb-4">View Inquiries</h3>

    <div class="row">
	    <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    
                  	<h5 class="card-title mb-4">Message Details</h5>
                    <p><b>Date Sent:</b> <?php echo formatDate($inquiry->date_sent).' '.formatTime($inquiry->date_sent);?></p>
                    <p><b>Subject:</b> <?php echo $inquiry->subject;?></p>
                    <p><b>Message:</b></p>
                    <p><?php echo $inquiry->message;?></p>

                    <p><a href="#" class="btn btn-success btn-reply" title="Inquiry Reply" data-id="<?php echo $inquiry->id;?>" data-name="<?php echo $inquiry->name; ?>" data-email="<?php echo $inquiry->email;?>" data-datesent="<?php echo $inquiry->date_sent;?>" data-message="<?php echo $inquiry->message;?>"><i class="fa fa-reply"></i> &nbsp;Reply to <?php echo ucfirst($inquiry->name);?></a></p>

                    <!-- admin replied info abellavinent 10.26.2018 -->
                    <?php if($inquiry->status == "replied"): ?>
                        
                        <?php foreach ($inquiry_reply as $reply): ?>
                            <blockquote>
                                <p><?php echo $reply->reply_message; ?><br><br></p>
                                <div class="clearfix"></div>
                                <p style="margin-top: 20px;"><span class="pull-right"><small><i>~ <?php echo $reply->send_by; ?> replied on <?php echo formatDate($reply->date_sent); ?> at <?php echo formatTime($reply->date_sent); ?></i></small></span></p>
                            </blockquote>
                        <?php endforeach ?>
                    <?php endif; ?>

                    <style type="text/css">
                        blockquote {
                          background: #e6fff5;
                          border-left: 10px solid #58d8a3;
                          margin: 1.5em 10px;
                          padding: 2em 10px;
                          quotes: "\201C""\201D""\2018""\2019";
                        }
                        blockquote:before {
                          color: #58d8a3;
                          content: open-quote;
                          font-size: 4em;
                          line-height: 0.1em;
                          margin-right: 0.25em;
                          vertical-align: -0.4em;
                        }
                        blockquote p {
                          display: inline;
                        }
                    </style>
                    <!-- end admin replied info -->
                </div>
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Sender Information</h5>
                    <p><?php echo $inquiry->name;?></p>
                    <p><?php echo $inquiry->contact;?></p>
                    <p><?php echo $inquiry->email;?></p>
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



<!-- le javascripts -->
<script type="text/javascript">
$(document).ready(function(){

    var base_url = '<?php echo site_url();?>';

    /**
     * Reply to Inquiry
    */
    $('.btn-reply').click(function(){
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
});
</script>


