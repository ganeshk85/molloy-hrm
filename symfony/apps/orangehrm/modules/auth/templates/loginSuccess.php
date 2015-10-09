<?php
$imagePath = theme_path("images/login");
?>
<style type="text/css">

    body {
        background-color: #FFFFFF;
        height: 700px;
    }

    img {
        border: none;
    }
    #btnLogin {
        padding: 0;
    }
    /*input:not([type="image"]) {
        background-color: transparent;
        border: none;
    }*/

    /*input:focus, select:focus, textarea:focus {
        background-color: transparent;
        border: none;
    }*/

    .textInputContainer {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 18px;
        line-height: 20px;
        color: #666666;
    }

    #divLogin {
        background: transparent;
        height: 520px;
        width: 100%;
        border-style: hidden;
        margin: auto;
        padding-left: 10px;
    }

    #divUsername {
        padding-top: 30px;
        margin: 0 20px;
        /*padding-left: 30%;*/
    }

    #divPassword {
        padding-top: 35px;
        margin: 0 20px;
        /*padding-left: 30%;*/
    }

    #txtUsername {
        width: 240px;
        /*border: 0px;*/
        background-color: transparent;
    }

    #txtPassword {
        width: 240px;
        /*border: 0px;*/
        background-color: transparent;
    }

    #txtUsername, #txtPassword {
        font-family: Arial, Helvetica, sans-serif;
        color: #666666;
        vertical-align: middle;
        padding-top:0;
        height: 22px;
    }
    
    #divLoginHelpLink {
        width: 270px;
        background-color: transparent;
        height: 20px;
        margin-top: 12px;
        margin-right: 0px;
        margin-bottom: 0px;
        margin-left: 50%;
    }

    #divLoginButton {
        padding: 0 0 20px;                
        width: 350px;
        text-align: center;
    }

    #btnLogin {
        /*background: url(<?php echo "{$imagePath}/Login_button.png"; ?>) no-repeat;*/
        background: #981E32;
        cursor:pointer;
        width: 94px;
        height: 26px;
        border: none;
        color:#FFFFFF;
        font-weight: bold;
        font-size: 13px;
    }

    #divLink {
        padding-left: 230px;
        padding-top: 105px;
        float: left;
    }

    #divLogo {
        padding-left: 10%;
		background-color: #000000;
        /*padding-top: 70px;*/
    }

    #spanMessage {
        background: transparent url(<?php echo "{$imagePath}/mark.png"; ?>) no-repeat;
        padding-left: 18px; 
        padding-top: 0px;
        color: #DD7700;
        font-weight: bold;
    }
    
    #logInPanelHeading{
        position:relative;
        padding-top:100px;
		padding-left:30%;
        font-family:sans-serif;
        font-size: 15px;
        
        font-weight: bold;
    }
    
    .form-hint {
    color: #878787;
    padding: 4px 8px;
    position: relative;
    /*left:-254px;*/
}
.form-box{
margin: 90px auto 0;
width: 360px;
}

.form-box .header{
background: #981E32 none repeat scroll 0 0;
border-radius: 4px 4px 0 0;
box-shadow: 0 -3px 0 rgba(0, 0, 0, 0.2) inset;
color: #fff;
font-size: 26px;
font-weight: 300;
padding: 20px 10px !important;
text-align: center;
}

#frmLogin{
    background: #f4f4f4;
}
</style>

<div id="divLogin">
    <div id="divLogo">
        <img src="<?php echo "{$imagePath}/logo.png"; ?>" />
    </div>

    <div class="form-box">
        
    
    <form id="frmLogin" method="post" action="<?php echo url_for('auth/validateCredentials'); ?>">
        <input type="hidden" name="actionID"/>
        <input type="hidden" name="hdnUserTimeZoneOffset" id="hdnUserTimeZoneOffset" value="0" />
        <?php 
            echo $form->renderHiddenFields(); // rendering csrf_token 
        ?>
        <div id="logInPanelHeading" class="header"><?php echo __('Login to Molloy College HRM System'); ?></div>

        <div id="divUsername" class="textInputContainer">
            <label>Username</label><br/>
            <?php echo $form['Username']->render(); ?>

        </div>
        <div id="divPassword" class="textInputContainer">
            <label>Password</label>
            <br/>
            <?php echo $form['Password']->render(); ?>
         
        </div>
        <div id="divLoginHelpLink"><?php
            include_component('core', 'ohrmPluginPannel', array(
                'location' => 'login-page-help-link',
            ));
            ?></div>
        <div id="divLoginButton">
            <input type="submit" name="Submit" class="button" id="btnLogin" value="<?php echo __('LOGIN'); ?>" />
            <?php if (!empty($message)) : ?>
            <span id="spanMessage"><?php echo __($message); ?></span>
            <?php endif; ?>
        </div>
    </form>
        </div>

</div>

<div style="text-align: center">
    <?php include_component('core', 'ohrmPluginPannel', array(
                'location' => 'other-login-mechanisms',
            )); ?>
</div>

<?php //include_partial('global/footer_copyright_social_links'); ?>

<script type="text/javascript">
    
    function calculateUserTimeZoneOffset() {
        var myDate = new Date();
        var offset = (-1) * myDate.getTimezoneOffset() / 60;
        return offset;
    }
            
    function addHint(inputObject, hintImageURL) {
        if (inputObject.val() == '') {
            inputObject.css('background', "url('" + hintImageURL + "') no-repeat 10px 3px");
        }
    }
            
    function removeHint() {
       $('.form-hint').css('display', 'none');
    }
    
    function showMessage(message) {
        if ($('#spanMessage').size() == 0) {
            $('<span id="spanMessage"></span>').insertAfter('#btnLogin');
        }

        $('#spanMessage').html(message);
    }
    
    function validateLogin() {
        var isEmptyPasswordAllowed = false;
        
        if ($('#txtUsername').val() == '') {
            showMessage('<?php echo __('Username cannot be empty'); ?>');
            return false;
        }
        
        if (!isEmptyPasswordAllowed) {
            if ($('#txtPassword').val() == '') {
                showMessage('<?php echo __('Password cannot be empty'); ?>');
                return false;
            }
        }
        
        return true;
    }
    
    $(document).ready(function() {
        /*Set a delay to compatible with chrome browser*/
        setTimeout(checkSavedUsernames,100);
        
        $('#txtUsername').focus(function() {
            removeHint();
        });
        
        $('#txtPassword').focus(function() {
             removeHint();
        });
        
        $('.form-hint').click(function(){
            removeHint();
            $('#txtUsername').focus();
        });
        
        $('#hdnUserTimeZoneOffset').val(calculateUserTimeZoneOffset().toString());
        
        $('#frmLogin').submit(validateLogin);
        
    });

    function checkSavedUsernames(){
        if ($('#txtUsername').val() != '') {
            removeHint();
        }
    }

    if (window.top.location.href != location.href) {
        window.top.location.href = location.href;
    }
</script>
