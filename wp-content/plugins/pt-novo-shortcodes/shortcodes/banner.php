<?php

// Element Description: PT Banner

class PT_Banner extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_banner_mapping'));
    add_shortcode('pt_banner', array($this, 'pt_banner_html'));
    add_shortcode('pt_banner_item', array($this, 'pt_banner_item_html'));
  }

  public static function get_all_post_category($param = 'All') {
    $taxonomy = 'category';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    //$result[0] = $param;

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = get_category_parents($term->term_id);
        $name = trim($name, '/');
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }

  public static function get_all_pages() {
    $pages_array = get_pages();
    $result = array();

    if (!empty($pages_array) && !is_wp_error($pages_array)) {
      foreach ($pages_array as $page) {
        $result['ID [' . $page->ID . '] ' . $page->post_title] = $page->ID;
      }

      return $result;
    }
  }

  public static function get_all_portfolio_category($param = 'All') {
    $taxonomy = 'pt-portfolio-category';
    $args = array(
      'hide_empty' => true,
    );

    $terms = get_terms($taxonomy, $args);
    $result = array();
    //$result[0] = $param;

    if (!empty($terms) && !is_wp_error($terms)) {
      foreach ($terms as $term) {
        $name = $term->name;
        $result['ID [' . $term->term_id . '] ' . $name] = $term->term_id;
      }
    }

    return $result;
  }

  // Element Mapping
  public function pt_banner_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Banner", "novo"),
      "base" => "pt_banner",
      "as_parent" => array('only' => 'pt_banner_item'),
      "content_element" => true,
      "show_settings_on_create" => true,
      "is_container" => true,
      "icon" => "shortcode-icon-banner",
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "switch",
          "heading" => esc_html__("External indent", "novo"),
          "param_name" => "external_indent",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Infinite loop", "novo"),
          "param_name" => "infinite_loop",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Restart the slider automatically as it passes the last slide.", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Transition speed", "novo"),
          "param_name" => "speed",
          "value" => "300",
          "min" => "100",
          "max" => "10000",
          "step" => "100",
          "suffix" => "ms",
          "description" => esc_html__("Speed at which next slide comes.", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Autoplay Slides", "novo"),
          "param_name" => "autoplay",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Enable Autoplay", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
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
          "dependency" => Array("element" => "autoplay", "value" => array("on")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Pause on hover", "novo"),
          "param_name" => "pauseohover",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Pause the slider on hover", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "dependency" => Array("element" => "autoplay", "value" => "on"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Extra Class", "novo"),
          "param_name" => "el_class",
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Adaptive Height", "novo"),
          "param_name" => "adaptive_height",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Turn on Adaptive Height", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Height", "novo"),
          "param_name" => "height",
          "min" => "540",
          "max" => "1500",
          "step" => "10",
          "suffix" => "px",
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("About block", "novo"),
          "param_name" => "about_block",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Social buttons", "novo"),
          "param_name" => "social_buttons",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Social buttons color", "novo"),
          "param_name" => "social_buttons_color_hex",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Show categories", "novo"),
          "param_name" => "categories",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Default Color", "novo"),
          "param_name" => "default_color",
          "dependency" => Array("element" => "dots", "value" => array("on")),
          "value" => array(
            esc_html__("Inherit", "novo") => "inherit",
            esc_html__("White", "novo") => "white",
            esc_html__("Black", "novo") => "black",
            esc_html__("Custom", "novo") => "custom",
          ),
          "std" => 'inherit',
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Default Custom Color", "novo"),
          "param_name" => "default_color_hex",
          "dependency" => Array("element" => "default_color", "value" => array("custom")),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Animation", "pt-addons"),
          "param_name" => "animation",
          "value" => array(
            esc_html__("None", "pt-addons") => "",
            esc_html__("Slide Wave", "pt-addons") => "slide-wave",
            esc_html__("ZoomIn", "pt-addons") => "zoom-in",
            esc_html__("ZoomOut", "pt-addons") => "zoom-out",
          ),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Navigation Arrows", "novo"),
          "param_name" => "arrows",
          "value" => "on",
          "options" => array(
            "on" => array(
              "label" => esc_html__("Display next / previous navigation arrows", "novo"),
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Arrow Color", "novo"),
          "param_name" => "arrow_color",
          "dependency" => Array("element" => "arrows", "value" => array("on")),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Arrow position", "novo"),
          "param_name" => "arrows_position",
          "dependency" => Array("element" => "arrows", "value" => array("on")),
          "value" => array(
            esc_html__("Left Bottom", "novo") => "left-bottom",
            esc_html__("Right Bottom", "novo") => "right-bottom",
            esc_html__("Bottom", "novo") => "bottom",
          ),
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Pagination", "novo"),
          "param_name" => "dots",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "novo"),
              "off" => esc_html__("Off", "novo"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("Navigation", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Pagination position", "novo"),
          "param_name" => "dots_position",
          "dependency" => Array("element" => "dots", "value" => array("on")),
          "value" => array(
            esc_html__("Left", "novo") => "left",
            esc_html__("Left Outside", "novo") => "left-outside",
            esc_html__("Left Bottom", "novo") => "left-bottom",
            esc_html__("Bottom", "novo") => "bottom",
            esc_html__("Right Bottom", "novo") => "right-bottom",
            esc_html__("Right", "novo") => "right",
            esc_html__("Right Outside", "novo") => "right-outside",
          ),
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
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 1", "novo"),
          "param_name" => "social_link1",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 2", "novo"),
          "param_name" => "social_icon2",
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 2", "novo"),
          "param_name" => "social_link2",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 3", "novo"),
          "param_name" => "social_icon3",
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 3", "novo"),
          "param_name" => "social_link3",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Social icon 4", "novo"),
          "param_name" => "social_icon4",
          "value" => yprm_social_links_array(),
          "group" => esc_html__("Social links", "novo"),
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Social link 4", "novo"),
          "param_name" => "social_link4",
          "dependency" => Array("element" => "social_buttons", "value" => array("on")),
          "group" => esc_html__("Social links", "novo"),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Button label", "novo"),
          "param_name" => "about_label",
          "value" => "About",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_block", "value" => array("on")),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Type", "novo"),
          "param_name" => "about_type",
          "dependency" => Array("element" => "about_block", "value" => array("on")),
          "value" => array(
            esc_html__("Content", "novo") => "content",
            esc_html__("Custom link", "novo") => "custom_link",
          ),
          "group" => esc_html__("About block", "novo"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Custom link", "novo"),
          "param_name" => "about_link",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("custom_link")),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Show Bg Text", "pt-addons"),
          "param_name" => "about_show_bg_text",
          "value" => "on",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => true,
          "group" => esc_html__("About block", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("About image", "novo"),
          "param_name" => "about_image",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Sub Heading", "novo"),
          "param_name" => "about_sub_heading",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Heading", "novo"),
          "param_name" => "about_heading",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "textarea",
          "heading" => esc_html__("Text", "novo"),
          "param_name" => "about_text",
          "group" => esc_html__("About block", "novo"),
          'height' => 300,
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Read more link", "novo"),
          "param_name" => "about_read_more_link",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Sub Heading Color", "pt-addons"),
          "param_name" => "about_sub_heading_hex",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Heading Color", "pt-addons"),
          "param_name" => "about_heading_hex",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Text Color", "pt-addons"),
          "param_name" => "about_text_hex",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Button Color", "pt-addons"),
          "param_name" => "about_button_hex",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Button Hover Color", "pt-addons"),
          "param_name" => "about_button_hover_hex",
          "group" => esc_html__("About block", "novo"),
          "dependency" => Array("element" => "about_type", "value" => array("content")),
        ),
        array(
          "type" => "textfield",
          "heading" => esc_html__("Button label", "novo"),
          "param_name" => "categories_label",
          "value" => "Categories",
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories", "value" => array("on")),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Categories source", "novo"),
          "param_name" => "categories_source",
          "dependency" => Array("element" => "categories", "value" => array("on")),
          "value" => array(
            esc_html__("---", "novo") => "",
            esc_html__("Blog", "novo") => "blog",
            esc_html__("Portfolio", "novo") => "portfolio",
            esc_html__("Custom", "novo") => "custom",
            esc_html__("Custom link", "novo") => "custom_link",
          ),
          "group" => esc_html__("Category", "novo"),
        ),
        array(
          "type" => "switch",
          "heading" => esc_html__("Show Description", "pt-addons"),
          "param_name" => "categories_show_description",
          "value" => "off",
          "options" => array(
            "on" => array(
              "on" => esc_html__("On", "pt-addons"),
              "off" => esc_html__("Off", "pt-addons"),
            ),
          ),
          "default_set" => false,
          "dependency" => Array("element" => "categories_source", "value" => array("blog", "portfolio")),
          "group" => esc_html__("Category", "novo"),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Custom link", "novo"),
          "param_name" => "categories_link",
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories_source", "value" => array("custom_link")),
        ),
        array(
          "type" => "dropdown_multi",
          "heading" => esc_html__("Categories", "novo"),
          "param_name" => "categories_blog_items",
          "dependency" => Array("element" => "categories_source", "value" => array("blog")),
          "value" => PT_Banner::get_all_post_category(),
          "group" => esc_html__("Category", "novo"),
        ),
        array(
          "type" => "dropdown_multi",
          "heading" => esc_html__("Categories", "novo"),
          "param_name" => "categories_portfolio_items",
          "dependency" => Array("element" => "categories_source", "value" => array("portfolio")),
          "value" => PT_Banner::get_all_portfolio_category(),
          "group" => esc_html__("Category", "novo"),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("1 Category image", "novo"),
          "param_name" => "category_image1",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("1 Category link", "novo"),
          "param_name" => "category_link1",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("2 Category image", "novo"),
          "param_name" => "category_image2",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("2 Category link", "novo"),
          "param_name" => "category_link2",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("3 Category image", "novo"),
          "param_name" => "category_image3",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("3 Category link", "novo"),
          "param_name" => "category_link3",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("4 Category image", "novo"),
          "param_name" => "category_image4",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("4 Category link", "novo"),
          "param_name" => "category_link4",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("5 Category image", "novo"),
          "param_name" => "category_image5",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("5 Category link", "novo"),
          "param_name" => "category_link5",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("6 Category image", "novo"),
          "param_name" => "category_image6",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("6 Category link", "novo"),
          "param_name" => "category_link6",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "attach_image",
          "heading" => esc_html__("7 Category image", "novo"),
          "param_name" => "category_image7",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("7 Category link", "novo"),
          "param_name" => "category_link7",
          "group" => esc_html__("Category", "novo"),
          "edit_field_class" => 'vc_col-12 vc_col-sm-6',
          "dependency" => Array("element" => "categories_source", "value" => array("custom")),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Index Number Color", "pt-addons"),
          "param_name" => "categories_index_number_hex",
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories_source", "value" => array('blog', 'portfolio', 'custom', 'custom_link')),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Title Color", "pt-addons"),
          "param_name" => "categories_title_hex",
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories_source", "value" => array('blog', 'portfolio', 'custom', 'custom_link')),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Vertical Align", "pt-addons"),
          "param_name" => "categories_vertical_align",
          "value" => array(
            esc_html__("Top", "pt-addons") => "top",
            esc_html__("Middle", "pt-addons") => "middle",
            esc_html__("Bottom", "pt-addons") => "bottom",
          ),
          "std" => "bottom",
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories_source", "value" => array('blog', 'portfolio', 'custom', 'custom_link')),
        ),
        array(
          "type" => "dropdown",
          "heading" => esc_html__("Text Align", "pt-addons"),
          "param_name" => "categories_text_align",
          "value" => array(
            esc_html__("Left", "pt-addons") => "left",
            esc_html__("Center", "pt-addons") => "center",
            esc_html__("Right", "pt-addons") => "right",
          ),
          "std" => "left",
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories_source", "value" => array('blog', 'portfolio', 'custom', 'custom_link')),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Index Number Font Size", "pt-addons"),
          "param_name" => "categories_index_number_font_size",
          "suffix" => esc_html__("px", "pt-addons"),
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories_source", "value" => array('blog', 'portfolio', 'custom', 'custom_link')),
        ),
        array(
          "type" => "number",
          "heading" => esc_html__("Title Font Size", "pt-addons"),
          "param_name" => "categories_title_font_size",
          "suffix" => esc_html__("px", "pt-addons"),
          "group" => esc_html__("Category", "novo"),
          "dependency" => Array("element" => "categories_source", "value" => array('blog', 'portfolio', 'custom', 'custom_link')),
        ),
      ),
      "js_view" => 'VcColumnView',
    ));
    vc_map(array(
      "name" => esc_html__("Banner item", "novo"),
      "base" => "pt_banner_item",
      "content_element" => true,
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-banner",
      "as_child" => array('only' => 'pt_banner'),
      "params" => array_merge(
        array(
          yprm_vc_uniqid(),
          array(
            "type" => "attach_image",
            "heading" => esc_html__("Background image", "novo"),
            "param_name" => "image",
          ),
        ),
        yprm_vc_bg_video(),
        array(
          array(
            "type" => "switch",
            "heading" => esc_html__("Play video in lightbox", "pt-addons"),
            "param_name" => "play_in_lightbox",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => esc_html__("On", "pt-addons"),
                "off" => esc_html__("Off", "pt-addons"),
              ),
            ),
            "default_set" => false,
            "dependency" => Array("element" => "video_url", "not_empty" => true),
            "group" => esc_html__('Video', 'pt-addons')
          ),
          array(
            "type" => "textarea",
            "heading" => esc_html__("Sub Heading", "novo"),
            "param_name" => "sub_heading",
          ),
          array(
            "type" => "textarea",
            "heading" => esc_html__("Heading", "novo"),
            "param_name" => "heading",
            "admin_label" => true,
            "description" => wp_kses_post(__("Wrap the text in { } if you want the text to be another color.<br>Example: Minds your work {level}<br>If you want changes words:{Design||Work||Logo}", "pt-addons")),
          ),
          array(
            "type" => "textarea",
            "heading" => esc_html__("Text", "novo"),
            "param_name" => "text",
            "admin_label" => true,
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Link Button", "novo"),
            "param_name" => "link_button",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => esc_html__("On", "novo"),
                "off" => esc_html__("Off", "novo"),
              ),
            ),
            "default_set" => false,
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Play icon", "novo"),
            "param_name" => "link_play",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => esc_html__("On", "novo"),
                "off" => esc_html__("Off", "novo"),
              ),
            ),
            "default_set" => false,
            "dependency" => Array("element" => "link_button", "value" => "on"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Link Style", "pt-addons"),
            "param_name" => "link_style",
            "value" => array(
              esc_html__("Style 1", "pt-addons") => "style1",
              esc_html__("Style 2", "pt-addons") => "style2",
            ),
            "std" => "style1",
            "dependency" => Array("element" => "link_button", "value" => "on"),
          ),
          array(
            "type" => "vc_link",
            "heading" => esc_html__("Link", "novo"),
            "param_name" => "link",
            "dependency" => Array("element" => "link_button", "value" => "on"),
          ),
          array(
            "type" => "textfield",
            "heading" => esc_html__("Link text", "novo"),
            "param_name" => "link_text",
            "dependency" => Array("element" => "link_button", "value" => "on"),
          ),
          yprm_add_css_animation(false, 'Animation'),
          array(
            "type" => "switch",
            "heading" => esc_html__("Inner shadow", "novo"),
            "param_name" => "inner_shadow",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => esc_html__("On", "novo"),
                "off" => esc_html__("Off", "novo"),
              ),
            ),
            "default_set" => false,
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "switch",
            "heading" => esc_html__("Decor Elements", "novo"),
            "param_name" => "decor_elements",
            "value" => "off",
            "options" => array(
              "on" => array(
                "on" => esc_html__("On", "novo"),
                "off" => esc_html__("Off", "novo"),
              ),
            ),
            "default_set" => false,
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Color overlay", "novo"),
            "param_name" => "color_overlay",
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Text color", "novo"),
            "param_name" => "text_color",
            "value" => array(
              esc_html__("Black", "novo") => "black",
              esc_html__("White", "novo") => "white",
              esc_html__("Custom", "novo") => "custom",
            ),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Select Text color", "novo"),
            "param_name" => "text_color_hex",
            "dependency" => Array("element" => "text_color", "value" => "custom"),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Heading size", "novo"),
            "param_name" => "heading_size",
            "value" => array(
              esc_html__("H1", "novo") => "h1",
              esc_html__("H2", "novo") => "h2",
              esc_html__("H3", "novo") => "h3",
              esc_html__("H4", "novo") => "h4",
              esc_html__("H5", "novo") => "h5",
              esc_html__("H6", "novo") => "h6",
            ),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Heading style", "novo"),
            "param_name" => "heading_style",
            "value" => array(
              esc_html__("Default", "novo") => "default",
              esc_html__("With serial number", "novo") => "number",
              esc_html__("Decor line", "novo") => "decor-line",
            ),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Text align", "novo"),
            "param_name" => "text_align",
            "value" => array(
              esc_html__("Left", "novo") => "tal",
              esc_html__("Center", "novo") => "tac",
              esc_html__("Right", "novo") => "tar",
            ),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "dropdown",
            "heading" => esc_html__("Text vertical align", "novo"),
            "param_name" => "text_vertical_align",
            "value" => array(
              esc_html__("Top", "novo") => "top",
              esc_html__("Middle", "novo") => "middle",
              esc_html__("Bottom", "novo") => "bottom",
            ),
            "group" => esc_html__("Design", "novo"),
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Text color", "novo"),
            "param_name" => "button_text_color",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hover color", "novo"),
            "param_name" => "button_text_color_hover",
            "dependency" => Array("element" => "link_button", "value" => "on"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Border color", "novo"),
            "param_name" => "button_border_color",
            "dependency" => Array("element" => "link_style", "value" => "style1"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hover color", "novo"),
            "param_name" => "button_border_color_hover",
            "dependency" => Array("element" => "link_style", "value" => "style1"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Background color", "novo"),
            "param_name" => "button_bg_color",
            "dependency" => Array("element" => "link_style", "value" => "style1"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
          array(
            "type" => "colorpicker",
            "heading" => esc_html__("Hover color", "novo"),
            "param_name" => "button_bg_color_hover",
            "dependency" => Array("element" => "link_style", "value" => "style1"),
            "group" => esc_html__("Button customize", "novo"),
            "edit_field_class" => "vc_col-sm-6",
          ),
        )
      ),
    ));
  }

  // Element HTML
  public function pt_banner_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'external_indent' => 'off',
          'carousel_nav' => 'off',
          'infinite_loop' => 'on',
          'animation' => '',
          'speed' => '500',
          'autoplay' => 'on',
          'autoplay_speed' => '3000',
          'el_class' => '',
          'adaptive_height' => '',
          'default_color' => 'inherit',
          'default_color_hex' => '',
          'height' => '',
          'arrows' => 'on',
          'arrow_color' => '',
          'arrows_position' => 'left',
          'dots' => 'on',
          'dots_position' => 'left',
          'dots_color' => '',
          'pauseohover' => 'on',
          'about_block' => 'off',
          'social_buttons' => 'off',
          'social_buttons_color_hex' => '',
          'categories' => 'off',
          'social_icon1' => '',
          'social_link1' => '',
          'social_icon2' => '',
          'social_link2' => '',
          'social_icon3' => '',
          'social_link3' => '',
          'social_icon4' => '',
          'social_link4' => '',
          'about_label' => 'About',
          'about_type' => 'content',
          'about_show_bg_text' => 'on',
          'about_link' => '',
          'about_image' => '',
          'about_sub_heading' => '',
          'about_heading' => '',
          'about_text' => '',
          'about_read_more_link' => '',
          'about_shortcode_from_page' => '',
          'about_sub_heading_hex' => '',
          'about_heading_hex' => '',
          'about_text_hex' => '',
          'about_button_hex' => '',
          'about_button_hover_hex' => '',
          'categories_label' => 'Categories',
          'categories_source' => '',
          'categories_show_description' => 'off',
          'categories_link' => '',
          'categories_blog_items' => '',
          'categories_portfolio_items' => '',
          'category_image1' => '',
          'category_link1' => '',
          'category_image2' => '',
          'category_link2' => '',
          'category_image3' => '',
          'category_link3' => '',
          'category_image4' => '',
          'category_link4' => '',
          'category_image5' => '',
          'category_link5' => '',
          'category_image6' => '',
          'category_link6' => '',
          'category_image7' => '',
          'category_link7' => '',
          'categories_index_number_hex' => '',
          'categories_title_hex' => '',
          'categories_vertical_align' => 'bottom',
          'categories_text_align' => 'left',
          'categories_index_number_font_size' => '',
          'categories_title_font_size' => '',
        ),
        $atts
      )
    );

    $about_read_more_link = vc_build_link($about_read_more_link);
    if(is_array($about_read_more_link)) {
      if(!isset($about_read_more_link['title']) || empty($about_read_more_link['title'])) {
        $about_read_more_link['title'] = esc_html__('Read More', 'pt-addons');
      }
      if(!isset($about_read_more_link['target']) || empty($about_read_more_link['target'])) {
        $about_read_more_link['target'] = '_self';
      }
    }

    $id = 'banner-' . $uniqid;

    $banner_class = $id;
    $banner_class .= ' ' . $el_class;
    
    $animate_in = '';
    $animate_out = '';

    if($animation) {
      $banner_class .= ' animation-'.$animation;

      $animate_in = 'fadeIn';
      $animate_out = 'fadeOut';
    }

    $banner_style = "";

    if (!empty($height)) {
      $banner_class .= ' fixed-height';
      $banner_style = 'height:' . $height . 'px;';
    }

    $custom_css = "";

    if (isset($dots_color) && !empty($dots_color)) {
      $custom_css .= '.' . $id . ' .owl-dots {
          color: ' . $dots_color . ';
      }';
    }

    $custom_area_css = $area_id = "banner-area-" . $uniqid;
    if ($external_indent == 'on') {
      $custom_area_css .= " external-indent";
    }

    if ($default_color != 'custom') {
      $custom_area_css .= " banner-color-" . $default_color;
    } else {
      $custom_css .= '.' . $area_id . ' {
          color: ' . $default_color_hex . ';
      }';
    }

    if (isset($social_buttons_color_hex) && !empty($social_buttons_color_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-social-buttons {
          color: ' . $social_buttons_color_hex . ';
      }';
    }

    if (isset($autoplay_speed) && !empty($autoplay_speed)) {
      $custom_css .= '.' . $area_id . ' .banner-circle-nav .active svg {
        transition-duration: ' . $autoplay_speed . 'ms;
      }';
    }

    if (isset($categories_index_number_hex) && !empty($categories_index_number_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-categories .item a .num {
        color: ' . $categories_index_number_hex . ';
        opacity: 1;
      }';
    }

    if (isset($categories_title_hex) && !empty($categories_title_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-categories .item a .h {
        color: ' . $categories_title_hex . ';
      }';
    }

    if (isset($categories_index_number_font_size) && !empty($categories_index_number_font_size)) {
      $custom_css .= '.' . $area_id . ' .banner-categories .item a .num {
        font-size: ' . $categories_index_number_font_size . 'px;
      }';
    }

    if (isset($categories_title_font_size) && !empty($categories_title_font_size)) {
      $custom_css .= '.' . $area_id . ' .banner-categories .item a .h {
        font-size: ' . $categories_title_font_size . 'px;
      }';
    }

    if (isset($about_sub_heading_hex) && !empty($about_sub_heading_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-about .sub-h {
        color: ' . $about_sub_heading_hex . ';
      }';
    }

    if (isset($about_heading_hex) && !empty($about_heading_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-about .heading-decor {
        color: ' . $about_heading_hex . ';
      }';
    }

    if (isset($about_text_hex) && !empty($about_text_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-about .text-p {
        color: ' . $about_text_hex . ';
      }';
    }

    if (isset($about_button_hex) && !empty($about_button_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-about .button-style2:not(:hover) {
        color: ' . $about_button_hex . ';
      }';
    }

    if (isset($about_button_hover_hex) && !empty($about_button_hover_hex)) {
      $custom_css .= '.' . $area_id . ' .banner-about .button-style2:hover {
        color: ' . $about_button_hover_hex . ';
      }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    if ($infinite_loop == 'on') {
      $loop = 'true';
    } else {
      $loop = 'false';
    }
    if ($autoplay == 'on') {
      $autoplay = 'true';
    } else {
      $autoplay = 'false';
    }
    if ($arrows == 'on') {
      $arrows = 'true';
      $banner_class .= ' arrows-' . $arrows_position;
    } else {
      $arrows = 'false';
    }
    if ($dots == 'on') {
      $dots_js = 'true';
      $banner_class .= ' pagination-' . $dots_position;
    } else {
      $dots_js = 'false';
    }
    if ($pauseohover == 'on') {
      $pauseohover = 'true';
    } else {
      $pauseohover = 'false';
    }

    $carousel_js = '';

    if($dots == 'on' && $dots_position == 'bottom') {
      $custom_area_css .= ' with-circle-nav';
      $dots_js = 'false';

      $carousel_js = 'var circle_nav = head_slider.parent().find(".banner-circle-nav");

      slider_items.each(function(index) {
        circle_nav.append(\'<div class="item"><svg viewBox="0 0 34 34" version="1.1" xmlns="http://www.w3.org/2000/svg"><circle cx="17" cy="17" r="16"/></svg>\'+leadZero(index+1)+\'</div>\')
      });

      head_slider.on(\'changed.owl.carousel\', function(e){
        var current = e.item.index - (e.relatedTarget._clones.length / 2);

        if(slider_items.length == current) {
          current = 0;
        }

        circle_nav.find(\'.item\').eq(current).removeClass(\'active prev\').addClass(\'active\').nextAll().removeClass(\'active prev\');
        circle_nav.find(\'.item\').eq(current).prevAll().addClass(\'active prev\');
      });
      
      circle_nav.on("click", ".item", function() {
        var index = jQuery(this).index();
        head_slider.trigger("to.owl.carousel", index);
      });';
    }

    wp_enqueue_style('owl-carousel');
    wp_enqueue_script('owl-carousel');
    //wp_enqueue_script('novo-script', get_template_directory_uri() . '/js/scripts.js');

    wp_add_inline_script('novo-script', "jQuery(document).ready(function (jQuery) {
      jQuery('." . esc_attr($id) . "').each(function () {
        jQuery(this).on('initialize.owl.carousel', function (property) {
          jQuery(this).find('.item').each(function () {
            var num = leadZero(jQuery(this).index() + 1);
            jQuery(this).find('.num').text(num);
          });
        });
        var head_slider = jQuery(this),
        slider_items = head_slider.find('.item');
        if (head_slider.find('.item').length > 1) {
          head_slider.addClass('owl-carousel').owlCarousel({
            loop: " . esc_js($loop) . ",
            ".($animate_in != 'none' ? 'animateIn: \''.$animate_in.'\',' : '')."
            ".($animate_out != 'none' ? 'animateOut: \''.$animate_out.'\',' : '')."
            items: 1,
            nav: " . esc_js($arrows) . ",
            dots: " . esc_js($dots_js) . ",
            autoplay: " . esc_js($autoplay) . ",
            autoplayTimeout: " . esc_js($autoplay_speed) . ",
            autoplayHoverPause: " . esc_js($pauseohover) . ",
            smartSpeed: " . esc_js($speed) . ",
            navClass: ['owl-prev basic-ui-icon-left-arrow', 'owl-next basic-ui-icon-right-arrow'],
            navText: false,
            responsive: {
              0: {
                nav: false,
              },
              768: {
                nav: " . esc_js($arrows) . ",
              },
            },
            onInitialized: function(property) {
              var current = property.item.index,
              el = head_slider.find('.owl-item').eq(current);
              
              setTimeout(function() {
                el.siblings().find('.wpb_animate_when_almost_visible').removeClass('wpb_start_animation animated');
              }, 600);
            },
            onChanged: function(property) {
              var current = property.item.index,
              el = head_slider.find('.owl-item').eq(current);

              el.find('.wpb_animate_when_almost_visible').addClass('wpb_start_animation animated');

              setTimeout(function() {
                el.siblings().find('.wpb_animate_when_almost_visible').removeClass('wpb_start_animation animated');
              }, 600);
            },
          });

          head_slider.on('changed.owl.carousel translated.owl.carousel dragged.owl.carousel',function(property){
            var current = property.item.index;
            head_slider.find('.owl-item.active').each(function() {
              control_video(jQuery(this).find('.bg-overlay .video'), 'play');
            });
            head_slider.find('.owl-item:not(.active)').each(function() {
              control_video(jQuery(this).find('.bg-overlay .video'), 'pause');
            });
          });
    
          " . $carousel_js . "

        }
      });
    });");

    // Fill $html var with data
    $html = '<div class="banner-area ' . esc_attr($custom_area_css) . '">';
    
    if ($social_buttons == 'on') {
      $social_links_array = array();

      $flag = true;
      $a = 0;
      while ($a <= 4) {
        $a++;
        $s_type = 'social_icon' . $a;
        $s_link = 'social_link' . $a;

        if (!empty($$s_type) && !empty($$s_link)) {
          $flag = false;

          array_push($social_links_array, array(
            'type' => $$s_type,
            'url' => $$s_link,
          ));
        }
      }

      if ($flag) {
        $social_links_html = yprm_build_social_links('with-label');
      } else {
        $social_links_html = yprm_build_social_links('with-label', $social_links_array);
      }

      if(!empty($social_links_html)) {
        $html .= '<div class="banner-social-buttons">';
          $html .= '<div class="links">';
            $html .= $social_links_html;
          $html .= '</div>';
        $html .= '</div>';
      }
    }

    if ($categories == 'on') {
      if (!empty($categories_portfolio_items) || !empty($categories_blog_items) || !empty($category_image1) || !empty($category_image2) || !empty($category_image3) || !empty($category_image4) || !empty($category_image5) || !empty($category_image6) || !empty($category_image7)) {
        $banner_categories_css = 'vertical-align-'.$categories_vertical_align.' text-align-'.$categories_text_align;

        $html .= '<div class="banner-categories '.esc_attr($banner_categories_css).'">';
        if (!empty($categories_blog_items)) {
          foreach (explode(',', $categories_blog_items) as $item) {
            $id = $item;

            $term = get_term((int)$id, 'category');
            if(empty($term) || is_wp_error($term)) {
              continue;
            }

            $term_link = get_term_link((int)$id, 'category');

            $image = "";
            if (function_exists('get_field') && $cat_image_array = get_field('category_image', $term)) {
              $image = $cat_image_array['url'];
            }

            $description = '';
            if(!empty($term->description)) {
              $description = mb_strimwidth(strip_tags($term->description), 0, 120, '...');
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term->name) . '</span>'.(($categories_show_description == 'on' && $description) ? '<span class="desc">'.$description.'</span>' : '').'</span></a>';
            $html .= '</div>';
          }
        }
        if (!empty($categories_portfolio_items)) {
          foreach (explode(',', $categories_portfolio_items) as $item) {
            $id = $item;

            $term = get_term((int)$id, 'pt-portfolio-category');
            if(empty($term) || is_wp_error($term)) {
              continue;
            }
            
            $term_link = get_term_link((int)$id, 'pt-portfolio-category');

            $image = "";
            if (function_exists('get_field') && $cat_image_array = get_field('category_image', $term)) {
              $image = $cat_image_array['url'];
            }

            $description = '';
            if(!empty($term->description)) {
              $description = mb_strimwidth(strip_tags($term->description), 0, 120, '...');
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term->name) . '</span>'.(($categories_show_description == 'on' && $description) ? '<span class="desc">'.$description.'</span>' : '').'</span></a>';
            $html .= '</div>';
          }
        }
        if (!empty($category_image1) || !empty($category_image2) || !empty($category_image3) || !empty($category_image4) || !empty($category_image5) || !empty($category_image6) || !empty($category_image7)) {
          if (!empty($category_image1) && !empty($category_link1)) {
            $term_link = vc_build_link($category_link1);

            if (empty($term_link['target'])) {
              $term_link['target'] = '_self';
            }

            $image = "";
            if (isset(wp_get_attachment_image_src($category_image1, 'full')[0]) && !empty(wp_get_attachment_image_src($category_image1, 'full')[0])) {
              $image = wp_get_attachment_image_src($category_image1, 'full')[0];
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link['url']) . '" target="' . esc_attr($term_link['target']) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term_link['title']) . '</span></span></a>';
            $html .= '</div>';
          }
          if (!empty($category_image2) && !empty($category_link2)) {
            $term_link = vc_build_link($category_link2);

            if (empty($term_link['target'])) {
              $term_link['target'] = '_self';
            }

            $image = "";
            if (isset(wp_get_attachment_image_src($category_image2, 'full')[0]) && !empty(wp_get_attachment_image_src($category_image2, 'full')[0])) {
              $image = wp_get_attachment_image_src($category_image2, 'full')[0];
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link['url']) . '" target="' . esc_attr($term_link['target']) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term_link['title']) . '</span></span></a>';
            $html .= '</div>';
          }
          if (!empty($category_image3) && !empty($category_link3)) {
            $term_link = vc_build_link($category_link3);

            if (empty($term_link['target'])) {
              $term_link['target'] = '_self';
            }

            $image = "";
            if (isset(wp_get_attachment_image_src($category_image3, 'full')[0]) && !empty(wp_get_attachment_image_src($category_image3, 'full')[0])) {
              $image = wp_get_attachment_image_src($category_image3, 'full')[0];
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link['url']) . '" target="' . esc_attr($term_link['target']) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term_link['title']) . '</span></span></a>';
            $html .= '</div>';
          }
          if (!empty($category_image4) && !empty($category_link4)) {
            $term_link = vc_build_link($category_link4);

            if (empty($term_link['target'])) {
              $term_link['target'] = '_self';
            }

            $image = "";
            if (isset(wp_get_attachment_image_src($category_image4, 'full')[0]) && !empty(wp_get_attachment_image_src($category_image4, 'full')[0])) {
              $image = wp_get_attachment_image_src($category_image4, 'full')[0];
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link['url']) . '" target="' . esc_attr($term_link['target']) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term_link['title']) . '</span></span></a>';
            $html .= '</div>';
          }
          if (!empty($category_image5) && !empty($category_link5)) {
            $term_link = vc_build_link($category_link5);

            if (empty($term_link['target'])) {
              $term_link['target'] = '_self';
            }

            $image = "";
            if (isset(wp_get_attachment_image_src($category_image5, 'full')[0]) && !empty(wp_get_attachment_image_src($category_image5, 'full')[0])) {
              $image = wp_get_attachment_image_src($category_image5, 'full')[0];
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link['url']) . '" target="' . esc_attr($term_link['target']) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term_link['title']) . '</span></span></a>';
            $html .= '</div>';
          }
          if (!empty($category_image6) && !empty($category_link6)) {
            $term_link = vc_build_link($category_link6);

            if (empty($term_link['target'])) {
              $term_link['target'] = '_self';
            }

            $image = "";
            if (isset(wp_get_attachment_image_src($category_image6, 'full')[0]) && !empty(wp_get_attachment_image_src($category_image6, 'full')[0])) {
              $image = wp_get_attachment_image_src($category_image6, 'full')[0];
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link['url']) . '" target="' . esc_attr($term_link['target']) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term_link['title']) . '</span></span></a>';
            $html .= '</div>';
          }
          if (!empty($category_image7) && !empty($category_link7)) {
            $term_link = vc_build_link($category_link7);

            if (empty($term_link['target'])) {
              $term_link['target'] = '_self';
            }

            $image = "";
            if (isset(wp_get_attachment_image_src($category_image7, 'full')[0]) && !empty(wp_get_attachment_image_src($category_image7, 'full')[0])) {
              $image = wp_get_attachment_image_src($category_image7, 'full')[0];
            }

            $html .= '<div class="item">';
            $html .= '<a href="' . esc_url($term_link['url']) . '" target="' . esc_attr($term_link['target']) . '" style="background-image: url(' . esc_url($image) . ');"><span><span class="num"></span><span class="h">' . esc_html($term_link['title']) . '</span></span></a>';
            $html .= '</div>';
          }
        }
        $html .= '</div>';

        wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
          jQuery('.banner-area-" . $uniqid . " .banner-categories').each(function () {
            jQuery(this).on('initialize.owl.carousel', function (property) {
              jQuery(this).find('.item').each(function () {
                var num = leadZero(jQuery(this).index() + 1);
                jQuery(this).find('.num').text(num);
              });
            });
            
            if (jQuery(this).find('.item').length > 1) {
              if (jQuery(this).find('.item').length > 4) {
                var count = 4;
                var mob = 2;
                var table = 3;
              } else {
                var count = jQuery(this).find('.item').length;
                var mob = 2;
                var table = 2;
              }
              jQuery(this).addClass('owl-carousel').owlCarousel({
                loop: true,
                items: 1,
                nav: true,
                dots: false,
                autoplay: false,
                navClass: ['owl-prev basic-ui-icon-left-arrow', 'owl-next basic-ui-icon-right-arrow'],
                navText: false,
                responsive: {
                  0: {
                    nav: false,
                  },
                  480: {
                    items: 1
                  },
                  768: {
                    nav: true,
                    items: mob
                  },
                  980: {
                    items: table
                  },
                  1200: {
                    items: count
                  },
                },
              });
            }
            });
          });
        ");
      }
    }

    if ($about_block == 'on' && ($about_type == 'content' || $about_type == 'shortcode_from_page')) {
      $html .= '<div class="banner-about '.esc_attr($about_type).'">';
      $html .= '<div class="row">';
      if (isset(wp_get_attachment_image_src($about_image, 'full')[0])) {
        $html .= '<div class="image col-12 col-md-6" style="background-image: url(' . esc_url(wp_get_attachment_image_src($about_image, 'full')[0]) . ')"></div>';
        $html .= '<div class="text col-12 col-md-6">';
      } else {
        $html .= '<div class="text col-12">';
      }
      $html .= '<div class="wrap">';
      $html .= '<div class="cell">';
      if (isset(wp_get_attachment_image_src($about_image, 'full')[0])) {
        $html .= '<div class="image" style="background-image: url(' . esc_url(wp_get_attachment_image_src($about_image, 'full')[0]) . ')"></div>';
      }
      if (!empty($about_sub_heading)) {
        $html .= '<div class="sub-h">' . wp_kses($about_sub_heading, 'post') . '</div>';
      }
      if (!empty($about_heading)) {
        $html .= '<div class="heading-decor"><h3>' . yprm_heading_filter($about_heading) . '</h3></div>';
      }
      if (!empty($about_text)) {
        $html .= '<div class="text-p">' . wp_kses(wp_unslash($about_text), 'post') . '</div>';
      }
      if (is_array($about_read_more_link) && isset($about_read_more_link['url']) && !empty($about_read_more_link['url'])) {
        $html .= '<a href="' . esc_url($about_read_more_link['url']) . '" class="button-style2" target="'.$about_read_more_link['target'].'">' . $about_read_more_link['title'] . '</a>';
      }
      $html .= '</div>';
      $html .= '</div>';
      if($about_show_bg_text == 'on') {
        $html .= '<div class="bg-word">'.($about_label ? $about_label : esc_html__('About', 'pt-addons')).'</div>';
      }
      $html .= '</div>';
      $html .= '</div>';
      $html .= '</div>';
    }

    if ($categories == 'on' || $about_block == 'on') {
      $html .= '<div class="banner-right-buttons">';
      $html .= '<div class="cell">';
      if ($categories == 'on' && (!empty($categories_portfolio_items) || !empty($categories_blog_items) || !empty($category_image1) || !empty($category_image2) || !empty($category_image3) || !empty($category_image4) || !empty($category_image5) || !empty($category_image6) || !empty($category_image7))) {
        if (empty($categories_label)) {
          $categories_label = esc_html__('Categories', 'novo');
        }
        $html .= '<div class="button category"><span class="h">' . esc_html($categories_label) . '</span><span class="close"><i class="basic-ui-icon-cancel"></i>' . (($close_l = yprm_get_theme_setting('tr_close')) ? $close_l : esc_html__('Close', 'novo')) . '</span></div>';
      } elseif ($categories == 'on' && $categories_source == 'custom_link') {
        if (empty($categories_label)) {
          $categories_label = esc_html__('Categories', 'novo');
        }

        $categories_link = vc_build_link($categories_link);
        if (empty($categories_link['target'])) {
          $categories_link['target'] = '_self';
        }

        $html .= '<a href="' . esc_url($categories_link['url']) . '" target="' . esc_attr($categories_link['target']) . '" class="button category"><span class="h">' . esc_html($categories_label) . '</span></a>';
      }
      if ($about_block == 'on') {
        if (empty($about_label)) {
          $about_label = esc_html__('About', 'novo');
        }
        if ($about_type == 'content' || $about_type == 'shortcode_from_page') {
          $html .= '<div class="button about"><span class="h">' . esc_html($about_label) . '</span><span class="close"><i class="basic-ui-icon-cancel"></i>' . (($close_l = yprm_get_theme_setting('tr_close')) ? $close_l : esc_html__('Closed', 'novo')) . '</span></div>';
        } else {
          $about_link = vc_build_link($about_link);
          if (empty($about_link['target'])) {
            $about_link['target'] = '_self';
          }

          $html .= '<a href="' . esc_url($about_link['url']) . '" target="' . esc_attr($about_link['target']) . '" class="button about"><span class="h">' . esc_html($about_label) . '</span></a>';
        }
      }
      $html .= '</div>';
      $html .= '</div>';
    }

    $html .= '<div class="banner ' . esc_attr($banner_class) . '" style="' . $banner_style . '">';
    $html .= do_shortcode($content);
    $html .= '</div>';
    if($dots == 'on' && $dots_position == 'bottom') {
      $html .= '<div class="banner-circle-nav container"></div>';
    }
    $html .= '</div>';

    return $html;

  }

  // Element HTML
  public function pt_banner_item_html($atts) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'image' => '',
          'video_url' => '',
          'play_in_lightbox' => 'off',
          'sub_heading' => '',
          'heading' => '',
          'text' => '',
          'css_animation' => '',
          'link_button' => '',
          'link_style' => 'style1',
          'link' => '',
          'link_play' => 'off',
          'link_text' => '',
          'inner_shadow' => 'off',
          'decor_elements' => 'off',
          'color_overlay' => '',
          'heading_size' => 'h1',
          'heading_style' => 'default',
          'text_align' => 'tal',
          'text_vertical_align' => 'top',
          'text_color' => 'black',
          'text_color_hex' => '',
          'button_text_color' => '',
          'button_text_color_hover' => '',
          'button_border_color' => '',
          'button_border_color_hover' => '',
          'button_bg_color' => '',
          'button_bg_color_hover' => '',
        ),
        $atts
      )
    );

    // Fill $html var with data
    $item_attr = $animation = $image_animation_attr = "";

    if(!empty($css_animation)) {
      $animation = ' '.yprm_get_animation_css($css_animation);
    }

    if (isset(wp_get_attachment_image_src($image, 'full')[0])) {
      $item_attr = 'background-image: url(' . esc_url(wp_get_attachment_image_src($image, 'full')[0]) . ')';
    }

    $heading_html = '';
    $text_html = '';
    $link_html = '';
    $custom_css = '';
    $decor_elements_html = '';
    $item_class = $item_id = 'banner-item-' . $uniqid;

    if(!empty($heading) && $words_array = yprm_get_string_from($heading, '{', '}')) {
      $words = array();
      foreach(explode('||', $words_array) as $word_item) {
        $words[] = $word_item;
      }
      if(count($words) > 1){
        $new_string = '<span class="words" data-array="'.yprm_implode($words, '', ',').'"></span>';

        $heading = str_replace('{'.$words_array.'}', $new_string, $heading);

        wp_enqueue_script('typed');
      }
    }

    if ($heading_style == 'number') {
      $heading_html = '<div class="heading-with-num-type2">
        <div class="top">
          <div class="num"></div>
          '.($sub_heading ? '<div class="sub-h">'.$sub_heading.'</div>' : '' ).'
        </div>
        <' . $heading_size . ' class="h">' . yprm_heading_filter($heading) . '</' . $heading_size . '>
      </div>';
    } elseif ($heading_style == 'decor-line') {
      $heading_html = '<div class="heading-decor">
        '.($sub_heading ? '<div class="sub-h">'.$sub_heading.'</div>' : '' ).'
        <' . $heading_size . ' class="h">' . yprm_heading_filter($heading) . '</' . $heading_size . '>
      </div>';
    } else {
      $heading_html = '<div class="heading">
        '.($sub_heading ? '<div class="sub-h">'.$sub_heading.'</div>' : '' ).'
        <' . $heading_size . ' class="h">' . yprm_heading_filter($heading) . '</' . $heading_size . '>
      </div>';
    }

    if ($text) {
      $text_html = '<div class="text">' . wp_kses($text, 'post') . '</div>';
    }

    $play_button_html = '';
    if(!empty($video_url) && $play_in_lightbox == 'on') {
      $embed = VideoUrlParser::get_url_embed($video_url);
      $play_button_html = '<div class="play-button-block popup-gallery images"><a href="#" data-type="video" data-size="1280x768" data-video=\'<div class="wrapper"><div class="video-wrapper"><iframe class="pswp__video" width="1920" height="1080" src="' . esc_url($embed) . '" frameborder="0" allowfullscreen></iframe></div></div>\'><i class="music-and-multimedia-play-button"></i></a></div>';
    }

    $video_html = '';
    if (empty($play_button_html) && $bg_overlay = yprm_build_bg_overlay($atts, $item_id)) { 
      $video_html = $bg_overlay;
    }

    $link = vc_build_link($link)['url'];

    if ($link_button == 'on' && !empty($link) && !empty($link_text)) {
      $link_html = '<a href="' . esc_url($link) . '" class="button-'.esc_attr($link_style).'">';
      if ($link_play == 'on') {
        $link_html .= '<i class="multimedia-icon-play"></i>';
      }
      $link_html .= '<span>' . esc_html($link_text) . '</span>';
      $link_html .= '</a>';

      if (!empty($button_text_color) || !empty($button_border_color) || !empty($button_bg_color)) {
        $custom_css .= '.' . $item_id . ' .button-'.$link_style.' {';
        if (!empty($button_text_color)) {
          $custom_css .= 'color: ' . $button_text_color . ' !important;';
        }
        if (!empty($button_border_color)) {
          $custom_css .= 'border-color: ' . $button_border_color . ' !important;';
        }
        if (!empty($button_bg_color)) {
          $custom_css .= 'background-color: ' . $button_bg_color . ' !important;';
        }
        $custom_css .= '}';
      }

      if (!empty($button_text_color_hover) || !empty($button_border_color_hover) || !empty($button_bg_color_hover)) {
        $custom_css .= '.' . $item_id . ' .button-'.$link_style.':hover {';
        if (!empty($button_text_color_hover)) {
          $custom_css .= 'color: ' . $button_text_color_hover . ' !important;';
        }
        if (!empty($button_border_color_hover)) {
          $custom_css .= 'border-color: ' . $button_border_color_hover . ' !important;';
        }
        if (!empty($button_bg_color_hover)) {
          $custom_css .= 'background-color: ' . $button_bg_color_hover . ' !important;';
        }
        $custom_css .= '}';
      }
    }

    if (!empty($color_overlay)) {
      $custom_css .= '.' . $item_id . ':after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1;
        background-color: ' . $color_overlay . ';
        pointer-events: none;
      }';
    }

    $item_class .= ' ' . $text_align;

    if ($inner_shadow == 'on') {
      $item_class .= ' with-shadow';
    }

    if (isset($text_color) && $text_color != 'custom') {
      $item_class .= ' ' . $text_color;
    }

    if (isset($text_color) && $text_color == 'custom') {
      $custom_css .= '.' . $item_id . ' {
        color: ' . $text_color_hex . ';
      }';
    }

    wp_enqueue_style('novo-custom-style', get_template_directory_uri() . '/css/custom_script.css');
    wp_add_inline_style('novo-custom-style', $custom_css);

    if($decor_elements == 'on') {
      $decor_elements_html = '<div class="banner-decor-elements"><div></div><div></div><div></div><div></div></div>';
    }


    $html = '<div class="item ' . esc_attr($item_class) . '">
      <div class="bg-image" style="' . esc_attr($item_attr) . '"></div>
      ' . $video_html . '
      ' . $decor_elements_html . '
      <div class="container">
        <div class="cell ' . esc_attr($text_vertical_align.$animation) . '">
          ' . wp_kses($heading_html, 'post') . '
          ' . wp_kses($text_html, 'post') . '
          ' . wp_kses($link_html, 'post') . '
          ' . $play_button_html . '
        </div>
      </div>
    </div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Banner();
if (class_exists('WPBakeryShortCodesContainer')) {
  class WPBakeryShortCode_PT_Banner extends WPBakeryShortCodesContainer {
  }
}
if (class_exists('WPBakeryShortCode')) {
  class WPBakeryShortCode_PT_Banner_Item extends WPBakeryShortCode {
  }
}
