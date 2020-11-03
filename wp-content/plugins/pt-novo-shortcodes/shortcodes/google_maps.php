<?php

// Element Description: PT Google map

class PT_Google_Maps extends WPBakeryShortCode {
     
    // Element Init
    function __construct() {
        add_action( 'init', array( $this, 'pt_google_map_mapping' ) );
        add_shortcode( 'pt_google_map', array( $this, 'pt_google_map_html' ) );
    }
     
    // Element Mapping
    public function pt_google_map_mapping() {
         
        // Stop all if VC is not enabled
        if ( !defined( 'WPB_VC_VERSION' ) ) {
            return;
        }
         
        // Map the block with vc_map()
        vc_map( array(
            "name" => esc_html__("Google map", "novo"),
            "base" => "pt_google_map",
            "show_settings_on_create" => true,
            "icon" => "shortcode-icon-map",
            "is_container" => true,
            "category" => esc_html__("Novo Shortcodes", "novo"),
            "params" => array(
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Width", "novo"),
                    "descroption" => esc_html__("in %", "novo"),
                    "param_name" => "width",
                    "admin_label" => true,
                    "value" => "100",
                    "group" => esc_html__('General', 'novo')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Height", "novo"),
                    "descroption" => esc_html__("in px", "novo"),
                    "param_name" => "height",
                    "admin_label" => true,
                    "value" => "345",
                    "group" => esc_html__('General', 'novo')
                ),
                array(
                    "type" => "dropdown",
                    "class" => "",
                    "heading" => esc_html__("Map type", "novo"),
                    "param_name" => "map_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__("Roadmap", "novo") => "ROADMAP", 
                        esc_html__("Satellite", "novo") => "SATELLITE", 
                        esc_html__("Hybrid", "novo") => "HYBRID", 
                        esc_html__("Terrain", "novo") => "TERRAIN"
                    ),
                    "group" => esc_html__('General', 'novo')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Latitude", "novo"),
                    "param_name" => "lat",
                    "admin_label" => true,
                    "description" => '<a href="http://labs.mondeca.com/geo/anyplace.html" target="_blank">'.esc_html__('Here is a tool','novo').'</a> '.esc_html__('where you can find Latitude & Longitude of your location', 'novo'),
                    "group" => esc_html__('General', 'novo')
                ),
                array(
                    "type" => "textfield",
                    "class" => "",
                    "heading" => esc_html__("Longitude", "novo"),
                    "param_name" => "lng",
                    "admin_label" => true,
                    "description" => '<a href="http://labs.mondeca.com/geo/anyplace.html" target="_blank">'.esc_html__('Here is a tool','novo').'</a> '.esc_html__('where you can find Latitude & Longitude of your location', "novo"),
                    "group" => esc_html__('General', 'novo')
                ),
                array(
                    "type" => "dropdown",
                    "heading" => esc_html__("Map Zoom", "novo"),
                    "param_name" => "zoom",
                    "value" => array(
                        esc_html__("16 - Default", "novo") => 16, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 13, 14, 15, 16, 17, 18, 19, 20
                    ),
                    "group" => esc_html__('General', 'novo')
                ),
                array(
                    "type"        => "switch",
                    "class"       => "",
                    "heading"     => esc_html__( "Mouse wheel scroll", "novo" ),
                    "param_name"  => "scrollwheel",
                    "value"       => "off",
                    "options"     => array(
                        "on" => array(
                            "on"    => esc_html__( "On", "novo" ),
                            "off"   => esc_html__( "Off", "novo" ),
                        ),
                    ),
                    "default_set" => false,
                    "group"       => esc_html__( "General", "novo" ),
                ),
            ),
        ) );
    }
     
     
    // Element HTML
    public function pt_google_map_html( $atts, $content = null ) {
         
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'width' => '100',
                    'height' => '345',
                    'map_type' => 'ROADMAP',
                    'lat' => '',
                    'lng' => '',
                    'zoom' => '16',
                    'scrollwheel' => 'off',
                ), 
                $atts
            )
        );

        $id = 'map-'.uniqid();

        $html = "";

        if($scrollwheel == "on") {
            $scrollwheel = "true";
        } else {
            $scrollwheel = "false";
        }

        if(!empty($lat) && !empty($lng)) {
            if(!empty(yprm_get_theme_setting('google_maps_api_key'))) {
                $html = '<div class="map" id="'.esc_attr($id).'" style="width: '.esc_attr($width).'%; height: '.esc_attr($height).'px;"></div>';
            } else {
                $html = esc_html__('No Api Keys,', 'novo').' <a href="'.admin_url('admin.php?page=Novo').'">'.esc_html__('Add key in Theme Options').'</a>';
            }

            wp_enqueue_script( 'googleapis', 'https://maps.googleapis.com/maps/api/js?v=3.exp&amp;key='.yprm_get_theme_setting('google_maps_api_key').'&amp;sensor=false', array('jquery') );

            wp_add_inline_script('novo-script', "jQuery(document).ready(function(jQuery) {
                jQuery('#".esc_attr($id)."').each(function(){
                    function initialize() {
                        var myLatlng = new google.maps.LatLng(".$lat.",".$lng.");
                        var mapOptions = {
                            zoom: ".$zoom.",
                            center: myLatlng,
                            disableDefaultUI: true,
                            scrollwheel: ".$scrollwheel.",
                            mapTypeId: google.maps.MapTypeId.".$map_type.",
                            styles: [{\"featureType\":\"all\",\"elementType\":\"all\",\"stylers\":[{\"saturation\":-100},{\"gamma\":1}]}]
                        }
                        var map = new google.maps.Map(document.getElementById('".$id."'), mapOptions);

                        var myLatLng = new google.maps.LatLng(".$lat.",".$lng.");
                        var beachMarker = new google.maps.Marker({
                            position: myLatLng,
                            map: map
                        });
                        google.maps.event.addDomListener(window, 'resize', function() {
                            var center = map.getCenter();
                            google.maps.event.trigger(map, 'resize');
                            map.setCenter(center); 
                        });
                    }
                    google.maps.event.addDomListener(window, 'load', initialize);
                });
            });");
        }

        

        return $html;
         
    }
     
} // End Element Class
 
 
// Element Class Init
new PT_Google_Maps();