<?php

// Element Description: PT Photo Carousel

class PT_Photo_Carousel extends WPBakeryShortCode {

  // Element Init
  public function __construct() {
    add_action('init', array($this, 'pt_photo_carousel_mapping'));
    add_shortcode('pt_photo_carousel', array($this, 'pt_photo_carousel_html'));
  }

  // Element Mapping
  public function pt_photo_carousel_mapping() {

    // Stop all if VC is not enabled
    if (!defined('WPB_VC_VERSION')) {
      return;
    }

    // Map the block with vc_map()
    vc_map(array(
      "name" => esc_html__("Photo Carousel", "novo"),
      "base" => "pt_photo_carousel",
      "show_settings_on_create" => true,
      "icon" => "shortcode-icon-photo-carousel",
      "category" => esc_html__("Novo Shortcodes", "novo"),
      "params" => array(
        yprm_vc_uniqid(),
        array(
          "type" => "attach_images",
          "heading" => esc_html__("Images", "novo"),
          "param_name" => "images",
        ),
        array(
          'type' => 'dropdown',
          'heading' => esc_html__('Icon library', 'novo'),
          'value' => array(
            esc_html__('Font Awesome', 'novo') => 'fontawesome',
            esc_html__('Open Iconic', 'novo') => 'openiconic',
            esc_html__('Typicons', 'novo') => 'typicons',
            esc_html__('Entypo', 'novo') => 'entypo',
            esc_html__('Linecons', 'novo') => 'linecons',
            esc_html__('Mono Social', 'novo') => 'monosocial',
            esc_html__('Material', 'novo') => 'material',
          ),
          'admin_label' => true,
          'param_name' => 'type',
          'description' => esc_html__('Select icon library.', 'novo'),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__('Icon', 'novo'),
          'param_name' => 'icon_fontawesome',
          'value' => 'fa fa-adjust',
          'settings' => array(
            'emptyIcon' => false,
            'iconsPerPage' => 4000,
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'fontawesome',
          ),
          'description' => esc_html__('Select icon from library.', 'novo'),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__('Icon', 'novo'),
          'param_name' => 'icon_openiconic',
          'value' => 'vc-oi vc-oi-dial',
          'settings' => array(
            'emptyIcon' => false,
            'type' => 'openiconic',
            'iconsPerPage' => 4000,
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'openiconic',
          ),
          'description' => esc_html__('Select icon from library.', 'novo'),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__('Icon', 'novo'),
          'param_name' => 'icon_typicons',
          'value' => 'typcn typcn-adjust-brightness',
          'settings' => array(
            'emptyIcon' => false,
            'type' => 'typicons',
            'iconsPerPage' => 4000,
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'typicons',
          ),
          'description' => esc_html__('Select icon from library.', 'novo'),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__('Icon', 'novo'),
          'param_name' => 'icon_entypo',
          'value' => 'entypo-icon entypo-icon-note',
          'settings' => array(
            'emptyIcon' => false,
            'type' => 'entypo',
            'iconsPerPage' => 4000,
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'entypo',
          ),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__('Icon', 'novo'),
          'param_name' => 'icon_linecons',
          'value' => 'vc_li vc_li-heart',
          'settings' => array(
            'emptyIcon' => false,
            'type' => 'linecons',
            'iconsPerPage' => 4000,
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'linecons',
          ),
          'description' => esc_html__('Select icon from library.', 'novo'),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__('Icon', 'novo'),
          'param_name' => 'icon_monosocial',
          'value' => 'vc-mono vc-mono-fivehundredpx',
          'settings' => array(
            'emptyIcon' => false,
            'type' => 'monosocial',
            'iconsPerPage' => 4000,
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'monosocial',
          ),
          'description' => esc_html__('Select icon from library.', 'novo'),
        ),
        array(
          'type' => 'iconpicker',
          'heading' => esc_html__('Icon', 'novo'),
          'param_name' => 'icon_material',
          'value' => 'vc-material vc-material-cake',
          'settings' => array(
            'emptyIcon' => false,
            'type' => 'material',
            'iconsPerPage' => 4000,
          ),
          'dependency' => array(
            'element' => 'type',
            'value' => 'material',
          ),
          'description' => esc_html__('Select icon from library.', 'novo'),
        ),
        array(
          "type" => "vc_link",
          "heading" => esc_html__("Link", "novo"),
          "param_name" => "link",
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Link Color", "pt-addons"),
          "param_name" => "link_color",
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Link Background Color", "pt-addons"),
          "param_name" => "link_bg_color",
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => esc_html__("Link Border Color", "pt-addons"),
          "param_name" => "link_border_color",
          "group" => esc_html__("Customizing", "pt-addons"),
        ),
        array(
          "type" => "animation_style",
          "heading" => esc_html__("Animation In", "novo"),
          "param_name" => "animation",
        ),
      ),
    ));
  }

  // Element HTML
  public function pt_photo_carousel_html($atts, $content = null) {

    // Params extraction
    extract(
      shortcode_atts(
        array(
          'uniqid' => uniqid(),
          'images' => '',
          'type' => 'fontawesome',
          'icon_fontawesome' => 'fa fa-adjust',
          'icon_openiconic' => 'vc-oi vc-oi-dial',
          'icon_typicons' => 'typcn typcn-adjust-brightness',
          'icon_entypo' => 'entypo-icon entypo-icon-note',
          'icon_linecons' => 'vc_li vc_li-heart',
          'icon_monosocial' => 'vc-mono vc-mono-fivehundredpx',
          'icon_material' => 'vc-material vc-material-cake',
          'link' => '',
          'link_color' => '',
          'link_bg_color' => '',
          'link_border_color' => '',
          'animation' => '',
        ),
        $atts
      )
    );

    $item_class = $block_id = 'photo-carousel-' . $uniqid;;

    $css_code = array();

    if ($animation) {
      $item_class .= ' ' . $this->getCSSAnimation($animation);
    }

    if (!empty($images)) {
      $images = explode(',', $images);
    }

    $icon = 'icon_' . $type;
    vc_icon_element_fonts_enqueue($type);

    wp_enqueue_style('owl-carousel');
    wp_enqueue_script('owl-carousel');

    if(!empty($link_color)) {
      $css_code[] = ".$block_id .button-style1 {
        color: $link_color;
      }";
    }
    if(!empty($link_bg_color)) {
      $css_code[] = ".$block_id .button-style1 {
        background-color: $link_bg_color;
      }";
    }
    if(!empty($link_border_color)) {
      $css_code[] = ".$block_id .button-style1 {
        border-color: $link_border_color;
      }";
    }

    if (!empty($css_code)) {
      do_action('yprm_inline_css', yprm_implode($css_code, ''));
    }

    $html = '<div class="photo-carousel ' . esc_attr($item_class) . '">';
    if (!empty($link) && vc_build_link($link)['url']) {
      $link = vc_build_link($link);
      if (empty($link['target'])) {
        $link['target'] = '_self';
      }
      if (empty($link['title'])) {
        $link['title'] = '_self';
      }
      $html .= '<a href="' . esc_url($link['url']) . '" class="button-style1" target="' . esc_attr($link['target']) . '"><i class="' . esc_attr($$icon) . '"></i><span>' . wp_kses_post($link['title']) . '</span></a>';
    }
    $html .= '<div class="carousel">';
    foreach ($images as $image) {
      $html .= '<div class="item" style="background-image: url(' . wp_get_attachment_image_src($image, 'medium')[0] . ');"></div>';
    }
    $html .= '</div>';
    $html .= '</div>';

    return $html;

  }

} // End Element Class

// Element Class Init
new PT_Photo_Carousel();