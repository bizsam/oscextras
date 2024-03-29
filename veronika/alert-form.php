<script type="text/javascript">
$(document).ready(function(){
  $('#alert_email').val('');
  $('#alert_email').attr('placeholder', '<?php echo osc_esc_js(__('Enter your email', 'veronika')) ; ?>');

  $('.alert-show').click(function(e) {
    e.preventDefault();
    $('#n-block .top').slideUp(300, function(){
      $('#n-block .bot').slideDown(300);
    });
  });


  if (($(window).width()) <= 767) {
    var alert_close_btn = true;
  } else {
    var alert_close_btn = false;
  }


  $(".alert-notify").click(function(e){
    e.preventDefault();

    <?php if(!osc_is_web_user_logged_in()) { ?>
    if(($("#alert_email").val()).trim() == '') {
      $("#alert_email").focus();
      return false;
    }
    <?php } ?>
    
    $.post(
      '<?php echo osc_base_url(true); ?>', 
      {
        email: $("#alert_email").val(), 
        userid: $("#alert_userId").val(), 
        alert: $("#alert").val(), 
        page:"ajax", 
        action:"alerts"
      }, 
      function(data){
        if(data==1) {
          if (!!$.prototype.fancybox) {
            $.fancybox({
              'padding':  0,
              'width':    640,
              'minHeight': 100,
              'height':   240,
              'autoSize': false,
              'autoDimensions': false,
              'closeBtn' : alert_close_btn,
              'wrapCSS':  'alert-func',
              'content':  '<div id="alert-ok" class="fw-box alert-messages">' + $('.fw-box#alert-ok').html() + '</div>'
            });
          }
        } else if(data==-1) { 
          if (!!$.prototype.fancybox) {
            $.fancybox({
              'padding':  0,
              'width':    640,
              'minHeight': 100,
              'height':   240,
              'autoSize': false,
              'autoDimensions': false,
              'closeBtn' : alert_close_btn,
              'wrapCSS':  'alert-func',
              'content':  '<div id="alert-email" class="fw-box alert-messages">' + $('.fw-box#alert-email').html() + '</div>'
            });
          }
        } else if(data==0) { 
          if (!!$.prototype.fancybox) {
            $.fancybox({
              'padding':  0,
              'width':    640,
              'minHeight': 100,
              'height':   240,
              'autoSize': false,
              'autoDimensions': false,
              'closeBtn' : alert_close_btn,
              'wrapCSS':  'alert-func',
              'content':  '<div id="alert-error" class="fw-box alert-messages">' + $('.fw-box#alert-error').html() + '</div>'
            });
          }
        }
    });

    return false;
  });
});
</script>

<div id="n-block" class="block <?php if(osc_is_web_user_logged_in()) { ?>logged_user<?php } else { ?>unlogged_user<?php } ?>">
  <div class="n-wrap">
    <form action="<?php echo osc_base_url(true); ?>" method="post" name="sub_alert" id="sub_alert">
      <?php AlertForm::page_hidden(); ?>
      <?php AlertForm::alert_hidden(); ?>
      <?php AlertForm::user_id_hidden(); ?>

      <?php if(osc_is_web_user_logged_in()) { ?>

        <?php AlertForm::email_hidden(); ?>
        <button type="button" class="btn btn-secondary alert-notify"><?php _e('Subscribe to this search', 'veronika'); ?></button>

      <?php } else { ?>

        <div class="top"><a href="#" class="btn btn-secondary alert-show"><?php _e('Subscribe to this search', 'veronika'); ?></a></div>
        <div class="bot" style="display:none;">
          <?php AlertForm::email_text(); ?>
          <button type="button" class="btn btn-secondary alert-notify"><i class="fa fa-check"></i></button>
        </div>
      <?php } ?>
    </form>
  </div>
</div>



<!-- ALERT MESSAGES -->
<div class="alert-fancy-boxes">
  <div id="alert-ok" class="fw-box">
    <div class="head">
      <h2><?php _e('Subscribe to alert', 'veronika'); ?></h2>
      <a href="#" class="def-but fw-close-button round3"><i class="fa fa-times"></i> <?php _e('Close', 'veronika'); ?></a>
    </div>

    <div class="middle">
      <div class="a-message">
        <div class="icon good"><i class="fa fa-check-circle"></i></div>
        <span class="first"><?php _e('You have successfully subscribed to alert!', 'veronika'); ?></span>
        <span><?php _e('You will recieve notification to your email once there is new listing that match your search criteria.', 'veronika'); ?></span>
      </div>
    </div>
  </div>

  <div id="alert-email" class="fw-box">
    <div class="head">
      <h2><?php _e('Subscribe to alert', 'veronika'); ?></h2>
      <a href="#" class="def-but fw-close-button round3"><i class="fa fa-times"></i> <?php _e('Close', 'veronika'); ?></a>
    </div>

    <div class="middle">
      <div class="a-message">
        <div class="icon bad"><i class="fa fa-times-circle"></i></div>
        <span class="first"><?php _e('There was error during subscription process!', 'veronika'); ?></span>
        <span><?php _e('You have entered email address in incorrect format or you did not entered email address.', 'veronika'); ?></span>
      </div>
    </div>
  </div>

  <div id="alert-error" class="fw-box">
    <div class="head">
      <h2><?php _e('Subscribe to alert', 'veronika'); ?></h2>
      <a href="#" class="def-but fw-close-button round3"><i class="fa fa-times"></i> <?php _e('Close', 'veronika'); ?></a>
    </div>

    <div class="middle">
      <div class="a-message">
        <div class="icon good"><i class="fa fa-check-circle"></i></div>
        <span class="first"><?php _e('You have already subscribed to this search.', 'veronika'); ?></span>
        <span><?php _e('You can find alerts you have subscribed for in your account.', 'veronika'); ?></span>
      </div>
    </div>
  </div>
</div>