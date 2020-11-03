<?php

if(!class_exists('YPRM_Gradient_Param'))
{
    class YPRM_Gradient_Param
    {
        function __construct()
        {
            add_action('admin_enqueue_scripts',array($this,'admin_scripts'));
            if(defined('WPB_VC_VERSION') && version_compare(WPB_VC_VERSION, 4.8) >= 0) {
                if(function_exists('vc_add_shortcode_param'))
                {
                    vc_add_shortcode_param('gradient' , array(&$this, 'number_settings_field' ));
                }
            }
            else {
                if(function_exists('add_shortcode_param'))
                {
                    add_shortcode_param('gradient' , array(&$this, 'number_settings_field' ));
                }
            }
        }

        function number_settings_field($settings, $value)
        {
            $dependency = '';
            $param_name = isset($settings['param_name']) ? $settings['param_name'] : '';
            $type = isset($settings['type']) ? $settings['type'] : '';
            $class = isset($settings['class']) ? $settings['class'] : '';
            $base_gradient = isset($settings['base_gradient']) ? $settings['base_gradient'] : '';
            $base_orientation = isset($settings['base_orientation']) ? $settings['base_orientation'] : '';

            $dependency_element = $settings['dependency']['element'];
            $dependency_value = $settings['dependency']['value'];
            $dependency_value_json =  json_encode($dependency_value);

            $uni = uniqid();
            $class_id = 'gradient-'.$uni;

            $val_array = array();
            if(!empty($value)) {
            	$val_array = explode('||', $value);
            }

            if(isset($val_array[0]) && !empty($val_array[0])) {
                $gradient = $val_array[0];
            } else {
                $gradient = $base_gradient;
            }

            if(isset($val_array[2]) && !empty($val_array[2])) {
                $orientation = $val_array[2];
            } else {
                $orientation = $base_orientation;
            }

            $output = '<select id="orientation-'.$uni.'">';
            	if(isset($orientation) && !empty($orientation)) {
            		if($orientation == 'horizontal') {
            			$output .= '<option value="horizontal" selected="selected">'.esc_html__('Horizontal', 'novo').'</option>';
            		} else {
            			$output .= '<option value="horizontal">'.esc_html__('Horizontal', 'novo').'</option>';
            		}
				    
            		if($orientation == 'vertical') {
            			$output .= '<option value="vertical" selected="selected">'.esc_html__('Vertical', 'novo').'</option>';
            		} else {
            			$output .= '<option value="vertical">'.esc_html__('Vertical', 'novo').'</option>';
            		}
				    
				} else {
				    $output .= '<option value="horizontal">'.esc_html__('Horizontal', 'novo').'</option>';
				    $output .= '<option value="vertical" selected="selected">'.esc_html__('Vertical', 'novo').'</option>';
				}
			$output .= '</select>';
            $output .= '<div class="gradient ' . esc_attr( $param_name.' '.$class_id ) . '"></div>';
            $output .= '<div class="gradient-preview targetEl-'.esc_attr($uni).'"></div>';

            $output .= '<input type="hidden" class="grad-val-'.esc_attr( $uni ).' wpb_vc_param_value ' . esc_attr( $param_name ) . ' ' . esc_attr( $type ) . ' ' . esc_attr( $class ) . ' yprm_gradient" name="' . esc_attr( $param_name ) . '"  value="'.esc_attr( $value ).'" '.$dependency.'/>';

            ?>
            	<link rel="stylesheet" href="<?php echo plugins_url('pt-novo-shortcodes') . '/assets/css/gradient.css' ?>" type="text/css" media="all">
                <script type="text/javascript">
	                jQuery(document).ready(function(){
	                    jQuery('.gradient.<?php echo esc_attr($class_id); ?>').ClassyGradient({
	                    	target: '.targetEl-<?php echo esc_attr($uni); ?>',
                            <?php if(!empty($gradient)) { ?>
	                    	gradient: '<?php echo esc_js($gradient) ?>',
                            <?php } if(!empty($orientation)) { ?>
	                    	orientation: '<?php echo esc_js($orientation) ?>',
                            <?php } ?>
	                    	onChange: function(stringGradient,cssGradient) {
					            var orientation = jQuery('#orientation-<?php echo esc_attr($uni); ?>').val();
					            jQuery('.grad-val-<?php echo esc_attr($uni); ?>').val(stringGradient+'||'+cssGradient+'||'+orientation);
					        }
	                    });

	                    jQuery('#orientation-<?php echo esc_attr($uni); ?>').on('change', function() {
	                        var orientation = jQuery(this).val();
	                        jQuery('.gradient.<?php echo esc_attr($class_id); ?>').data('ClassyGradient').setOrientation(orientation);
	                    });
	                });
                </script>
            <?php
            return $output;
        }

        function admin_scripts($hook){
            wp_register_script("classygradient", plugins_url('pt-novo-shortcodes') . '/assets/js/jquery.gradient.js',array('jquery'));
            wp_register_script("jqueryui", 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js',array('jquery'));

            if ( $hook == "post.php" || $hook == "post-new.php" ) {
                wp_enqueue_script('classygradient');
                //wp_enqueue_script('jqueryui');
            }
        }

    }
}

if(class_exists('YPRM_Gradient_Param'))
{
    $YPRM_Gradient_Param = new YPRM_Gradient_Param();
}