<?php 
if( $this->session->userdata('username')!=null){
    // redirect('home');
}
?>
<!doctype html>
<html class="bg-black">
<head>

    <title>Login Admin</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="robots" content="noarchive, noodp, noydir">
        <link href="<?=admin_asset();?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=admin_asset();?>css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=admin_asset();?>css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?=admin_asset();?>css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <script src="<?=admin_asset();?>js/jquery.min.js"></script>
        <script src="<?=admin_asset();?>js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
</head>
    <body class="bg-black">
        <div class="form-box" id="login-box">
        
            <div class="margin text-center" style="background:rgb(168, 29, 50);">
                <?php 
                 echo $this->session->flashdata('error');
                 echo validation_errors(); 
                ?>
            </div>
            <div class="header">Sign In</div>
            <form action="<?=base_url();?>admin" method="post">
                <div class="body bg-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" value="" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password" value="" />
                    </div>
                    <div class="form-group">
                        <p><span>
                                <iframe scrolling="no" style="width: 120px; border: 0px none; height: 68px;" src="<?=base_url();?>captcha">
                                </iframe>
                                </span>
                            &nbsp;&nbsp;<span id="reload" style="cursor:pointer">Recaptcha</span></p>
                        <p><input class="form-control" type="text" name="captcha" placeholder="Type the text above" /></p>
                    </div>
                    <!-- <div class="form-group">
                        <input type="checkbox" name="remember_me"/> Remember me
                    </div> -->
                </div>
                <div class="footer">                                                               
                    <button type="submit" class="btn bg-olive btn-block">Sign me in</button>  
                    
                    <p><a href="#">I forgot my password</a></p>
                </div>
            </form>

        </div>
<script type="text/javascript">
    $(function  () {
        $("#reload").click(function(){
            // $.ajax({
            //     'url': '<?php echo base_url();?>captcha',
            //     // 'beforeSend': function(){ $("img").attr('src', '...');},
            //     'success': function(data){ 
            //         $("iframe").attr('src', data);
            //     }
                var iframe=document.getElementsByTagName('iframe');
                iframe[0].setAttribute('src', '<?php echo base_url();?>captcha');
            // });
            // $("img").attr('src','none');     
            // $("img").attr('src','<?php echo base_url();?>captcha');     
        });
       
    });
</script>
    </body>
</html>