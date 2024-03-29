<?php if (!defined('OC_ADMIN') || OC_ADMIN!==true) exit('Access is not allowed.');?>
<?php
if(Params::getParam('plugin_action')=='done') {
  $file = Params::getFiles('xml');
  if(isset($file['error']) && $file['error']==0 && isset($file['size']) && $file['size']>0) {
    $tmpfile = osc_content_path().'uploads/xmlimporter_ads.temp';
    @unlink($tmpfile);
    if (move_uploaded_file($file['tmp_name'], $tmpfile)) {
      $num_ads = xmlimporter_countads($tmpfile);
    } else {
      $num_ads = 0;
    }
  } else {
    osc_add_flash_error_message(__('File uploaded was not valid', 'xmlimporter'), 'admin');
    osc_show_flash_message('admin');
    $num_ads = 0;
  }

  if($num_ads>0) {
?>  
<script type="text/javascript">
  var errors = new Array();
  var total_ads = <?php echo $num_ads; ?>;
  $(document).ready(function(){

    $("#dialog-progress").dialog({
      width: 550,
      height: 450,
      autoOpen: true,
      modal: true,
      title: "<?php echo osc_esc_js(__("Import in progress", "xmlimporter")); ?>"
    });

    $("#dialog-stats").dialog({
      width: 550,
      height: 450,
      autoOpen: false,
      modal: true,
      title: "<?php echo osc_esc_js(__("Import completed", "xmlimporter")); ?>"
    });

    $("#close-dialog-progress").on("click", function(){
      window.location = '<?php echo osc_admin_render_plugin_url(osc_plugin_folder(__FILE__)."importer.php"); ?>';
    });

    parse_ad(0, '', '');
  });

  function parse_ad(num_ad, cat_info, meta_info) {
    $("#progress").text("<?php echo osc_esc_js(__("Importing ad {NUM_AD} out of {TOTAL_ADS}", "xmlimporter")); ?>".replace("{NUM_AD}", (num_ad+1)).replace("{TOTAL_ADS}", total_ads));
    $.getJSON(
    "<?php echo osc_admin_base_url(true); ?>?page=ajax&action=custom&ajaxfile=<?php echo osc_plugin_folder(__FILE__);?>ajax.php&subaction=parsead",
      {"importfile" : "<?php echo $tmpfile; ?>"
      ,"num_ad" : num_ad
      ,"cat_info" : cat_info
      ,"meta_info" : meta_info
      },
      function(data){
        if(data.error!=1 && data.error!=2) {
          errors.push("#" + num_ad + " : " + data.error + "<br/>");
        }
        num_ad++;
        if(num_ad<total_ads) {
          parse_ad(num_ad, data.cat_info, data.meta_info);
        } else {
          $("#dialog-progress").dialog('close');
          var str = "<?php echo osc_esc_js(__("{IMPORTED_ADS} ads were imported", "xmlimporter")); ?>".replace("{IMPORTED_ADS}", (total_ads-errors.length));
          if(errors.length>0) {
            str += "<br />";
            str += "<?php echo osc_esc_js(__("{FAILED_ADS} ads failed to import", "xmlimporter")); ?>".replace("{FAILED_ADS}", errors.length);
            str += "<br />";
            str += "<?php echo osc_esc_js(__("(Ads numbers: {LIST_ADS})", "xmlimporter")); ?>".replace("{LIST_ADS}", errors.toString());
          }
          $("#stats-text").html(str);
          $("#dialog-stats").dialog('open');
        }
      }
    );
  };
</script>
<?php }; ?>

<div id="dialog-stats">
  <div id="stats-text"></div>
  <div class="form-actions">
  <div class="wrapper">
    <button class="btn btn-red close-dialog">Cancel</button>
  </div>
  </div>
</div>
<div id="dialog-progress" style="border: 1px solid #ccc; background: #eee; ">
  <div>
  <div>
    <div id="total_ads">
    <?php if($num_ads>0) {
          echo sprintf(_n('%s ad detected', '%s ads detected', $num_ads, 'xmlimporter'), $num_ads);
        } else {
          _e('No ads have been detected, nothing to do.', 'xmlimporter');
        }; ?>
    </div>
    <div id="progress"></div>
    <div>
    <h3>
      <?php _e('WARNING', 'xmlimporter'); ?>
    </h3>
    <p>
      <label>
      <?php _e('This process could take a while, DO NOT CLOSE the browser.', 'xmlimporter'); ?>
      </label>
    </p>
    </div>
  </div>
  </div>
  <div style="clear: both;"></div>
  <div class="form-actions">
  <div class="wrapper">
    <button id="close-dialog-progress" class="btn btn-red close-dialog">Cancel</button>
  </div>
  </div>
</div>
<?php
}
?>
<div id="import_form" style="border: 1px solid #ccc; background: #eee; ">
  <div style="padding: 20px;">
  <div style="float: left; width: 50%;">
    <fieldset>
    <legend>
    <?php _e('Ad importer', 'xmlimporter'); ?>
    </legend>
    <form name="jobs_form" id="jobs_form" action="<?php echo osc_admin_base_url(true);?>" method="post" enctype="multipart/form-data" >
      <input type="hidden" name="page" value="plugins" />
      <input type="hidden" name="action" value="renderplugin" />
      <input type="hidden" name="file" value="<?php echo osc_plugin_folder(__FILE__);?>importer.php" />
      <input type="hidden" name="plugin_action" value="done" />
      <input type="file" name="xml" id="xml" />
      <label for="upload_xml">
      <?php _e('Upload XML', 'xmlimporter'); ?>
      </label>
      <br/>
      <button type="submit">
      <?php _e('Upload', 'xmlimporter'); ?>
      </button>
    </form>
    </fieldset>
  </div>
  <div style="float: left; width: 50%;">
    <fieldset>
    <legend>
    <?php _e('Help', 'xmlimporter'); ?>
    </legend>
    <p>
      <label>
      <?php _e('Be sure you have ALL curencies from xml added in your osclass site, if you plan to upload in parent categories make sure you have ticked the option "Allow users to select a parent category as a category when inserting or editing a listing" in settings->general. Make sure you have all countries from xml (if you add ads with diff countries).<br />
You have a test xml there as example (example: cityarea I use it as phone field, but you can use it as u want).<br />
If you want to add custom fields in xml see example <br />
Custom fields must exists and must be attached to category... ', 'xmlimporter'); ?>
      </label>
    </p>
    </fieldset>
  </div>
  <div style="clear: both;"></div>
  </div>
</div>