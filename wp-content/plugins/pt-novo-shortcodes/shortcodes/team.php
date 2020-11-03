<?php

// Element Description: PT Team

class PT_Team extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_team_mapping'));
    add_shortcode('pt_team', array($this, 'pt_team_html'));
    add_shortcode('pt_team_item', array($this, 'pt_team_item_html'));
  }

  // Element Mapping
  public function pt_team_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Team", "novo"),
      "base" => "pt_team",
      "as_parent" => array('only' => 'pt_team_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-team",
      "is_container" => true,
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        array(
          "type" => "el_id",
          "heading" => esc_html__("Uniq ID", "novo"),
          "param_name" => "uniqid",
          "value" => uniqid(),
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Carousel", "novo"),
          "param_name" => "carousel",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("General", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Desktop", "novo"),
          "param_name" => "desktop_cols",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '3',
          "group" => esc_html__("Cols", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Tablet", "novo"),
          "param_name" => "tablet_cols",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '2',
          "group" => esc_html__("Cols", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Mobile", "novo"),
          "param_name" => "mobile_cols",
          "value" => array(
            esc_html__("Col 1", "novo") => "1",
            esc_html__("Col 2", "novo") => "2",
            esc_html__("Col 3", "novo") => "3",
            esc_html__("Col 4", "novo") => "4",
          ),
          "std" => '1',
          "group" => esc_html__("Cols", "novo"),
        ),
        array(
          "type" => "number",
          "class" => "",
          "heading" => esc_html__("Transition speed", "novo"),
          "param_name" => "speed",
          "value" => "300",
          "min" => "100",
          "max" => "10000",
          "step" => "100",
          "suffix" => "ms",
          "dependency" => Array("element" => "carousel", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Autoplay Slides", "novo"),
          "param_name" => "autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Enable Autoplay", "novo"),
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "dependency" => "",
          "default_set" => true,
          "dependency" => Array("element" => "carousel", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Autoplay Speed", "novo"),
          "param_name" => "autoplay_speed",
          "value" => "5000",
          "min" => "100",
          "max" => "10000",
          "step" => "10",
          "suffix" => "ms",
          "dependency" => Array("element" => "carousel", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
        ),
        array(
          "type" => "switch",
          "class" => "",
          "heading" => esc_html__("Navigation Arrows", "novo"),
          "param_name" => "arrows",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Display next / previous navigation arrows", "novo"),
              "on" => "On",
              "off" => "Off",
            ),
          ),
          "default_set" => true,
          "dependency" => Array("element" => "carousel", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Arrow Color", "novo"),
          "param_name" => "arrow_color",
          "dependency" => Array("element" => "arrows", "value" => array("on")),
          "group" => esc_html__("Carousel settings", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Pause on hover", "novo"),
          "param_name" => "pauseohover",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Pause the slider on hover", "novo"),
              "on" => "Yes",
              "off" => "No",
            ),
          ),
          "dependency" => Array("element" => "autoplay", "value" => "on"),
          "group" => esc_html__("Carousel settings", "novo"),
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Team item", "novo"),
      "base" => "pt_team_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-team",
      "as_child" => array('only' => 'pt_team'),
      "params" => array(
        array(
          "type" => "attach_image",
          "heading" => esc_html__("Image", "novo"),
          "param_name" => "image",
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Name", "novo"),
          "param_name" => "name",
          "admin_label" => true,
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Post", "novo"),
          "param_name" => "post",
          "admin_label" => true,
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 1", "novo"),
          "edit_field_class" => "vc_col-xs-6",
          "param_name" => "social_icon_1",
          "value" => array(
            esc_html__('---', 'novo') => "",
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
          ),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 1", "novo"),
          "edit_field_class" => "vc_col-xs-6",
          "param_name" => "social_link_1",
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 2", "novo"),
          "edit_field_class" => "vc_col-xs-6",
          "param_name" => "social_icon_2",
          "value" => array(
            esc_html__('---', 'novo') => "",
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
          ),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 2", "novo"),
          "edit_field_class" => "vc_col-xs-6",
          "param_name" => "social_link_2",
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 3", "novo"),
          "edit_field_class" => "vc_col-xs-6",
          "param_name" => "social_icon_3",
          "value" => array(
            esc_html__('---', 'novo') => "",
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
          ),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 3", "novo"),
          "edit_field_class" => "vc_col-xs-6",
          "param_name" => "social_link_3",
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_team_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'carousel' => 'on',
          'speed' => '500',
          'autoplay' => 'on',
          'autoplay_speed' => '3000',
          'arrows' => 'on',
          'arrow_color' => '',
          'pauseohover' => 'on',
          'desktop_cols' => '3',
          'tablet_cols' => '2',
          'mobile_cols' => '1',
          'social_buttons_text_color' => '',
        ),
        $atts
      )
    );

    $item_class = $id = 'team-' . $uniqid;

    $custom_css = "";

    if (isset($arrow_color) && !empty($arrow_color)) {
      $custom_css .= '.' . $id . ' .owl-nav {
                color: ' . $arrow_color . ';
            }';
    }

    if (isset($social_buttons_text_color) && !empty($social_buttons_text_color)) {
      $custom_css .= '.' . $id . ' .team-social-buttons {
                color: ' . $social_buttons_text_color . ';
            }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    if ($carousel == "on") {
      if ($autoplay == 'on') {
        $autoplay = 'true';
      } else {
        $autoplay = 'false';
      }
      if ($arrows == 'on') {
        $arrows = 'true';
      } else {
        $arrows = 'false';
      }
      if ($pauseohover == 'on') {
        $pauseohover = 'true';
      } else {
        $pauseohover = 'false';
      }

      wp_enqueue_style('owl-carousel');
      wp_enqueue_script('owl-carousel');
      wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');

      wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
                jQuery('." . esc_attr($id) . "').each(function(){
                    var head_slider = jQuery(this);
                    if(jQuery(this).find('.item').length > 1){
                        head_slider.addClass('owl-carousel').owlCarousel({
                            loop:true,
                            items:1,
                            nav: " . esc_js($arrows) . ",
                            dots: false,
                            autoplay: " . esc_js($autoplay) . ",
                            autoplayTimeout: " . esc_js($autoplay_speed) . ",
                            autoplayHoverPause: " . esc_js($pauseohover) . ",
                            smartSpeed: " . esc_js($speed) . ",
                            navClass: ['owl-prev basic-ui-icon-left-arrow','owl-next basic-ui-icon-right-arrow'],
                            navText: false,
                            margin: 30,
                            responsive:{
                                0:{
                                    nav: false,
                                    items: 1,
                                },
                                768:{
                                    nav: " . esc_js($arrows) . ",
                                    items: " . esc_js($mobile_cols) . ",
                                },
                                980:{
                                    items: " . esc_js($tablet_cols) . ",
                                },
                                1200:{
                                    items: " . esc_js($desktop_cols) . ",
                                },
                            },
                        });
                    }
                });
            });");
    }

    if (!empty($content)) {
      $content = str_replace('[pt_team_item ', '[pt_team_item carousel="' . $carousel . '" desktop_cols="' . $desktop_cols . '" tablet_cols="' . $tablet_cols . '" mobile_cols="' . $mobile_cols . '" ', $content);
    }

    // Fill $html var with data
    $html = '<div class="team-items row ' . esc_attr($item_class) . '">';
    $html .= do_shortcode($content);
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_team_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'image' => '',
          'name' => '',
          'post' => '',
          'social_icon_1' => '',
          'social_link_1' => '',
          'social_icon_2' => '',
          'social_link_2' => '',
          'social_icon_3' => '',
          'social_link_3' => '',
          'carousel' => 'on',
          'desktop_cols' => '3',
          'tablet_cols' => '2',
          'mobile_cols' => '1',
        ),
        $atts
      )
    );

    // Fill $html var with data

    $link = '';
    $social_buttons_html = '';
    $item_class = $item_id = 'team-item-' . uniqid();

    if ((!empty($social_icon_1) && !empty($social_link_1)) || (!empty($social_icon_2) && !empty($social_link_2)) || (!empty($social_icon_3) && !empty($social_link_3))) {
      $social_buttons_html = '<div class="team-social-buttons">';

      if (!empty($social_icon_1) && !empty($social_link_1)) {
        $array = explode(',', $social_icon_1);
        $social_buttons_html .= '<a href="' . esc_url($social_link_1) . '" target="_blank"><i class="' . esc_attr($array[0]) . '"></i></a>';
      }
      if (!empty($social_icon_2) && !empty($social_link_2)) {
        $array = explode(',', $social_icon_2);
        $social_buttons_html .= '<a href="' . esc_url($social_link_2) . '" target="_blank"><i class="' . esc_attr($array[0]) . '"></i></a>';
      }
      if (!empty($social_icon_3) && !empty($social_link_3)) {
        $array = explode(',', $social_icon_3);
        $social_buttons_html .= '<a href="' . esc_url($social_link_3) . '" target="_blank"><i class="' . esc_attr($array[0]) . '"></i></a>';
      }

      $social_buttons_html .= '</div>';
    }

    if ($carousel != 'on') {
      $item_class .= ' col-xs-' . (12 / $mobile_cols) . ' col-sm-' . (12 / $tablet_cols) . ' col-md-' . (12 / $desktop_cols);
    }

    $html = '<div class="team-item item ' . esc_attr($item_class) . '">';
    $html .= '<div class="wrap">';
    if (!empty($image)) {
      $html .= '<div class="image" style="background-image: url(' . wp_get_attachment_image_src($image, 'full')[0] . ')"><div>' . wp_kses($social_buttons_html, 'post') . '</div></div>';
    }
    if (!empty($name)) {
      $html .= '<div class="name">' . wp_kses($name, 'post') . '</div>';
    }
    if (!empty($post)) {
      $html .= '<div class="post">' . wp_kses($post, 'post') . '</div>';
    }
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Team();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Team extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Team_Item extends WPBakeryShortCode {
  }
}
