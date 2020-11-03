<?php

/*
Plugin Name: One Click Demo Import
Plugin URI: https://wordpress.org/plugins/one-click-demo-import/
Description: Import your content, widgets and theme settings with one click. Theme authors! Enable simple demo import for your theme demo data.
Version: 2.5.2
Author: ProteusThemes
Author URI: http://www.proteusthemes.com
License: GPL3
License URI: http://www.gnu.org/licenses/gpl.html
*/

defined('ABSPATH') or die('No script kiddies please!');

class YPRM_OCDI_Plugin {

	public function __construct() {

		if (version_compare(phpversion(), '5.3.2', '<')) {
			add_action('admin_notices', array($this, 'old_php_admin_error_notice'));
		} else {
			$this->set_plugin_constants();

			require_once PT_OCDI_PATH. '/vendor/autoload.php';
			
			$pt_one_click_demo_import = OCDI\OneClickDemoImport::get_instance();

			if (defined('WP_CLI') && WP_CLI) {
				WP_CLI::add_command('ocdi list', array('OCDI\WPCLICommands', 'list_predefined'));
				WP_CLI::add_command('ocdi import', array('OCDI\WPCLICommands', 'import'));
			}
		}
	}

	public function old_php_admin_error_notice() {
		$message = sprintf(esc_html__('The %2$sOne Click Demo Import%3$s plugin requires %2$sPHP 5.3.2+%3$s to run properly. Please contact your hosting company and ask them to update the PHP version of your site to at least PHP 5.3.2.%4$s Your current version of PHP: %2$s%1$s%3$s', 'pt-ocdi'), phpversion(), '<strong>', '</strong>', '<br>');

		printf('<div class="notice notice-error"><p>%1$s</p></div>', wp_kses_post($message));
	}
	
	private function set_plugin_constants() {

		if (!defined('PT_OCDI_PATH')) {
			define('PT_OCDI_PATH', plugin_dir_path(__FILE__));
		}
		if (!defined('PT_OCDI_URL')) {
			define('PT_OCDI_URL', plugin_dir_url(__FILE__));
		}

		add_action('admin_init', array($this, 'set_plugin_version_constant'));
	}

	public function set_plugin_version_constant() {
		if (!defined('PT_OCDI_VERSION')) {
			$plugin_data = get_plugin_data(__FILE__);
			define('PT_OCDI_VERSION', $plugin_data['Version']);
		}
	}
}

$ocdi_plugin = new YPRM_OCDI_Plugin();

function ocdi_import_files() {
	$pages_array = array(
		'full-dark' => array(
			'title' => 'Full Dark',
			'url' => 'dark/',
			'category' => array('Full Demo'),
		),
		'full-white' => array(
			'title' => 'Full White',
			'url' => 'white/',
			'category' => array('Full Demo'),
		),
		'one-page' => array(
			'title' => 'One Page',
			'url' => 'dark/',
			'category' => array('Homes'),
		),
		'one-page-white' => array(
			'title' => 'One Page White',
			'url' => 'white/',
			'category' => array('Homes'),
		),
		'photographer' => array(
			'title' => 'Photographer',
			'url' => 'dark/home-photographer',
			'category' => array('Homes'),
		),
		'photographer-white' => array(
			'title' => 'Photographer White',
			'url' => 'white/home-photographer',
			'category' => array('Homes'),
		),
		'business' => array(
			'title' => 'Business',
			'url' => 'dark/home-business',
			'category' => array('Homes'),
		),
		'business-white' => array(
			'title' => 'Business White',
			'url' => 'white/home-business',
			'category' => array('Homes'),
		),
		'portfolio' => array(
			'title' => 'Portfolio',
			'url' => 'dark/home-portfolio',
			'category' => array('Homes'),
		),
		'portfolio-white' => array(
			'title' => 'Portfolio White',
			'url' => 'white/home-portfolio',
			'category' => array('Homes'),
		),
		'shop' => array(
			'title' => 'Shop',
			'url' => 'dark/home-shop',
			'category' => array('Homes'),
		),
		'shop-white' => array(
			'title' => 'Shop White',
			'url' => 'white/home-shop',
			'category' => array('Homes'),
		),
		'agency' => array(
			'title' => 'Agency',
			'url' => 'dark/home-agency',
			'category' => array('Homes'),
		),
		'agency-white' => array(
			'title' => 'Agency White',
			'url' => 'white/home-agency',
			'category' => array('Homes'),
		),
		'freelancer' => array(
			'title' => 'Freelancer',
			'url' => 'dark/home-freelancer',
			'category' => array('Homes'),
		),
		'freelancer-white' => array(
			'title' => 'Freelancer White',
			'url' => 'white/home-freelancer',
			'category' => array('Homes'),
		),
		'categories' => array(
			'title' => 'Categories',
			'url' => 'dark/home-categories',
			'category' => array('Homes'),
		),
		'categories-white' => array(
			'title' => 'Categories White',
			'url' => 'white/home-categories',
			'category' => array('Homes'),
		),
		'split-screen' => array(
			'title' => 'Split Screen',
			'url' => 'dark/split-screen',
			'category' => array('Homes'),
		),
		'split-screen-2' => array(
			'title' => 'Split Screen 2',
			'url' => 'dark/split-screen-2',
			'category' => array('Homes'),
		),
		'showcase-with-thumbnails' => array(
			'title' => 'Showcase With Thumbnails',
			'url' => 'dark/showcase-with-thumbnails',
			'category' => array('Homes'),
		),
		'parallax-slider' => array(
			'title' => 'Parallax Slider',
			'url' => 'dark/parallax-slider',
			'category' => array('Homes'),
		),
		'musician' => array(
			'title' => 'Musician',
			'url' => 'dark/musician',
			'category' => array('Homes'),
		),
		'musician-white' => array(
			'title' => 'Musician White',
			'url' => 'white/home-musician',
			'category' => array('Homes'),
		),
		'videographer' => array(
			'title' => 'Videographer',
			'url' => 'dark/videographer',
			'category' => array('Homes'),
		),
		'videographer-white' => array(
			'title' => 'Videographer White',
			'url' => 'white/videographer',
			'category' => array('Homes'),
		),
		'liquid-slider' => array(
			'title' => 'Liquid Slider',
			'url' => 'dark/liquid-slider',
			'category' => array('Homes'),
		),
		'services' => array(
			'title' => 'Services',
			'url' => 'dark/services',
			'category' => array('Pages'),
		),
		'services-white' => array(
			'title' => 'Services White',
			'url' => 'white/services',
			'category' => array('Pages'),
		),
		'about-me' => array(
			'title' => 'About Me',
			'url' => 'dark/about-me',
			'category' => array('Pages'),
		),
		'about-me-white' => array(
			'title' => 'About Me White',
			'url' => 'white/about-me',
			'category' => array('Pages'),
		),
		'contacts' => array(
			'title' => 'Contacts',
			'url' => 'dark/contacts',
			'category' => array('Contacts', 'Pages'),
		),
		'contacts-2' => array(
			'title' => 'Contacts 2',
			'url' => 'dark/contacts-2',
			'category' => array('Contacts', 'Pages'),
		),
		'scattered' => array(
			'title' => 'Scattered',
			'url' => 'dark/gallery/scattered',
			'category' => array('Portfolio'),
		),
		'carousel-type-1' => array(
			'title' => 'Carousel Type 1',
			'url' => 'dark/gallery/carousel-type-1',
			'category' => array('Portfolio'),
		),
		'carousel-type-2' => array(
			'title' => 'Carousel Type 2',
			'url' => 'dark/gallery/carousel-type-2',
			'category' => array('Portfolio'),
		),
		'flow' => array(
			'title' => 'Flow',
			'url' => 'dark/gallery/flow',
			'category' => array('Portfolio'),
		),
		'horizontal' => array(
			'title' => 'Horizontal',
			'url' => 'dark/gallery/horizontal',
			'category' => array('Portfolio'),
		),
		'project-items-links' => array(
			'title' => 'Project Items Links',
			'url' => 'dark/gallery/project-items-links',
			'category' => array('Portfolio'),
		),
		'portfolio-grid' => array(
			'title' => 'Portfolio Grid',
			'url' => 'dark/gallery/grid/col-3',
			'category' => array('Portfolio'),
		),
		'portfolio-masonry' => array(
			'title' => 'Portfolio Masonry',
			'url' => 'dark/gallery/masonry/col-3',
			'category' => array('Portfolio'),
		),
		'blog-grid' => array(
			'title' => 'Blog Grid',
			'url' => 'dark/blog-grid',
			'category' => array('Blog'),
		),
		'blog-horizontal' => array(
			'title' => 'Blog Horizontal',
			'url' => 'dark/blog-horizontal',
			'category' => array('Blog'),
		),
		'blog-masonry' => array(
			'title' => 'Blog Masonry',
			'url' => 'dark/blog-masonry',
			'category' => array('Blog'),
		),
		'blog-with-sidebar' => array(
			'title' => 'Blog With Sidebar',
			'url' => 'dark/blog-with-sidebar',
			'category' => array('Blog'),
		),
		'booking' => array(
			'title' => 'Booking',
			'url' => 'dark/booking',
			'category' => array('Booking'),
		),
	);

	$result_array = array();

	foreach($pages_array as $key => $page) {
		$redux_url = 'http://updates.promo-theme.com/demo-contents/novo/pages/redux.json';

		if($page['title'] == 'Full Dark' || $page['title'] == 'Full White') {
			$redux_url = 'http://updates.promo-theme.com/demo-contents/novo/pages/'.$key.'/redux.json';
		}

		array_push($result_array, array(
			'import_file_name' => $page['title'],
			'categories' => $page['category'],
			'import_file_url' => 'http://updates.promo-theme.com/demo-contents/novo/pages/'.$key.'/xml.xml',
			'import_preview_image_url' => 'http://updates.promo-theme.com/demo-contents/novo/pages/'.$key.'/screenshot.png',
			'preview_url' => 'https://promo-theme.com/novo/'.$page['url'],
			'import_widget_file_url' => 'http://updates.promo-theme.com/demo-contents/novo/pages/widgets.json',
			'import_redux' => array(
				array(
					'file_url' => $redux_url,
					'option_name' => 'novo_theme',
				),
			)
		));
	}

	return $result_array;
}
if(get_option('enable_full_version')) {
	add_filter('pt-ocdi/import_files', 'ocdi_import_files');
}