<?php if( $view == 'gallery' ) { ?>

  <div class="simple-prod o<?php echo $c; ?><?php if(osc_item_is_premium()) { ?> is-premium<?php } ?><?php if($class <> '') { echo ' ' . $class; } ?> <?php osc_run_hook("highlight_class"); ?>">
    <div class="simple-wrap">
      <?php if(function_exists('fi_make_favorite')) { echo fi_make_favorite(); } ?>

      <div class="item-img-wrap">
        <?php 
          $root = veronika_category_root( osc_item_category_id() ); 
          $cat_icon = veronika_get_cat_icon( $root['pk_i_id'], true );
          if( $cat_icon <> '' ) {
            $icon = $cat_icon;
          } else {
            $def_icons = array(1 => 'fa-gavel', 2 => 'fa-car', 3 => 'fa-book', 4 => 'fa-home', 5 => 'fa-wrench', 6 => 'fa-music', 7 => 'fa-heart', 8 => 'fa-briefcase', 999 => 'fa-soccer-ball-o');
            $icon = $def_icons[$root['pk_i_id']];
          }
        ?>

        <div class="category-link"><span><i class="fa <?php echo $icon; ?>"></i> <?php echo osc_item_category(); ?></span></div>

        <?php if(osc_count_item_resources()) { ?>
          <?php if(osc_count_item_resources() == 1) { ?>
            <a class="img-link" href="<?php echo osc_item_url(); ?>"><img class="lazyload" src="<?php echo veronika_resource_thumbnail_url(); ?>" data-src="<?php echo osc_resource_thumbnail_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
          <?php } else { ?>
            <a class="img-link" href="<?php echo osc_item_url(); ?>">
              <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
                <?php if($i <= 1) { ?>
                  <img class="lazyload link<?php echo $i; ?>" src="<?php echo veronika_resource_thumbnail_url(); ?>" data-src="<?php echo osc_resource_thumbnail_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" />
                <?php } ?>
              <?php } ?>
            </a>
          <?php } ?>
        <?php } else { ?>
          <a class="img-link" href="<?php echo osc_item_url(); ?>"><img class="lazyload" src="<?php echo osc_current_web_theme_url('images/no-image.png'); ?>" data-src="<?php echo osc_current_web_theme_url('images/no-image.png'); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
        <?php } ?>

        <?php if(osc_count_item_resources() >= 1) { ?>
          <a class="orange-but open-image" href="<?php echo osc_item_url(); ?>" title="<?php echo osc_esc_html(__('Pictures overview', 'veronika')); ?>"><i class="fa fa-camera"></i></a>
        <?php } else { ?>
          <a class="orange-but open-image disabled" title="<?php echo osc_esc_html(__('No pictures', 'veronika')); ?>" href="#"><i class="fa fa-camera"></i></a>
        <?php } ?>
      </div>

      <?php $item_extra = veronika_item_extra( osc_item_id() ); ?>
      <?php if($item_extra['i_sold'] == 1) { ?>
        <a class="sold-label" href="<?php echo osc_item_url(); ?>">
          <span><?php _e('sold', 'veronika'); ?></span>
        </a>
      <?php } else if($item_extra['i_sold'] == 2) { ?>
        <a class="reserved-label" href="<?php echo osc_item_url(); ?>">
          <span><?php _e('reserved', 'veronika'); ?></span>
        </a>
      <?php } else if(osc_item_is_premium()) { ?>
        <a class="premium-label" href="<?php echo osc_item_url(); ?>">
          <span><?php _e('premium', 'veronika'); ?></span>
        </a>
      <?php } ?>                  
      
      <a class="title" href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight(osc_item_title(), 100); ?></a>

      <div class="price"><span><?php echo veronika_check_category_price(osc_item_category_id()) ? osc_item_formated_price() : ''; ?></span></div>
    </div>
  </div>

<?php } else { ?>

  <div class="list-prod o<?php echo $c; ?><?php if(osc_item_is_premium()) { ?> is-premium<?php } ?><?php if($class <> '') { echo ' ' . $class; } ?> <?php osc_run_hook("highlight_class"); ?>">
    <?php if(function_exists('fi_make_favorite')) { echo fi_make_favorite(); } ?>

    <div class="left">
      <h3 class="resp-title"><a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight(osc_item_title(), 80); ?></a></h3>

      <?php if(osc_images_enabled_at_items() and osc_count_item_resources() > 0) { ?>
        <a class="big-img" href="<?php echo osc_item_url(); ?>"><img class="lazyload" src="<?php echo veronika_resource_thumbnail_url(); ?>" data-src="<?php echo osc_resource_thumbnail_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>

        <div class="img-bar">
          <?php osc_reset_resources(); ?>
          <?php for ( $i = 0; osc_has_item_resources(); $i++ ) { ?>
            <?php if($i < 3 && osc_count_item_resources() > 1) { ?>
              <span class="small-img<?php echo ($i==0 ? ' selected' : ''); ?>" id="bar_img_<?php echo $i; ?>"><img class="lazyload" src="<?php echo veronika_resource_thumbnail_url(); ?>" data-src="<?php echo osc_resource_thumbnail_url(); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></span>
            <?php } ?>
          <?php } ?>
        </div>
      <?php } else { ?>
        <a class="big-img no-img" href="<?php echo osc_item_url(); ?>"><img class="lazyload" src="<?php echo osc_current_web_theme_url('images/no-image.png'); ?>" data-src="<?php echo osc_current_web_theme_url('images/no-image.png'); ?>" title="<?php echo osc_esc_html(osc_item_title()); ?>" alt="<?php echo osc_esc_html(osc_item_title()); ?>" /></a>
      <?php } ?>
    </div>

    <div class="middle">
      <?php $item_extra = veronika_item_extra( osc_item_id() ); ?>
      <?php if($item_extra['i_sold'] == 1) { ?>
        <div class="flag sold"><?php _e('sold', 'veronika'); ?></div>
      <?php } else if($item_extra['i_sold'] == 2) { ?>
        <div class="flag reserved"><?php _e('reserved', 'veronika'); ?></div>
      <?php } else if(osc_item_is_premium()) { ?>
        <div class="flag"><?php _e('premium', 'veronika'); ?></div>
      <?php } ?>

      <h3><a href="<?php echo osc_item_url(); ?>"><?php echo osc_highlight(osc_item_title(), 80); ?></a></h3>
      <div class="desc <?php if(osc_count_item_resources() > 0) { ?>has_images<?php } ?>"><?php echo osc_highlight(osc_item_description(), 300); ?></div>
      <div class="loc"><i class="fa fa-map-marker"></i><?php echo veronika_location_format(osc_item_country(), osc_item_region(), osc_item_city()); ?></div>
      <div class="author">
        <i class="fa fa-pencil"></i><?php _e('Published by', 'veronika'); ?> 
        <?php if(osc_item_user_id() <> 0) { ?>
          <a href="<?php echo osc_user_public_profile_url(osc_item_user_id()); ?>"><?php echo osc_item_contact_name(); ?></a>
        <?php } else { ?>
          <?php echo (osc_item_contact_name() <> '' ? osc_item_contact_name() : __('Anonymous', 'veronika')); ?>
        <?php } ?>
      </div>
    </div>

    <div class="right">
      <div class="price"><?php echo veronika_check_category_price(osc_item_category_id()) ? osc_item_formated_price() : ''; ?></div>

      <a class="view round2" href="<?php echo osc_item_url(); ?>"><i class="fa fa-folder-open-o"></i> <?php _e('view', 'veronika'); ?></a>
      <a class="category" href="<?php echo osc_search_url(array('sCategory' => osc_item_category_id())); ?>"><?php echo osc_item_category(); ?></a>

      <span class="date">
        <?php _e('published', 'veronika'); ?> <span title="<?php echo osc_esc_html(osc_format_date(osc_item_pub_date())); ?>"><?php echo veronika_smart_date(osc_item_pub_date()); ?></span>
      </span>

      <span class="viewed">
        <?php echo __('viewed', 'veronika') . ' <span>' . osc_item_views() . 'x' . '</span>'; ?>
      </span>
    </div>
  </div>

<?php } ?>