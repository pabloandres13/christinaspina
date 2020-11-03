<?php 
/*
Plugin Name: PT Music Album
Plugin URI: #
Version: 1.0.3
Author: Promo Theme
Author URI: #
*/

class Mp3Data
{
    public $mp3data;
    public $fileDirectory;
    public $bitRate;
    public $blockMax;
     
    function __construct($filename, $bitrate = null)
    {
        $this->mp3data = array();
        $this->mp3data['filesize'] = $this->get_size_of_file($filename);
        $this->fileDirectory = fopen($filename, "r");
        $this->blockMax = 1024;
         
        if($bitrate) 
            $this->bitRate = $bitrate;
        else
            $this->bitRate= 128;
         
        $this->set_data();

        return $this->get_formatted_time($this->mp3data['length']);
    }   
     
    public function get_mp3_duration() {
        return $this->mp3data['duration'];
    }    
     
 
    public function get_mp3_filesize() {
        return $this->mp3data['filesize'];
    }
 
    public static function get_size_of_file($url) { 
        if (substr($url,0,4)=='http') { 
             
            $x = array_change_key_case(get_headers($url, 1),CASE_LOWER); 
             
            if ( strcasecmp($x[0], 'HTTP/1.1 200 OK') != 0 ) { 
                $x = $x['content-length'][1]; 
            } 
            else { 
                $x = $x['content-length']; 
            } 
        } 
        else { 
            $x = @filesize($url); 
        } 
     
        return $x; 
    }      
     
     
    public function set_data() {
        $this->mp3data['length'] = $this->get_duration($this->mp3data, $this->tell(), $this->bitRate);
        $this->mp3data['duration'] = $this->get_formatted_time($this->mp3data['length']);
    }
    public function tell()
    {
        return ftell($this->fileDirectory)-$this->blockMax - 1;
    }    
     
    public function get_duration(&$mp3,$startat, $bitrate)
    {
        if ($bitrate > 0)
        {
            $KBps = ($bitrate * 1000)/8;
            $datasize = ($mp3['filesize'] - ($startat/8));
            $length = $datasize / $KBps;
            return sprintf("%d", $length);
        }
        return "";
    }
 
    public function get_formatted_time($duration)
    {
        return sprintf("%d:%02d", ($duration /60), $duration %60 );
    }    
}


class PT_Music_Album_Plugin {

	function __construct() {
        add_action( 'init', array($this,'post_type') );
        $this->define_slugs();

        add_action( 'admin_enqueue_scripts', array($this,'admin_scripts') );

        add_shortcode( 'pt_music_album_shortcode', array( $this, 'shortcode' ) );

        add_shortcode( 'pt_podcast_shortcode', array( $this, 'podcast' ) );

        $this->save_permalink_structure();

        add_action( 'add_meta_boxes', array($this,'register_meta_box') );
        add_action( 'save_post', array($this,'save') );
	}

	public function admin_scripts($hook){
        wp_register_style( 'pt-album-styles', plugins_url('pt-music-album') . '/include/css/style.css' );
        wp_register_script( 'pt-album-scripts', plugins_url('pt-music-album') . '/include/js/script.js', array('jquery') );

        if ( $hook == "post.php" || $hook == "post-new.php" ) {
            wp_enqueue_style('pt-album-styles');

        	wp_enqueue_media();
            wp_localize_script( 'pt-album-scripts', 'meta_image',
				array(
					'title' => esc_html__( 'Choose or Upload Media', 'events' ),
					'button' => esc_html__( 'Use this media', 'events' ),
				)
			);
			wp_enqueue_script( 'pt-album-scripts' );
        }
    }

	public function post_type() {
		if(empty(get_option( 'pt_music_album_slug' ))) {
			$slug = 'pt-music-album';
		} else {
			$slug = get_option( 'pt_music_album_slug' );
		}
	    $args = array(
	        'label'  => null,
			'labels' => array(
				'name'               => esc_html__( 'Music Album', 'pt-music-album'),
				'singular_name'      => esc_html__( 'Album', 'pt-music-album'),
				'add_new'            => esc_html__( 'Add Album', 'pt-music-album'),
				'add_new_item'       => esc_html__( 'Add New Album', 'pt-music-album'),
				'edit_item'          => esc_html__( 'Edit Album', 'pt-music-album'),
				'not_found'          => esc_html__( 'Not found', 'pt-music-album'),
				'not_found_in_trash' => esc_html__( 'Not found in cart', 'pt-music-album'),
				'menu_name'          => esc_html__( 'PT Music Album', 'pt-music-album'),
			),
			'public' => true,
			'show_ui' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'rewrite' => array('slug' => $slug),
			'query_var' => true,
			'menu_icon' => 'dashicons-format-audio',
			'supports' => array(
				'title',
				'editor',
				'thumbnail',
			),
			'menu_position' => '27'
	    );
	    register_post_type( 'pt-music-album', $args );
	}

	private function define_slugs() {
		$this->slug = apply_filters(
			'pt_music_album_post_slug',
			get_option( 'pt_music_album_slug' )
		);
	}

	private function save_permalink_structure() {
		add_action( 'load-options-permalink.php', 'load_permalinks' );
		function load_permalinks()
		{
			if( isset( $_POST['pt_music_album_slug'] ) )
			{
				update_option( 'pt_music_album_slug', sanitize_title_with_dashes( $_POST['pt_music_album_slug'] ) );
			}

			add_settings_field( 'pt_music_album_slug', __( 'Music album base' ), 'callback', 'permalink', 'optional' );


		}
		function callback()
		{
			$value = get_option( 'pt_music_album_slug' );	
			echo '<input type="text" name="pt_music_album_slug" value="' . esc_attr( $value ) . '" ><code>/album</code>';
		}
	}

	public function register_meta_box() {
		add_meta_box( 'pt-tracks-meta-box', 'Tracks', array($this,'render_meta_box_tracks'), 'pt-music-album', 'advanced' );
		add_meta_box( 'pt-details-meta-box', 'Album details', array($this,'render_meta_box_details'), 'pt-music-album', 'side' );
	}

	public function render_meta_box_tracks() {
		global $post;
		wp_nonce_field( 'pt_music_album_tracks', 'pt_music_album_tracks_nonce' );
		$value = get_post_meta( $post->ID, 'pt_music_album_tracks_meta', true );
		if(empty($value)) {
			$value = array(
				'tracks' => array(
					'id' => '',
					'track_url' => '',
					'name' => '',
					'spotify' => '',
					'soundcloud' => '',
					'apple_music' => '',
					'google_play' => '',
				)
			);
		}

		$i = 0;
		?>
		<div class="pt-admin-accordion-area">
			<?php foreach ($value as $key => $track_item) {
				if(isset($track_item['name']) && !empty($track_item['name'])) {
					$name = $track_item['name'];
				} else {
					$name = esc_html__('Add Track', 'pt-music-album');
				}

				if(isset($track_item['id']) && !empty($track_item['id'])) {
					$id = $track_item['id'];
				} else {
					$id = uniqid();
				} 
				
				if(!isset($track_item['duration'])) {
					$track_item['duration'] = '';
				}
				?>

				<div class="pt-admin-accordion">
					<div class="top">
						<div class="label active"><?php echo strip_tags($name) ?></div>
						<?php if($i == '0') { ?>
							<div class="remove fa fa-times" style="display: none;" title="<?php echo esc_html__('Remove item', 'pt-music-album') ?>"></div>
						<?php } else { ?>
							<div class="remove fa fa-times" title="<?php echo esc_html__('Remove item', 'pt-music-album') ?>"></div>
						<?php } ?>
						<div class="add fa fa-plus" title="<?php echo esc_html__('Add item', 'pt-music-album') ?>"></div>
					</div>
					<div class="wrap">
						<input type="hidden" name="tracks[<?php echo esc_attr($id) ?>][id]" value="<?php echo esc_attr($id) ?>">
						<div class="input-row upload">
							<button type="button" class="button" data-media-uploader-target="#pt_music_album_media"><?php echo esc_html__('Upload Media', 'pt-music-album') ?></button>
							<input type="url" class="upload-input" name="tracks[<?php echo esc_attr($id) ?>][track_url]" value="<?php echo esc_attr($track_item['track_url']) ?>">
						</div>
						<div class="input-row">
							<label><?php echo esc_html__('Name', 'pt-music-album') ?></label>
							<div class="input"><input type="text" name="tracks[<?php echo esc_attr($id) ?>][name]" value="<?php echo esc_attr($track_item['name']) ?>"></div>
						</div>
						<div class="input-row">
							<label><?php echo esc_html__('Duration', 'pt-music-album') ?></label>
							<div class="input"><input type="text" name="tracks[<?php echo esc_attr($id) ?>][duration]" value="<?php echo esc_attr($track_item['duration']) ?>"></div>
						</div>
						<?php /*
						<div class="input-row">
							<label><?php echo esc_html__('Spotify', 'pt-music-album') ?></label>
							<div class="input"><input type="url" name="tracks[<?php echo esc_attr($id) ?>][spotify]" value="<?php echo esc_attr($track_item['spotify']) ?>"></div>
						</div>
						<div class="input-row">
							<label><?php echo esc_html__('SoundCloud', 'pt-music-album') ?></label>
							<div class="input"><input type="url" name="tracks[<?php echo esc_attr($id) ?>][soundcloud]" value="<?php echo esc_attr($track_item['soundcloud']) ?>"></div>
						</div>
						<div class="input-row">
							<label><?php echo esc_html__('Apple Music', 'pt-music-album') ?></label>
							<div class="input"><input type="url" name="tracks[<?php echo esc_attr($id) ?>][apple_music]" value="<?php echo esc_attr($track_item['apple_music']) ?>"></div>
						</div>
						<div class="input-row">
							<label><?php echo esc_html__('Google Play', 'pt-music-album') ?></label>
							<div class="input"><input type="url" name="tracks[<?php echo esc_attr($id) ?>][google_play]" value="<?php echo esc_attr($track_item['google_play']) ?>"></div>
						</div>
						*/ ?>
					</div>
				</div>

				<?php
				$i++;
			} 
			?>
		</div>
		<?php 
	}

	public function render_meta_box_details() {
		global $post;
		wp_nonce_field( 'pt_music_album_tracks', 'pt_music_album_tracks_nonce' );
		$value = get_post_meta( $post->ID, 'pt_music_album_details_meta', true );
		if(empty($value)) {
			$value = array(
				'date' => '',
				'download_link' => '',
				'copyright' => '',
				'spotify' => '',
				'soundcloud' => '',
				'apple_music' => '',
				'google_play' => '',
			);
		}
		
		?>
		<div class="input-inline-row">
			<label><?php echo esc_html__('Release date', 'pt-music-album') ?></label>
			<div class="input"><input type="date" name="details[date]" value="<?php echo esc_attr($value['date']) ?>"></div>
		</div>
		<div class="input-inline-row">
			<label><?php echo esc_html__('Show download link', 'pt-music-album') ?></label>
			<div class="input">
				<select name="details[download_link]">
					<?php /* <option value="default"<?php if($value['download_link'] == 'default') echo ' selected'; ?>><?php echo esc_html__('Default', 'pt-music-album') ?></option> */ ?>
					<option value="yes"<?php if($value['download_link'] == 'yes') echo ' selected'; ?>><?php echo esc_html__('Yes', 'pt-music-album') ?></option>
					<option value="no"<?php if($value['download_link'] == 'no') echo ' selected'; ?>><?php echo esc_html__('No', 'pt-music-album') ?></option>
				</select>
			</div>
		</div>
		<div class="input-inline-row">
			<label><?php echo esc_html__('Spotify', 'pt-music-album') ?></label>
			<div class="input"><input type="url" name="details[spotify]" value="<?php echo esc_attr($value['spotify']) ?>"></div>
		</div>
		<div class="input-inline-row">
			<label><?php echo esc_html__('SoundCloud', 'pt-music-album') ?></label>
			<div class="input"><input type="url" name="details[soundcloud]" value="<?php echo esc_attr($value['soundcloud']) ?>"></div>
		</div>
		<div class="input-inline-row">
			<label><?php echo esc_html__('Apple Music', 'pt-music-album') ?></label>
			<div class="input"><input type="url" name="details[apple_music]" value="<?php echo esc_attr($value['apple_music']) ?>"></div>
		</div>
		<div class="input-inline-row">
			<label><?php echo esc_html__('Google Play', 'pt-music-album') ?></label>
			<div class="input"><input type="url" name="details[google_play]" value="<?php echo esc_attr($value['google_play']) ?>"></div>
		</div>
		<?php 
	}

	public function save( $post_id ) {

		if ( ! isset( $_POST['pt_music_album_tracks_nonce'] ) )
			return $post_id;

		$nonce = $_POST['pt_music_album_tracks_nonce'];

		if ( ! wp_verify_nonce( $nonce, 'pt_music_album_tracks' ) )
			return $post_id;

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;

		if ( 'pt-music-album' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		$tracks = $_POST['tracks'];
		$details = $_POST['details'];

		update_post_meta( $post_id, 'pt_music_album_tracks_meta', $tracks );
		update_post_meta( $post_id, 'pt_music_album_details_meta', $details );
	}

	public static function album_array( $id = null ) {
		if(empty($id)) {
			global $post;
			$id = $post->ID;
		}
		$array = array(
			'items'   => get_post_meta( $id, 'pt_music_album_tracks_meta', true ),
			'details' => get_post_meta( $id, 'pt_music_album_details_meta', true ),
		);
		return $array;
	}

	public static function get_avg_luminance($filename, $num_samples=10) {
				$img = imagecreatefromjpeg($filename);
				
				if(!$img) return false;

        $width = imagesx($img);
        $height = imagesy($img);

        $x_step = intval($width/$num_samples);
        $y_step = intval($height/$num_samples);

        $total_lum = 0;

        $sample_no = 1;

        for ($x=0; $x<$width; $x+=$x_step) {
            for ($y=0; $y<$height; $y+=$y_step) {

                $rgb = imagecolorat($img, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                $lum = ($r+$r+$b+$g+$g+$g)/6;

                $total_lum += $lum;
                $sample_no++;
            }
        }

        // work out the average
        $avg_lum  = $total_lum/$sample_no;

        return $avg_lum;
    }

	public static function check_cover($image_url) {
	    $luminance = self::get_avg_luminance($image_url,10);

	    if ($luminance > 170) {
            return 'black';
        } else {
            return 'white';
        }
	}

	public function shortcode( $atts ) {
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'id' => get_the_ID(),
                    'css' => '',
                    'cover' => 'on'
                ), 
                $atts
            )
        );

        wp_enqueue_script( 'jplayer', plugins_url('pt-music-album') . '/include/js/jquery.jplayer.min.js');
		wp_enqueue_script( 'scrollbar', plugins_url('pt-music-album') . '/include/js/jquery.scrollbar.min.js');
		if($id == '0' || empty($id)) {
			$id = get_the_ID();
		}

		$album_id = uniqid();

		$album_array = $this->album_array($id);
		$album_name = get_the_title($id);

		$js_items = '';

		$thumb = get_post_meta( $id, '_thumbnail_id', true );

		if(isset($album_array['items']) && is_array($album_array['items'])) {
			if (count($album_array['items']) == 0) {
				return false;
			}
		} else {
			return false;
		}

		foreach ($album_array['items'] as $key => $track) {
			if(!isset($track['duration']) || !$track['duration']) {
				$mp3file = new Mp3Data($track['track_url']);
				$duration = $mp3file->mp3data['duration'];
			} else {
				$duration = $track['duration'];
			}

			$js_items .= '{';
				$js_items .= 'title:"'.$track['name'].'",';
				$js_items .= 'mp3:"'.$track['track_url'].'",';
				$js_items .= 'duration:"'.$duration.'",';
			$js_items .= '},';
		}

		if(!empty($thumb)) {
			$css .= ' '.$this->check_cover(wp_get_attachment_image_src($thumb, 'large')[0]);
		}

		wp_add_inline_script('jplayer', "//<![CDATA[
		jQuery(document).ready(function(){

			new jPlayerPlaylist({
				jPlayer: '#jquery_jplayer_".$album_id."',
				cssSelectorAncestor: '#jp_container_".$album_id."',
				cssDuration: '#jp_duration_".$album_id."'
			}, [
				".$js_items."
			], {
				swfPath: '".plugins_url('pt-music-album')."/include/js',
				supplied: 'mp3',
				wmode: 'window',
				useStateClassSkin: true,
				autoBlur: false,
				smoothPlayBar: true,
				keyEnabled: true,
				ready: function(event) {
					jQuery('#jp_container_".$album_id." .track-name').html(jQuery('#jp_container_".$album_id." a.jp-playlist-current').html());
				},
				play: function(event) {
					jQuery('#jp_container_".$album_id." .track-name').html(jQuery('#jp_container_".$album_id." a.jp-playlist-current').html());
				},
			});

			jQuery('.jp-playlist').each(function() {
				jQuery(this).scrollbar();
			});
		});
		//]]>");
		ob_start();
        ?>
        <div id="jquery_jplayer_<?php echo esc_attr($album_id) ?>" class="jp-jplayer"></div>
		<div id="jp_container_<?php echo esc_attr($album_id) ?>" class="jp-audio album-area row <?php echo esc_attr($css) ?>" role="application">
			<?php if(!empty($thumb) && $cover == 'on') { ?>
				<div class="col-xs-12 col-sm-6">
			<?php } else { ?>
				<div class="col-xs-12">
			<?php } ?>
				<div class="album-playlist">
					<div class="top">
						<div class="top-playbutton jp-play">
							<?php if(!empty($thumb)) { ?>
								<div class="pb-bg" style="background-image: url(<?php echo wp_get_attachment_image_src($thumb, 'medium')[0] ?>)"></div>
							<?php } else { ?>
								<div class="pb-bg"></div>
							<?php } ?>
							<i class="music-and-multimedia-play-button"></i>
						</div>
						<div class="top-text">
							<div class="album-name"><?php echo esc_html($album_name); ?></div>
							<div class="track-name"></div>
							<div class="track-buttons">
								<button class="jp-previous music-and-multimedia-backward-button"></button>
								<button class="jp-play music-and-multimedia-play-button"></button>
								<button class="jp-next music-and-multimedia-fast-forward-button"></button>
							</div>
							<div class="bottom">
								<div class="time">
									<div class="jp-current-time"></div>
									<div class="separate">/</div>
									<div class="jp-duration"></div>
								</div>
								<div class="volume">
									<button class="jp-mute music-and-multimedia-speaker-with-waves"></button>
									<div class="jp-volume-bar">
										<div class="jp-volume-bar-value"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
					</div>
					<div class="jp-playlist">
						<ul>
							<li></li>
						</ul>
					</div>
				</div>
			</div>
			<?php if(!empty($thumb) && $cover == 'on') { ?>
				<div class="col-xs-12 col-sm-6">
					<div class="album-cover" style="background-image: url(<?php echo wp_get_attachment_image_src($thumb, 'large')[0] ?>)"></div>
				</div>
			<?php } ?>
			<div class="col-xs-12">
				<div class="jp-no-solution">
					<?php echo __('<span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.', 'pt-music-album') ?>
				</div>
			</div>
		</div>
        <?php
	    return ob_get_clean();
    }

	public function podcast( $atts ) {
        // Params extraction
        extract(
            shortcode_atts(
                array(
                    'cover_image_url' => '',
                    'sub_heading' => '',
                    'heading' => '',
                    'css' => '',
                    'track_url' => ''
                ), 
                $atts
            )
        );

        

		$album_id = uniqid();

		$cover_image_url = wp_get_attachment_image_src($cover_image_url, 'full')[0];


		if(isset($track_url) && !empty($track_url)) {
		} else {
			return false;
		}

		if(!empty($cover_image_url)) {
			$css .= ' '.$this->check_cover($cover_image_url);
		}

		wp_enqueue_script( 'jplayer', plugins_url('pt-music-album') . '/include/js/jquery.jplayer.min.js');

		wp_add_inline_script('jplayer', "//<![CDATA[
		jQuery(document).ready(function(){
			jQuery('#jquery_jplayer_".$album_id."').jPlayer({
				jPlayer: '#jquery_jplayer_".$album_id."',
				cssSelectorAncestor: '#jp_container_".$album_id."',
				ready: function (event) {
					jQuery(this).jPlayer('setMedia', {
						title: '".esc_html(strip_tags($heading))."',
						mp3: '".esc_url($track_url)."',
					});
				},
				swfPath: '".plugins_url('pt-music-album')."/include/js',
				supplied: 'mp3',
				wmode: 'window',
				useStateClassSkin: true,
				autoBlur: false,
				smoothPlayBar: true,
				keyEnabled: true,
				remainingDuration: false,
				toggleDuration: true
			});
		});
		//]]>");
		ob_start();
        ?>
        <div id="jquery_jplayer_<?php echo esc_attr($album_id) ?>" class="jp-jplayer"></div>
		<div id="jp_container_<?php echo esc_attr($album_id) ?>" class="jp-audio album-area <?php echo esc_attr($css) ?>" role="application">
			<div class="album-playlist">
				<div class="top">
					<?php if(!empty($cover_image_url)) { ?>
						<div class="bg" style="background-image: url(<?php echo $cover_image_url ?>)"></div>
					<?php } ?>
					<div class="top-playbutton jp-play">
						<?php if(!empty($cover_image_url)) { ?>
							<div class="pb-bg" style="background-image: url(<?php echo $cover_image_url ?>)"></div>
						<?php } else { ?>
							<div class="pb-bg"></div>
						<?php } ?>
						<i class="music-and-multimedia-play-button"></i>
					</div>
					<div class="top-text">
						<?php if(!empty($sub_heading)) { ?>
							<div class="album-name"><?php echo wp_kses_post($sub_heading); ?></div>
						<?php } if(!empty($heading)) { ?>
							<div class="track-name"><?php echo wp_kses_post($heading); ?></div>
						<?php } ?>
						<div class="track-buttons">
							<button class="jp-previous music-and-multimedia-backward-button"></button>
							<button class="jp-play music-and-multimedia-play-button"></button>
							<button class="jp-next music-and-multimedia-fast-forward-button"></button>
						</div>
						<div class="bottom">
							<div class="time">
								<div class="jp-current-time"></div>
								<div class="separate">/</div>
								<div class="jp-duration"></div>
							</div>
							<div class="volume">
								<button class="jp-mute music-and-multimedia-speaker-with-waves"></button>
								<div class="jp-volume-bar">
									<div class="jp-volume-bar-value"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="jp-progress">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12">
				<div class="jp-no-solution">
					<?php echo __('<span>Update Required</span>To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.', 'pt-music-album') ?>
				</div>
			</div>
		</div>
        <?php
	    return ob_get_clean();
    }
}

new PT_Music_Album_Plugin();