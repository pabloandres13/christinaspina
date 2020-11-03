<?php

/**
 * UniqID
 */

if (!function_exists('yprm_vc_uniqid')) {
  function yprm_vc_uniqid() {
    return array(
      "type" => "el_id",
      "heading" => esc_html__("uniqid", "pt-addons"),
      "param_name" => "uniqid",
    );
  }
}

/**
 * BG
 */

if (!function_exists('yprm_vc_bg_overlay')) {
  function yprm_vc_bg_overlay($i = false) {
    $array = array(
      array(
        "type" => "switch",
        "heading" => esc_html__("Background Overlay", "pt-addons"),
        "param_name" => "bg_overlay",
        "value" => "off",
        "options" => array(
          "on" => array(
            "on" => esc_html__("On", "pt-addons"),
            "off" => esc_html__("Off", "pt-addons"),
          ),
        ),
        "default_set" => false,
      ),
      array(
        "type" => "switch",
        "heading" => esc_html__("Color Overlay", "pt-addons"),
        "param_name" => "color_overlay",
        "value" => "off",
        "options" => array(
          "on" => array(
            "on" => esc_html__("On", "pt-addons"),
            "off" => esc_html__("Off", "pt-addons"),
          ),
        ),
        "default_set" => false,
        "dependency" => Array("element" => "bg_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "colorpicker",
        "heading" => esc_html__("Color", "pt-addons"),
        "param_name" => "color_overlay_hex",
        "dependency" => Array("element" => "color_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "number",
        "heading" => esc_html__("Opacity", "pt-addons"),
        "param_name" => "color_overlay_opacity",
        "min" => "0",
        "max" => "100",
        "suffix" => "%",
        "dependency" => Array("element" => "color_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "switch",
        "heading" => esc_html__("Gradient Overlay", "pt-addons"),
        "param_name" => "gradient_overlay",
        "value" => "off",
        "options" => array(
          "on" => array(
            "on" => esc_html__("On", "pt-addons"),
            "off" => esc_html__("Off", "pt-addons"),
          ),
        ),
        "default_set" => false,
        "dependency" => Array("element" => "bg_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "colorpicker",
        "heading" => esc_html__("Start Color", "pt-addons"),
        "param_name" => "gradient_overlay_start_hex",
        "dependency" => Array("element" => "gradient_overlay", "value" => array("on")),
        "edit_field_class" => "vc_col-auto",
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "colorpicker",
        "heading" => esc_html__("End Color", "pt-addons"),
        "param_name" => "gradient_overlay_end_hex",
        "dependency" => Array("element" => "gradient_overlay", "value" => array("on")),
        "edit_field_class" => "vc_col-auto",
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "switch",
        "heading" => esc_html__("Circles", "pt-addons"),
        "param_name" => "circles_overlay",
        "value" => "off",
        "options" => array(
          "on" => array(
            "on" => esc_html__("On", "pt-addons"),
            "off" => esc_html__("Off", "pt-addons"),
          ),
        ),
        "default_set" => false,
        "dependency" => Array("element" => "bg_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "dropdown",
        "heading" => esc_html__("Style", "pt-addons"),
        "param_name" => "circles_overlay_style",
        "value" => array(
          esc_html__("Style 1", "pt-addons") => "style1",
          esc_html__("Style 2", "pt-addons") => "style2",
        ),
        "dependency" => Array("element" => "circles_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "number",
        "heading" => esc_html__("Opacity", "pt-addons"),
        "param_name" => "circles_overlay_opacity",
        "min" => "0",
        "max" => "100",
        "suffix" => esc_html__('%', 'pt-addons'),
        "dependency" => Array("element" => "circles_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "textfield",
        "heading" => esc_html__("Text", "pt-addons"),
        "param_name" => "text_overlay",
        "dependency" => Array("element" => "bg_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "textfield",
        "heading" => esc_html__("Top Offset", "pt-addons"),
        "param_name" => "text_overlay_top",
        "dependency" => Array("element" => "text_overlay", "not_empty" => true),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "textfield",
        "heading" => esc_html__("Font Size", "pt-addons"),
        "param_name" => "text_overlay_fs",
        "description" => esc_html__("Examples: 20px or 2em or 120%", "pt-addons"),
        "dependency" => Array("element" => "text_overlay", "not_empty" => true),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "colorpicker",
        "heading" => esc_html__("Color", "pt-addons"),
        "param_name" => "text_overlay_color",
        "dependency" => Array("element" => "text_overlay", "not_empty" => true),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "number",
        "heading" => esc_html__("Opacity", "pt-addons"),
        "param_name" => "text_overlay_opacity",
        "suffix" => esc_html__("%", "pt-addons"),
        "dependency" => Array("element" => "text_overlay", "not_empty" => true),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "switch",
        "heading" => esc_html__("Color Change", "pt-addons"),
        "param_name" => "color_change_overlay",
        "value" => "off",
        "options" => array(
          "on" => array(
            "on" => esc_html__("On", "pt-addons"),
            "off" => esc_html__("Off", "pt-addons"),
          ),
        ),
        "default_set" => false,
        "dependency" => Array("element" => "bg_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
      array(
        "type" => "textfield",
        "heading" => esc_html__("Color Array", "pt-addons"),
        "param_name" => "color_change_overlay_array",
        "description" => esc_html__("Example: #00c6ff,#ff7200,#c600ff,#ff0090,#ffea00,#00ffcc", "pt-addons"),
        "dependency" => Array("element" => "color_change_overlay", "value" => array("on")),
        "group" => esc_html__('Background Overlay', 'pt-addons'),
      ),
    );
    if (!$i) {
      return $array;
    } else {
      return $array[$i];
    }
  }
}

/**
 * Video Background
 */

if (!function_exists('yprm_vc_bg_video')) {
  function yprm_vc_bg_video($controll_buttons = true) {
    $array = array(
      array(
        "type" => "video",
        "heading" => esc_html__("Background Video url", "pt-addons"),
        "param_name" => "video_url",
        "description" => esc_html__("Source YouTube, Vimeo and mp4 file", "pt-addons"),
      ),
      array(
        "type" => "dropdown",
        "heading" => esc_html__("Quality", "pt-addons"),
        "param_name" => "background_video_quality",
        "value" => array(
          esc_html__("2K", "pt-addons") => "1440p",
          esc_html__("FullHD", "pt-addons") => "1080p",
          esc_html__("HD", "pt-addons") => "720p",
        ),
        "description" => esc_html__('Only for Vimeo or YouTube', 'pt-addons'),
        "dependency" => Array("element" => "video_url", "not_empty" => true),
        "std" => "720p",
        "group" => esc_html__("Video", "pt-addons"),
      )
    );

    if($controll_buttons) {
      $array = array_merge($array, array(
        array(
          "type" => "switch",
          "heading" => esc_html__("Control buttons", "pt-addons"),
          "param_name" => "background_video_controls",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "dependency" => Array("element" => "video_url", "not_empty" => true),
          "default_set" => false,
          "group" => esc_html__("Video", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Autoplay", "pt-addons"),
          "param_name" => "background_video_autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "dependency" => Array("element" => "background_video_controls", "value" => "on"),
          "default_set" => true,
          "group" => esc_html__("Video", "pt-addons"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Mute", "pt-addons"),
          "param_name" => "background_video_mute",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("Yes", "pt-addons"),
              "off" => esc_html__("No", "pt-addons"),
            ),
          ),
          "dependency" => Array("element" => "video_url", "not_empty" => true),
          "default_set" => true,
          "group" => esc_html__("Video", "pt-addons"),
        )
      ));
    }
    return $array;
  }
}

/**
 * Social Links
 */

if (!function_exists('yprm_vc_social_icon')) {
  function yprm_social_links_array() {
    return array(
      esc_html__('None', 'novo') => '',
      esc_html__('500px', 'novo') => '500px',
      esc_html__('Amazon', 'novo') => 'amazon',
      esc_html__('App Store', 'novo') => 'app-store',
      esc_html__('Behance', 'novo') => 'behance',
      esc_html__('Blogger', 'novo') => 'blogger',
      esc_html__('Codepen', 'novo') => 'codepen',
      esc_html__('Digg', 'novo') => 'digg',
      esc_html__('Dribbble', 'novo') => 'dribbble',
      esc_html__('Dropbox', 'novo') => 'dropbox',
      esc_html__('Ebay', 'novo') => 'ebay',
      esc_html__('Facebook', 'novo') => 'facebook',
      esc_html__('Flickr', 'novo') => 'flickr',
      esc_html__('Foursquare', 'novo') => 'foursquare',
      esc_html__('GitHub', 'novo') => 'github',
      esc_html__('Google Plus', 'novo') => 'google-plus',
      esc_html__('Instagram', 'novo') => 'instagram',
      esc_html__('Itunes', 'novo') => 'itunes',
      esc_html__('Kickstarter', 'novo') => 'kickstarter',
      esc_html__('LinkedIn', 'novo') => 'linkedin',
      esc_html__('Mailchimp', 'novo') => 'mailchimp',
      esc_html__('MixCloud', 'novo') => 'mixcloud',
      esc_html__('Windows', 'novo') => 'windows',
      esc_html__('Odnoklassniki', 'novo') => 'odnoklassniki',
      esc_html__('PayPal', 'novo') => 'paypal',
      esc_html__('Periscope', 'novo') => 'periscope',
      esc_html__('OpenID', 'novo') => 'openid',
      esc_html__('Pinterest', 'novo') => 'pinterest',
      esc_html__('Reddit', 'novo') => 'reddit',
      esc_html__('Skype', 'novo') => 'skype',
      esc_html__('Snapchat', 'novo') => 'snapchat',
      esc_html__('SoundCloud', 'novo') => 'soundcloud',
      esc_html__('Spotify', 'novo') => 'spotify',
      esc_html__('Stack Overflow', 'novo') => 'stack-overflow',
      esc_html__('Steam', 'novo') => 'steam',
      esc_html__('Stripe', 'novo') => 'stripe',
      esc_html__('Telegram', 'novo') => 'telegram',
      esc_html__('Tumblr', 'novo') => 'tumblr',
      esc_html__('Twitter', 'novo') => 'twitter',
      esc_html__('Viber', 'novo') => 'viber',
      esc_html__('Vimeo', 'novo') => 'vimeo',
      esc_html__('VK', 'novo') => 'vk',
      esc_html__('Whatsapp', 'novo') => 'whatsapp',
      esc_html__('Yahoo', 'novo') => 'yahoo',
      esc_html__('Yelp', 'novo') => 'yelp',
      esc_html__('Yoast', 'novo') => 'yoast',
      esc_html__('YouTube', 'novo') => 'youtube',
    );
  }
  
  function yprm_vc_social_icon($count = 0) {
    $icons = yprm_social_links_array();

    $return = array();

    for ($i=1; $i <= $count; $i++) { 
      array_push($return, 
        array(
          "type" => "heading",
          "heading_value" => esc_html__("Social link $i", "pt-addons"),
          "param_name" => "h_social_link$i",
          "dependency" => Array("element" => "social_links", "value" => array("on")),
          "group" => esc_html__("Social links", "pt-addons"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon", "pt-addons"),
          "param_name" => "social_type$i",
          "value" => $icons,
          "edit_field_class" => "vc_col-auto",
          "dependency" => Array("element" => "social_links", "value" => array("on")),
          "group" => esc_html__("Social links", "pt-addons"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "pt-addons"),
          "param_name" => "social_link$i",
          "edit_field_class" => "vc_col-auto",
          "dependency" => Array("element" => "social_links", "value" => array("on")),
          "group" => esc_html__("Social links", "pt-addons"),
        )
      );
    }

    return $return;
  }
}

if (!function_exists('yprm_vc_social_links')) {
  function yprm_vc_social_links() {
    return array(
      array(
        "type" => "switch",
        "heading" => esc_html__("Social buttons", "pt-addons"),
        "param_name" => "social_links",
        "value" => "on",
        "options" => array(
          "on" => array(
            "on" => esc_html__("On", "pt-addons"),
            "off" => esc_html__("Off", "pt-addons"),
          ),
        ),
        "default_set" => true,
        "group" => esc_html__("Elements", "pt-addons"),
      ),
      array(
        "type" => "dropdown",
        "heading" => esc_html__("Social buttons align", "pt-addons"),
        "param_name" => "social_links_align",
        "dependency" => Array("element" => "social_links", "value" => array("on")),
        "value" => array(
          esc_html__("Left", "pt-addons") => "left",
          esc_html__("Right", "pt-addons") => "right",
        ),
        "std" => "left",
        "group" => esc_html__("Elements", "pt-addons"),
      ),
      array(
        "type" => "colorpicker",
        "heading" => esc_html__("Social buttons color", "pt-addons"),
        "param_name" => "social_links_color",
        "dependency" => Array("element" => "social_links", "value" => array("on")),
        "group" => esc_html__("Elements", "pt-addons"),
      ),
    );
  }
}

/**
 * Icons
 */

if (!function_exists('yprm_vc_icons')) {
  function yprm_vc_icons() {
    return array(
      array(
        'type' => 'dropdown',
        'heading' => esc_html__('Icon library', 'pt-addons'),
        'value' => array(
          esc_html__('Select', 'pt-addons') => '',
          esc_html__('Font Awesome', 'pt-addons') => 'fontawesome',
          esc_html__('Open Iconic', 'pt-addons') => 'openiconic',
          esc_html__('Typicons', 'pt-addons') => 'typicons',
          esc_html__('Entypo', 'pt-addons') => 'entypo',
          esc_html__('Linecons', 'pt-addons') => 'linecons',
          esc_html__('Mono Social', 'pt-addons') => 'monosocial',
          esc_html__('Material', 'pt-addons') => 'material',
        ),
        'admin_label' => true,
        'param_name' => 'type',
        'description' => esc_html__('Select icon library.', 'pt-addons'),
      ),
      /* array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_yprm_icons',
        'value' => 'base-icon-avatar',
        'settings' => array(
          'emptyIcon' => false,
          'type' => 'yprm_icons',
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'yprm_icons',
        ),
      ), */
      array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_fontawesome',
        'value' => 'fa fa-adjust',
        'settings' => array(
          'emptyIcon' => false,
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'fontawesome',
        ),
      ),
      array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_openiconic',
        'value' => 'vc-oi vc-oi-dial',
        'settings' => array(
          'emptyIcon' => false,
          'type' => 'openiconic',
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'openiconic',
        ),
      ),
      array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_typicons',
        'value' => 'typcn typcn-adjust-brightness',
        'settings' => array(
          'emptyIcon' => false,
          'type' => 'typicons',
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'typicons',
        ),
      ),
      array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_entypo',
        'value' => 'entypo-icon entypo-icon-note',
        'settings' => array(
          'emptyIcon' => false,
          'type' => 'entypo',
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'entypo',
        ),
      ),
      array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_linecons',
        'value' => 'vc_li vc_li-heart',
        'settings' => array(
          'emptyIcon' => false,
          'type' => 'linecons',
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'linecons',
        ),
      ),
      array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_monosocial',
        'value' => 'vc-mono vc-mono-fivehundredpx',
        'settings' => array(
          'emptyIcon' => false,
          'type' => 'monosocial',
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'monosocial',
        ),
      ),
      array(
        'type' => 'iconpicker',
        'heading' => esc_html__('Icon', 'pt-addons'),
        'param_name' => 'icon_material',
        'value' => 'vc-material vc-material-cake',
        'settings' => array(
          'emptyIcon' => false,
          'type' => 'material',
          'iconsPerPage' => 300,
        ),
        'dependency' => array(
          'element' => 'type',
          'value' => 'material',
        ),
      ),
    );
  }
}

/**
 * Cols
 */

if (!function_exists('yprm_vc_cols')) {
  function yprm_vc_cols() {
    return array(
      "type" => "cols",
      "heading" => esc_html__("Cols", "pt-addons"),
      "param_name" => "cols"
    );
  }
}

/**
 * Background Parallax
 */

if(!function_exists('yprm_vc_bg_parallax')) {
  function yprm_vc_bg_parallax() {
    return array(
      array(
        "type" => "switch",
        "heading" => esc_html__("Background Parallax", "pt-addons"),
        "param_name" => "background_parallax",
        "value" => "off",
        "options" => array(
          "on" => array(
            "on" => esc_html__("On", "pt-addons"),
            "off" => esc_html__("Off", "pt-addons"),
          ),
        ),
        "default_set" => false,
        "dependency" => Array("element" => "background_image", "not_empty" => true ),
      ),
      array(
        "type" => "dropdown",
        "heading" => esc_html__("Background Parallax Align", "pt-addons"),
        "param_name" => "background_parallax_align",
        "value" => array(
          esc_html__("Top", "pt-addons") => "top",
          esc_html__("Center", "pt-addons") => "center",
          esc_html__("Bottom", "pt-addons") => "bottom",
        ),
        "std" => "center",
        "dependency" => Array("element" => "background_parallax", "value" => "on" ),
      ),
      array(
        "type" => "number",
        "heading" => esc_html__("Background Parallax Speed", "pt-addons"),
        "param_name" => "background_parallax_speed",
        "min" => "0",
        "value" => "0.2",
        "dependency" => Array("element" => "background_parallax", "value" => "on" ),
      )
    );
  }
}