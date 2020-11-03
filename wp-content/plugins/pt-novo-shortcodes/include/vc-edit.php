<?php

if (!function_exists("vc_add_params")) {
  return;
}

$array = array_merge(
  array(
    yprm_vc_uniqid(),
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
    ),
    array(
      "type" => "attach_image",
      "heading" => esc_html__("Background Image", "pt-addons"),
      "param_name" => "background_image",
      "dependency" => Array("element" => "background_parallax", "value" => "on"),
    ),
    array(
      "type" => "dropdown",
      "heading" => esc_html__("Content Color Scheme", "pt-addons"),
      "param_name" => "content_color",
      "value" => array(
        esc_html__("---", "pt-addons") => "",
        esc_html__("Dark", "pt-addons") => "dark",
        esc_html__("Light", "pt-addons") => "light",
      ),
    ),
  ),
  yprm_vc_bg_overlay(),
  array(
    array(
      "type" => "number",
      "heading" => esc_html__("Bottom Offset", "pt-addons"),
      "param_name" => "overlay_bottom_offset",
      "suffix" => esc_html__("px", "pt-addons"),
      "edit_field_class" => "vc_col-auto",
      "dependency" => Array("element" => "bg_overlay", "value" => array("on")),
      "description" => esc_html__("(optional)", "pt-addons"),
      "group" => esc_html__('Background Overlay', 'pt-addons'),
    ),
    array(
      "type" => "number",
      "heading" => esc_html__("Height", "pt-addons"),
      "param_name" => "overlay_height",
      "suffix" => esc_html__("px", "pt-addons"),
      "edit_field_class" => "vc_col-auto",
      "dependency" => Array("element" => "bg_overlay", "value" => array("on")),
      "description" => esc_html__("(optional)", "pt-addons"),
      "group" => esc_html__('Background Overlay', 'pt-addons'),
    ),
  )
);

vc_add_params("vc_row", array_merge(
  array(
    array(
      "type" => "textfield",
      "heading" => esc_html__("Section Name", "pt-addons"),
      "param_name" => "section_name",
      "description" => esc_html__("For screen navigation", "pt-addons"),
    ),
  ),
  $array
));

vc_remove_param("vc_row", "parallax");
vc_remove_param("vc_row", "parallax_image");
vc_remove_param("vc_row", "parallax_speed_bg");

vc_add_params("vc_row_inner", $array);

vc_remove_param("vc_row_inner", "parallax");
vc_remove_param("vc_row_inner", "parallax_image");
vc_remove_param("vc_row_inner", "parallax_speed_bg");

vc_add_params("vc_column", $array);

vc_remove_param("vc_column", "parallax");
vc_remove_param("vc_column", "parallax_image");
vc_remove_param("vc_column", "parallax_speed_bg");

vc_add_params("vc_section", array_merge(
  array(
    array(
      "type" => "textfield",
      "heading" => esc_html__("Section Name", "pt-addons"),
      "param_name" => "section_name",
      "description" => esc_html__("For screen navigation", "pt-addons"),
    ),
  ),
  $array
));

vc_remove_param("vc_section", "parallax");
vc_remove_param("vc_section", "parallax_image");
vc_remove_param("vc_section", "parallax_speed_bg");