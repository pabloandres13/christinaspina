<?php

// Element Description: PT Split Screen

class PT_Split_Screen_Type2 extends WPBakeryShortCode {

  public static $g_array = array();

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_split_screen_type2_mapping'));
    add_shortcode('pt_split_screen_type2', array($this, 'pt_split_screen_type2_html'));
    add_shortcode('pt_split_screen_type2_item', array($this, 'pt_split_screen_type2_item_html'));
  }

  // Element Mapping
  public function pt_split_screen_type2_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Split Screen Type 2", "novo"),
      "base" => "pt_split_screen_type2",
      "as_parent" => array('only' => 'pt_split_screen_type2_item'),
      "content_element" => true,
      "show_settings_on_create" => false,
      "icon" => "shortcode-icon-split-screen-type2",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Open Image on Popup", "novo"),
          "param_name" => "image_on_popup",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "dependency" => "",
          "default_set" => true,
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Social buttons", "novo"),
          "param_name" => "social_buttons",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "dependency" => "",
          "default_set" => true,
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Social buttons color", "novo"),
          "param_name" => "social_buttons_color_hex",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Pagination", "novo"),
          "param_name" => "dots",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "dependency" => "",
          "default_set" => true,
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Pagination color", "novo"),
          "param_name" => "dots_color",
          "dependency" => Array("element" => "dots", "value" => array("on")),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 1", "novo"),
          "param_name" => "social_icon1",
          "value" => array(
            esc_html__('---', 'novo') => "",
            esc_html__('500px', 'novo') => "fa fa-500px,500px",
            esc_html__('App.net', 'novo') => "fa fa-adn,App.net",
            esc_html__('Bitbucket', 'novo') => "fa fa-bitbucket,Bitbucket",
            esc_html__('Dropbox', 'novo') => "fa fa-dropbox,Dropbox",
            esc_html__('Facebook', 'novo') => "fa fa-facebook,Facebook",
            esc_html__('Flickr', 'novo') => "fa fa-flickr,Flickr",
            esc_html__('Foursquare', 'novo') => "fa fa-foursquare,Foursquare",
            esc_html__('GitHub', 'novo') => "fa fa-github,GitHub",
            esc_html__('Google', 'novo') => "fa fa-google,Google",
            esc_html__('Instagram', 'novo') => "fa fa-instagram,Instagram",
            esc_html__('LinkedIn', 'novo') => "fa fa-linkedin,LinkedIn",
            esc_html__('Windows', 'novo') => "fa fa-windows,Windows",
            esc_html__('Odnoklassniki', 'novo') => "fa fa-odnoklassniki,Odnoklassniki",
            esc_html__('OpenID', 'novo') => "fa fa-openid,OpenID",
            esc_html__('Pinterest', 'novo') => "fa fa-pinterest,Pinterest",
            esc_html__('Reddit', 'novo') => "fa fa-reddit,Reddit",
            esc_html__('SoundCloud', 'novo') => "fa fa-soundcloud,SoundCloud",
            esc_html__('Tumblr', 'novo') => "fa fa-tumblr,Tumblr",
            esc_html__('Twitter', 'novo') => "fa fa-twitter,Twitter",
            esc_html__('Vimeo', 'novo') => "fa fa-vimeo-square,Vimeo",
            esc_html__('VK', 'novo') => "fa fa-vk,VK",
            esc_html__('Yahoo', 'novo') => "fa fa-yahoo,Yahoo",
            esc_html__('YouTube', 'novo') => "fa fa-youtube,YouTube",
          ),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 1", "novo"),
          "param_name" => "social_link1",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "value" => "",
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 2", "novo"),
          "param_name" => "social_icon2",
          "value" => array(
            esc_html__('---', 'novo') => "",
            esc_html__('500px', 'novo') => "fa fa-500px,500px",
            esc_html__('App.net', 'novo') => "fa fa-adn,App.net",
            esc_html__('Bitbucket', 'novo') => "fa fa-bitbucket,Bitbucket",
            esc_html__('Dropbox', 'novo') => "fa fa-dropbox,Dropbox",
            esc_html__('Facebook', 'novo') => "fa fa-facebook,Facebook",
            esc_html__('Flickr', 'novo') => "fa fa-flickr,Flickr",
            esc_html__('Foursquare', 'novo') => "fa fa-foursquare,Foursquare",
            esc_html__('GitHub', 'novo') => "fa fa-github,GitHub",
            esc_html__('Google', 'novo') => "fa fa-google,Google",
            esc_html__('Instagram', 'novo') => "fa fa-instagram,Instagram",
            esc_html__('LinkedIn', 'novo') => "fa fa-linkedin,LinkedIn",
            esc_html__('Windows', 'novo') => "fa fa-windows,Windows",
            esc_html__('Odnoklassniki', 'novo') => "fa fa-odnoklassniki,Odnoklassniki",
            esc_html__('OpenID', 'novo') => "fa fa-openid,OpenID",
            esc_html__('Pinterest', 'novo') => "fa fa-pinterest,Pinterest",
            esc_html__('Reddit', 'novo') => "fa fa-reddit,Reddit",
            esc_html__('SoundCloud', 'novo') => "fa fa-soundcloud,SoundCloud",
            esc_html__('Tumblr', 'novo') => "fa fa-tumblr,Tumblr",
            esc_html__('Twitter', 'novo') => "fa fa-twitter,Twitter",
            esc_html__('Vimeo', 'novo') => "fa fa-vimeo-square,Vimeo",
            esc_html__('VK', 'novo') => "fa fa-vk,VK",
            esc_html__('Yahoo', 'novo') => "fa fa-yahoo,Yahoo",
            esc_html__('YouTube', 'novo') => "fa fa-youtube,YouTube",
          ),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 2", "novo"),
          "param_name" => "social_link2",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "value" => "",
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 3", "novo"),
          "param_name" => "social_icon3",
          "value" => array(
            esc_html__('---', 'novo') => "",
            esc_html__('500px', 'novo') => "fa fa-500px,500px",
            esc_html__('App.net', 'novo') => "fa fa-adn,App.net",
            esc_html__('Bitbucket', 'novo') => "fa fa-bitbucket,Bitbucket",
            esc_html__('Dropbox', 'novo') => "fa fa-dropbox,Dropbox",
            esc_html__('Facebook', 'novo') => "fa fa-facebook,Facebook",
            esc_html__('Flickr', 'novo') => "fa fa-flickr,Flickr",
            esc_html__('Foursquare', 'novo') => "fa fa-foursquare,Foursquare",
            esc_html__('GitHub', 'novo') => "fa fa-github,GitHub",
            esc_html__('Google', 'novo') => "fa fa-google,Google",
            esc_html__('Instagram', 'novo') => "fa fa-instagram,Instagram",
            esc_html__('LinkedIn', 'novo') => "fa fa-linkedin,LinkedIn",
            esc_html__('Windows', 'novo') => "fa fa-windows,Windows",
            esc_html__('Odnoklassniki', 'novo') => "fa fa-odnoklassniki,Odnoklassniki",
            esc_html__('OpenID', 'novo') => "fa fa-openid,OpenID",
            esc_html__('Pinterest', 'novo') => "fa fa-pinterest,Pinterest",
            esc_html__('Reddit', 'novo') => "fa fa-reddit,Reddit",
            esc_html__('SoundCloud', 'novo') => "fa fa-soundcloud,SoundCloud",
            esc_html__('Tumblr', 'novo') => "fa fa-tumblr,Tumblr",
            esc_html__('Twitter', 'novo') => "fa fa-twitter,Twitter",
            esc_html__('Vimeo', 'novo') => "fa fa-vimeo-square,Vimeo",
            esc_html__('VK', 'novo') => "fa fa-vk,VK",
            esc_html__('Yahoo', 'novo') => "fa fa-yahoo,Yahoo",
            esc_html__('YouTube', 'novo') => "fa fa-youtube,YouTube",
          ),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 3", "novo"),
          "param_name" => "social_link3",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "value" => "",
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 4", "novo"),
          "param_name" => "social_icon4",
          "value" => array(
            esc_html__('---', 'novo') => "",
            esc_html__('500px', 'novo') => "fa fa-500px,500px",
            esc_html__('App.net', 'novo') => "fa fa-adn,App.net",
            esc_html__('Bitbucket', 'novo') => "fa fa-bitbucket,Bitbucket",
            esc_html__('Dropbox', 'novo') => "fa fa-dropbox,Dropbox",
            esc_html__('Facebook', 'novo') => "fa fa-facebook,Facebook",
            esc_html__('Flickr', 'novo') => "fa fa-flickr,Flickr",
            esc_html__('Foursquare', 'novo') => "fa fa-foursquare,Foursquare",
            esc_html__('GitHub', 'novo') => "fa fa-github,GitHub",
            esc_html__('Google', 'novo') => "fa fa-google,Google",
            esc_html__('Instagram', 'novo') => "fa fa-instagram,Instagram",
            esc_html__('LinkedIn', 'novo') => "fa fa-linkedin,LinkedIn",
            esc_html__('Windows', 'novo') => "fa fa-windows,Windows",
            esc_html__('Odnoklassniki', 'novo') => "fa fa-odnoklassniki,Odnoklassniki",
            esc_html__('OpenID', 'novo') => "fa fa-openid,OpenID",
            esc_html__('Pinterest', 'novo') => "fa fa-pinterest,Pinterest",
            esc_html__('Reddit', 'novo') => "fa fa-reddit,Reddit",
            esc_html__('SoundCloud', 'novo') => "fa fa-soundcloud,SoundCloud",
            esc_html__('Tumblr', 'novo') => "fa fa-tumblr,Tumblr",
            esc_html__('Twitter', 'novo') => "fa fa-twitter,Twitter",
            esc_html__('Vimeo', 'novo') => "fa fa-vimeo-square,Vimeo",
            esc_html__('VK', 'novo') => "fa fa-vk,VK",
            esc_html__('Yahoo', 'novo') => "fa fa-yahoo,Yahoo",
            esc_html__('YouTube', 'novo') => "fa fa-youtube,YouTube",
          ),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 4", "novo"),
          "param_name" => "social_link4",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "value" => "",
          "group" => esc_html__("Social links", "novo"),
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Split Screen Type 2 item", "novo"),
      "base" => "pt_split_screen_type2_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-split-screen-type2",
      "is_container" => true,
      "as_child" => array('only' => 'pt_split_screen_type2'),
      "params" => array(
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Color", "novo"),
          "param_name" => "left_color",
          "value" => array(
            esc_html__("Black", "novo") => "black",
            esc_html__("White", "novo") => "white",
          ),
          "std" => 'black',
          "admin_label" => true,
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Header position", "novo"),
          "param_name" => "left_header_position",
          "value" => array(
            esc_html__("on top", "novo") => "top",
            esc_html__("on bottom", "novo") => "bottom",
          ),
          "std" => 'top',
          "admin_label" => true,
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Heading num", "novo"),
          "param_name" => "left_heading_num",
          "admin_label" => true,
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "left_heading",
          "admin_label" => true,
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Sub Heading on top", "novo"),
          "param_name" => "left_sub_heading_on_top",
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Sub Heading on bottom", "novo"),
          "param_name" => "left_sub_heading_on_bottom",
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Image", "novo"),
          "param_name" => "left_image",
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Video url", "novo"),
          "param_name" => "left_video_url",
          "description" => esc_html__("Supported YouTube & Vimeo", "novo"),
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "novo"),
          "param_name" => "left_link",
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Background color", "novo"),
          "param_name" => "left_background_color_hex",
          "description" => esc_html__("optional", "novo"),
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background image", "novo"),
          "param_name" => "left_bg_image",
          "group" => esc_html__("Side left", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Select Text color", "novo"),
          "param_name" => "left_text_color_hex",
          "description" => esc_html__("optional", "novo"),
          "group" => esc_html__("Side left", "novo"),
        ),

        array(
          "type" => "dropdown",
          "heading" => esc_html__("Color", "novo"),
          "param_name" => "right_color",
          "value" => array(
            esc_html__("Black", "novo") => "black",
            esc_html__("White", "novo") => "white",
          ),
          "std" => 'white',
          "admin_label" => true,
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Header position", "novo"),
          "param_name" => "right_header_position",
          "value" => array(
            esc_html__("on top", "novo") => "top",
            esc_html__("on bottom", "novo") => "bottom",
          ),
          "std" => 'top',
          "admin_label" => true,
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Heading num", "novo"),
          "param_name" => "right_heading_num",
          "admin_label" => true,
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "right_heading",
          "admin_label" => true,
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Sub Heading on top", "novo"),
          "param_name" => "right_sub_heading_on_top",
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Sub Heading on bottom", "novo"),
          "param_name" => "right_sub_heading_on_bottom",
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Image", "novo"),
          "param_name" => "right_image",
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Video url", "novo"),
          "param_name" => "right_video_url",
          "description" => esc_html__("Supported YouTube & Vimeo", "novo"),
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "novo"),
          "param_name" => "right_link",
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Background color", "novo"),
          "param_name" => "right_background_color_hex",
          "description" => esc_html__("optional", "novo"),
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Background image", "novo"),
          "param_name" => "right_bg_image",
          "group" => esc_html__("Side right", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Select Text color", "novo"),
          "param_name" => "right_text_color_hex",
          "description" => esc_html__("optional", "novo"),
          "group" => esc_html__("Side right", "novo"),
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_split_screen_type2_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'image_on_popup' => 'on',
          'social_buttons' => 'on',
          'social_buttons_color_hex' => '',
          'arrows' => 'on',
          'arrow_color' => '',
          'dots' => 'on',
          'dots_color' => '',
          'social_icon1' => '',
          'social_link1' => '',
          'social_icon2' => '',
          'social_link2' => '',
          'social_icon3' => '',
          'social_link3' => '',
          'social_icon4' => '',
          'social_link4' => '',
        ),
        $atts
      )
    );

    self::$g_array = array(
      'index' => 0,
      'image_on_popup' => $image_on_popup
    );

    $custom_css = "";
    $block_class = $id = uniqid('split-screen-');
    //$block_class .= ' popup-gallery';


    if (isset($arrow_color) && !empty($arrow_color)) {
      $custom_css .= '.' . $id . ' .nav-dots {
                color: ' . $arrow_color . ';
            }';
    }

    if (isset($dots_color) && !empty($dots_color)) {
      $custom_css .= '.' . $id . ' .pagination-dots {
                color: ' . $dots_color . ';
            }';
    }

    if (isset($social_buttons_color_hex) && !empty($social_buttons_color_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-social-buttons {
                color: ' . $social_buttons_color_hex . ';
            }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    wp_enqueue_script('touch-swipe');

    // Fill $html var with data
    $html = '<div class="split-screen-type2 ' . esc_attr($block_class) . '">';
    if ($social_buttons == 'on') {
      if ((!empty($social_icon1) && !empty($social_link1)) || (!empty($social_icon2) && !empty($social_link2)) || (!empty($social_icon3) && !empty($social_link3)) || (!empty($social_icon4) && !empty($social_link4))) {
        $html .= '<div class="banner-social-buttons">';
        $html .= '<div class="links">';
        if (!empty($social_icon1) && !empty($social_link1)) {
          $soc = explode(',', $social_icon1);
          $html .= '<a href="' . esc_url($social_link1) . '" class="item"><i class="' . esc_attr($soc[0]) . '"></i> ' . esc_html($soc[1]) . '</a>';
        }
        if (!empty($social_icon2) && !empty($social_link2)) {
          $soc = explode(',', $social_icon2);
          $html .= '<a href="' . esc_url($social_link2) . '" class="item"><i class="' . esc_attr($soc[0]) . '"></i> ' . esc_html($soc[1]) . '</a>';
        }
        if (!empty($social_icon3) && !empty($social_link3)) {
          $soc = explode(',', $social_icon3);
          $html .= '<a href="' . esc_url($social_link3) . '" class="item"><i class="' . esc_attr($soc[0]) . '"></i> ' . esc_html($soc[1]) . '</a>';
        }
        if (!empty($social_icon4) && !empty($social_link4)) {
          $soc = explode(',', $social_icon4);
          $html .= '<a href="' . esc_url($social_link4) . '" class="item"><i class="' . esc_attr($soc[0]) . '"></i> ' . esc_html($soc[1]) . '</a>';
        }
        $html .= '</div>';
        $html .= '</div>';
        vc_icon_element_fonts_enqueue('fontawesome');
      }
    }
    $html .= '<div class="items">' . do_shortcode($content) . '</div>';
    $html .= '<div class="pagination-dots"></div>';
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_split_screen_type2_item_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'left_color' => 'black',
          'left_header_position' => 'top',
          'left_heading_num' => '',
          'left_heading' => '',
          'left_sub_heading_on_top' => '',
          'left_sub_heading_on_bottom' => '',
          'left_image' => '',
          'left_video_url' => '',
          'left_link' => '',
          'left_background_color_hex' => '',
          'left_bg_image' => '',
          'left_text_color_hex' => '',

          'right_color' => 'white',
          'right_header_position' => 'top',
          'right_heading_num' => '',
          'right_heading' => '',
          'right_sub_heading_on_top' => '',
          'right_sub_heading_on_bottom' => '',
          'right_image' => '',
          'right_video_url' => '',
          'right_link' => '',
          'right_background_color_hex' => '',
          'right_bg_image' => '',
          'right_text_color_hex' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $left_item_attr = $right_item_attr = '';

    $left_css = $left_id = uniqid('item-');

    $right_css = $right_id = uniqid('item-');

    if (isset(wp_get_attachment_image_src($left_bg_image, 'full')[0])) {
      $left_item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($left_bg_image, 'full')[0]) . ');';
    }

    $full_left_src = wp_get_attachment_image_src($left_image, 'full');
    $full_right_src = wp_get_attachment_image_src($right_image, 'full');

    if (!empty($left_background_color_hex)) {
      $left_item_attr .= 'background-color: ' . $left_background_color_hex . ';';
    }

    if (!empty($left_text_color_hex)) {
      $left_item_attr .= 'color: ' . $left_text_color_hex . ';';
    }

    $left_css .= ' ' . $left_color . ' header-on-' . $left_header_position;

    $html = '<div class="screen-item">';
    $html .= '<div class="row">';
    $html .= '<div class="item popup-gallery item-left col-12 col-sm-6 ' . esc_attr($left_css) . '" style="' . esc_attr($left_item_attr) . '">';
    if (!empty($left_heading_num) || !empty($left_sub_heading_on_top) || !empty($left_heading) || !empty($left_sub_heading_on_bottom)) {
      $html .= '<div class="heading">';
      $html .= '<div>';
      if (!empty($left_heading_num)) {
        $html .= '<div class="num">' . wp_kses_post($left_heading_num) . '</div>';
      }
      $html .= '<div class="text">';
      if (!empty($left_sub_heading_on_top)) {
        $html .= '<div class="s">' . wp_kses_post($left_sub_heading_on_top) . '</div>';
      }
      if (!empty($left_heading)) {
        $html .= '<div class="h">' . wp_kses_post($left_heading) . '</div>';
      }
      if (!empty($left_sub_heading_on_bottom)) {
        $html .= '<div class="d">' . wp_kses_post($left_sub_heading_on_bottom) . '</div>';
      }
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';
    }
    if (isset(wp_get_attachment_image_src($left_image, 'large')[0])) {
      $html .= '<div class="image popup-item">';
      if (!empty($left_video_url)) {
        $html .= '<a class="play-button web-application-icon-right-arrow-play-button" href="' . esc_url($left_video_url) . '" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="960" height="640" src="' . VideoUrlParser::get_url_embed($left_video_url) . '" frameborder="0" allowfullscreen></iframe></div></div>\'></a>';
      } else if(self::$g_array['image_on_popup'] == 'on') {
        self:: $g_array['index']++;
        $html .= '<a class="popup-link popup-single" href="' . esc_url($full_left_src[0]) . '" data-size="'.esc_attr($full_left_src[1].'x'.$full_left_src[2]).'" data-id="'.esc_attr(self:: $g_array['index']).'"></a>';
      }
      $html .= wp_kses_post(wp_get_attachment_image($left_image, 'large'));
      $html .= '</div>';
    }
    if (isset(vc_build_link($left_link)['url']) && !empty(vc_build_link($left_link)['url'])) {
      $left_link = vc_build_link($left_link);

      if (empty($left_link['target'])) {
        $left_link['target'] = '_self';
      }

      if (empty($left_link['title'])) {
        $left_link['title'] = esc_html__('Read more', 'novo');
      }
      $html .= '<div class="button"><a href="' . esc_url($left_link['url']) . '" class="button-style1 permalink" target="' . esc_attr($left_link['target']) . '">' . wp_kses_post($left_link['title']) . '</a></div>';
    }
    $html .= '</div>';

    if (isset(wp_get_attachment_image_src($right_bg_image, 'full')[0])) {
      $right_item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($right_bg_image, 'full')[0]) . ');';
    }

    if (!empty($right_background_color_hex)) {
      $right_item_attr .= 'color: ' . $right_background_color_hex . ';';
    }

    if (!empty($right_text_color_hex)) {
      $right_item_attr .= 'background-color: ' . $right_text_color_hex . ';';
    }

    $right_css .= ' ' . $right_color . ' header-on-' . $right_header_position;

    $html .= '<div class="item popup-gallery item-right col-12 col-sm-6 ' . esc_attr($right_css) . '" style="' . esc_attr($right_item_attr) . '">';
    if (!empty($right_heading_num) || !empty($right_sub_heading_on_top) || !empty($right_heading) || !empty($right_sub_heading_on_bottom)) {
      $html .= '<div class="heading right">';
      $html .= '<div>';
      if (!empty($right_heading_num)) {
        $html .= '<div class="num">' . wp_kses_post($right_heading_num) . '</div>';
      }
      $html .= '<div class="text">';
      if (!empty($right_sub_heading_on_top)) {
        $html .= '<div class="s">' . wp_kses_post($right_sub_heading_on_top) . '</div>';
      }
      if (!empty($right_heading)) {
        $html .= '<div class="h">' . wp_kses_post($right_heading) . '</div>';
      }
      if (!empty($right_sub_heading_on_bottom)) {
        $html .= '<div class="d">' . wp_kses_post($right_sub_heading_on_bottom) . '</div>';
      }
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';
    }
    if (isset(wp_get_attachment_image_src($right_image, 'large')[0])) {
      $html .= '<div class="image popup-item">';
      if (!empty($right_video_url)) {
        $html .= '<a class="play-button web-application-icon-right-arrow-play-button" href="#" data-type="video" data-size="960x640" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="960" height="640" src="' . VideoUrlParser::get_url_embed($right_video_url) . '" frameborder="0" allowfullscreen></iframe></div></div>\'></a>';
      } else if(self::$g_array['image_on_popup'] == 'on') {
        self:: $g_array['index']++;
        $html .= '<a class="popup-link popup-single" href="' . esc_url($full_right_src[0]) . '" data-size="'.esc_attr($full_right_src[1].'x'.$full_right_src[2]).'" data-id="'.esc_attr(self:: $g_array['index']).'"></a>';
      }
      $html .= wp_kses_post(wp_get_attachment_image($right_image, 'large'));
      $html .= '</div>';
    }
    if (isset(vc_build_link($right_link)['url']) && !empty(vc_build_link($right_link)['url'])) {
      $right_link = vc_build_link($right_link);

      if (empty($right_link['target'])) {
        $right_link['target'] = '_self';
      }

      if (empty($right_link['title'])) {
        $right_link['title'] = esc_html__('Read more', 'novo');
      }
      $html .= '<div class="button"><a href="' . esc_url($right_link['url']) . '" class="button-style1 permalink" target="' . esc_attr($right_link['target']) . '">' . wp_kses_post($right_link['title']) . '</a></div>';
    }
    $html .= '</div>';
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Split_Screen_Type2();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Split_Screen_Type2 extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Split_Screen_Type2_Item extends WPBakeryShortCode {
  }
}
