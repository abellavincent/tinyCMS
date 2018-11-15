<div class="content-wrapper">
    <h3 class="page-heading mb-4">Mail Settings</h3>



    <div class="card">
        <div class="card-body">
            <h5 class="card-title mb-4">Email Information</h5>
            
            <div class="form-group">
                <label for="contact"><b>From Email *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $settings->mail_from_email; ?>" name="contact" id="from-email" placeholder="Enter email address from">
            </div>

            <div class="form-group">
                <label for="email"><b>From Name *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $settings->mail_from_name; ?>" name="email" id="from-name" placeholder="Enter name from">
            </div>
        </div>
    </div>


    <div class="card card-spacer">
        <div class="card-body">
            <h5 class="card-title mb-4">Mailer Settings</h5>
    
            <div class="form-group">
                <label for="contact"><b>Protocol *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $settings->smtp_protocol; ?>" name="contact" id="protocol" placeholder="Enter SMTP Protocol">
            </div>

            <div class="form-group">
                <label for="text"><b>SMTP Host *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $settings->smtp_host; ?>" name="email" id="host" placeholder="Enter SMTP Host">
            </div>

            <div class="form-group">
                <label for="text"><b>SMTP Port *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $settings->smtp_port; ?>" name="email" id="port" placeholder="Enter SMTP Port">
            </div>

            <div class="form-group">
                <label for="text"><b>Username / Email *</b> </label>
                <input type="text" class="form-control p-input" value="<?php echo $settings->smtp_user; ?>" name="email" id="username" placeholder="Enter username or email address">
            </div>

            <div class="form-group">
                <label for="text"><b>Password *</b> </label>
                <input type="password" class="form-control p-input" value="<?php echo $settings->smtp_pass; ?>" name="email" id="password" placeholder="Enter password ">
            </div>
    

            
            <div class="form-group">
                <button type="submit" id="btn-save-settings" class="btn btn-primary"><i class="fa fa-check-square-o"></i>&nbsp; Save Settings</button>&nbsp;&nbsp;
                <span class="processing-loader-general" style="display: none;"><i class="fa fa-spinner fa-spin"></i> Saving...</span>&nbsp;&nbsp;</center>
            </div>
          
        </div>
    </div>
   

</div><!--./content-wrapper-->


<!-- Le Javascripts -->
<script type="text/javascript">
  $(document).ready(function(){
  
    var base_url = '<?php echo site_url();?>';
   
    /**
     * Save General Setting
    */
    $('#btn-save-settings').click(function(e){
        e.preventDefault();
        var from_email = $('#from-email').val();
        var from_name = $('#from-name').val();

        var protocol = $('#protocol').val();
        var host = $('#host').val();
        var port = $('#port').val();
        var username = $('#username').val();
        var password = $('#password').val();

        save_mail_settings(from_email, from_name, protocol, host, port, username, password);
    });


    function save_mail_settings(from_email, from_name, protocol, host, port, username, password){
        $('.processing-loader-general').show();
        $.ajax({
            type: "POST",
            url: base_url +'admin/settings/save_mail_settings',
            dataType: 'json',
            data: {
                from_email: from_email, 
                from_name: from_name,
                protocol: protocol,
                host: host,
                port: port,
                username: username,
                password: password,
                form_submit: true
            }, 
            success: function(response){
                $('.processing-loader-general').hide();
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
            text: "Mail settings has been successfully updated.",
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