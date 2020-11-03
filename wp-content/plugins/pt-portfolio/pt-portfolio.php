<?php
/*
Plugin Name: PT Portfolio
Plugin URI: #
Description: 
Version: 1.0.5
Author: Promo Theme
Author URI: #
*/

class PT_Portfolio {

	private $post_type = 'pt-portfolio';
	private $slug = 'project';
	private $taxonomy_slug = 'portfolio';
	private $taxonomy_name = 'pt-portfolio-category';
	private $taxonomy_tag_name = 'pt-portfolio-tag';
	private $taxonomy_tag_slug = 'portfolio-tag';

	/**
	 * @internal
	 */
	public function _init() {
		$this->define_slugs();

		add_action( 'init', array( $this, '_action_register_post_type' ) );
		add_action( 'init', array( $this, '_action_register_taxonomy' ) );

		if ( is_admin() ) {
			$this->save_permalink_structure();
			$this->add_admin_actions();
			$this->add_admin_filters();
		}
	}

	private function define_slugs() {
		$this->slug = apply_filters(
			'pt_gallery_ext_portfolio_post_slug',
			get_option( 'pt_gallery_ext_portfolio_project_slug' )
		);

		$this->taxonomy_slug = apply_filters(
			'pt_gallery_ext_portfolio_taxonomy_slug',
			get_option( 'pt_gallery_ext_portfolio_portfolio_slug' )
		);
	}

	private function add_admin_actions() {
		add_action( 'admin_menu', array( $this, '_action_admin_rename_projects' ) );
		add_action( 'restrict_manage_posts', array( $this, '_action_admin_add_portfolio_edit_page_filter' ) );

		add_action( 'manage_' . $this->post_type . '_posts_custom_column',
			array(
				$this,
				'_action_admin_manage_custom_column'
			),
			10,
			2 );

		add_action( 'do_meta_boxes', array( $this, '_action_admin_featured_image_label' ) );

		add_action( 'admin_enqueue_scripts', array( $this, '_action_admin_add_static' ) );

		add_action( 'admin_head', array( $this, '_action_admin_initial_nav_menu_meta_boxes' ), 999 );
	}

	private function save_permalink_structure() {
		add_action( 'load-options-permalink.php', 'pt_gallery_load_permalinks' );
		function pt_gallery_load_permalinks()
		{
			if( isset( $_POST['pt_gallery_ext_portfolio_project_slug'] ) )
			{
				update_option( 'pt_gallery_ext_portfolio_project_slug', sanitize_title_with_dashes( $_POST['pt_gallery_ext_portfolio_project_slug'] ) );
			}
			if( isset( $_POST['pt_gallery_ext_portfolio_portfolio_slug'] ) )
			{
				update_option( 'pt_gallery_ext_portfolio_portfolio_slug', sanitize_title_with_dashes( $_POST['pt_gallery_ext_portfolio_portfolio_slug'] ) );
			}

			add_settings_field( 'pt_gallery_ext_portfolio_project_slug', __( 'Project base' ), 'pt_gallery_project_callback', 'permalink', 'optional' );

			add_settings_field( 'pt_gallery_ext_portfolio_portfolio_slug', __( 'Portfolio category base' ), 'pt_gallery_portfolio_callback', 'permalink', 'optional' );


		}
		function pt_gallery_project_callback()
		{
			$value = get_option( 'pt_gallery_ext_portfolio_project_slug' );	
			echo '<input type="text" name="pt_gallery_ext_portfolio_project_slug" value="' . esc_attr( $value ) . '" ><code>/my-project</code>';
		}

		function pt_gallery_portfolio_callback()
		{
			$value = get_option( 'pt_gallery_ext_portfolio_portfolio_slug' );
			echo '<input type="text" name="pt_gallery_ext_portfolio_portfolio_slug" value="' . esc_attr( $value ) . '"><code>/my-portfolio</code>';
		}
	}

	public function add_admin_filters() {
		add_filter( 'parse_query', array( $this, '_filter_admin_filter_portfolios_by_portfolio_category' ), 10, 2 );
		add_filter( 'months_dropdown_results', array( $this, '_filter_admin_remove_select_by_date_filter' ) );
		add_filter( 'manage_edit-' . $this->post_type . '_columns',
			array(
				$this,
				'_filter_admin_manage_edit_columns'
			),
			10,
			1 );
	}

	/**
	 * @internal
	 */
	public function _action_admin_add_static() {
		$projects_listing_screen  = array(
			'only' => array(
				array(
					'post_type' => $this->post_type,
					'base'      => array( 'edit' )
				)
			)
		);
		$projects_add_edit_screen = array(
			'only' => array(
				array(
					'post_type' => $this->post_type,
					'base'      => 'post'
				)
			)
		);
	}

	/**
	 * @internal
	 */
	public function _action_register_post_type() {

		$post_names = apply_filters( 'pt_gallery_ext_projects_post_type_name',
			array(
				'singular' => __( 'Project', 'pt_portfolio' ),
				'plural'   => __( 'Projects', 'pt_portfolio' )
			) );

		register_post_type( $this->post_type,
			array(
				'labels'             => array(
					'name'               => $post_names['plural'], //__( 'Portfolio', 'pt_portfolio' ),
					'singular_name'      => $post_names['singular'], //__( 'Portfolio project', 'pt_portfolio' ),
					'add_new'            => __( 'Add New', 'pt_portfolio' ),
					'add_new_item'       => sprintf( __( 'Add New %s', 'pt_portfolio' ), $post_names['singular'] ),
					'edit'               => __( 'Edit', 'pt_portfolio' ),
					'edit_item'          => sprintf( __( 'Edit %s', 'pt_portfolio' ), $post_names['singular'] ),
					'new_item'           => sprintf( __( 'New %s', 'pt_portfolio' ), $post_names['singular'] ),
					'all_items'          => sprintf( __( 'All %s', 'pt_portfolio' ), $post_names['plural'] ),
					'view'               => sprintf( __( 'View %s', 'pt_portfolio' ), $post_names['singular'] ),
					'view_item'          => sprintf( __( 'View %s', 'pt_portfolio' ), $post_names['singular'] ),
					'search_items'       => sprintf( __( 'Search %s', 'pt_portfolio' ), $post_names['plural'] ),
					'not_found'          => sprintf( __( 'No %s Found', 'pt_portfolio' ), $post_names['plural'] ),
					'not_found_in_trash' => sprintf( __( 'No %s Found In Trash', 'pt_portfolio' ), $post_names['plural'] ),
					'parent_item_colon'  => '' /* text for parent types */
				),
				'description'        => __( 'Create a portfolio item', 'pt_portfolio' ),
				'public'             => true,
				'show_ui'            => true,
				'show_in_menu'       => true,
				'publicly_queryable' => true,
				/* queries can be performed on the front end */
				'has_archive'        => true,
				'rewrite'            => array(
					'slug' => $this->slug
				),
				'menu_position'      => 4,
				'show_in_nav_menus'  => true,
				'menu_icon'          => 'dashicons-portfolio',
				'hierarchical'       => false,
				'query_var'          => true,
				/* Sets the query_var key for this post type. Default: true - set to $post_type */
				'supports'           => array(
					'title', /* Text input field to create a post title. */
					'editor',
					'thumbnail', /* Displays a box for featured image. */
				),
				'capabilities'       => array(
					'edit_post'              => 'edit_pages',
					'read_post'              => 'edit_pages',
					'delete_post'            => 'edit_pages',
					'edit_posts'             => 'edit_pages',
					'edit_others_posts'      => 'edit_pages',
					'publish_posts'          => 'edit_pages',
					'read_private_posts'     => 'edit_pages',
					'read'                   => 'edit_pages',
					'delete_posts'           => 'edit_pages',
					'delete_private_posts'   => 'edit_pages',
					'delete_published_posts' => 'edit_pages',
					'delete_others_posts'    => 'edit_pages',
					'edit_private_posts'     => 'edit_pages',
					'edit_published_posts'   => 'edit_pages',
				),
			) );

	}

	/**
	 * @internal
	 */
	public function _action_register_taxonomy() {

		$category_names = apply_filters( 'pt_gallery_ext_portfolio_category_name', array(
			'singular' => __( 'Category', 'pt_portfolio' ),
			'plural'   => __( 'Categories', 'pt_portfolio' )
		) );

		register_taxonomy( $this->taxonomy_name, $this->post_type, array(
			'labels'            => array(
				'name'              => sprintf( _x( 'Portfolio %s', 'taxonomy general name', 'pt_portfolio' ), $category_names['plural'] ),
				'singular_name'     => sprintf( _x( 'Portfolio %s', 'taxonomy singular name', 'pt_portfolio' ), $category_names['singular'] ),
				'search_items'      => sprintf( __( 'Search %s', 'pt_portfolio' ), $category_names['plural'] ),
				'all_items'         => sprintf( __( 'All %s', 'pt_portfolio' ), $category_names['plural'] ),
				'parent_item'       => sprintf( __( 'Parent %s', 'pt_portfolio' ), $category_names['singular'] ),
				'parent_item_colon' => sprintf( __( 'Parent %s:', 'pt_portfolio' ), $category_names['singular'] ),
				'edit_item'         => sprintf( __( 'Edit %s', 'pt_portfolio' ), $category_names['singular'] ),
				'update_item'       => sprintf( __( 'Update %s', 'pt_portfolio' ), $category_names['singular'] ),
				'add_new_item'      => sprintf( __( 'Add New %s', 'pt_portfolio' ), $category_names['singular'] ),
				'new_item_name'     => sprintf( __( 'New %s Name', 'pt_portfolio' ), $category_names['singular'] ),
				'menu_name'         => $category_names['plural'],
			),
			'public'            => true,
			'hierarchical'      => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => false,
			'rewrite'           => array(
				'slug' => $this->taxonomy_slug
			),
		) );

		if ( apply_filters('pt:ext:portfolio:enable-tags', false) ) {
			$tag_names = apply_filters( 'pt_gallery_ext_portfolio_tag_name', array(
				'singular' => __( 'Tag', 'pt_portfolio' ),
				'plural'   => __( 'Tags', 'pt_portfolio' )
			) );

			register_taxonomy($this->taxonomy_tag_name, $this->post_type, array(
				'hierarchical' => false,
				'labels' => array(
					'name'              => $tag_names['plural'],
					'singular_name'     => $tag_names['singular'],
					'search_items'      => sprintf( __('Search %s','pt_portfolio'), $tag_names['plural']),
					'popular_items'     => sprintf( __( 'Popular %s','pt_portfolio' ), $tag_names['plural']),
					'all_items'         => sprintf( __('All %s','pt_portfolio'), $tag_names['plural']),
					'parent_item'       => null,
					'parent_item_colon' => null,
					'edit_item'         => sprintf( __('Edit %s','pt_portfolio'), $tag_names['singular'] ),
					'update_item'       => sprintf( __('Update %s','pt_portfolio'), $tag_names['singular'] ),
					'add_new_item'      => sprintf( __('Add New %s','pt_portfolio'), $tag_names['singular'] ),
					'new_item_name'     => sprintf( __('New %s Name','pt_portfolio'), $tag_names['singular'] ),
					'separate_items_with_commas'    => sprintf( __( 'Separate %s with commas','pt_portfolio' ), strtolower($tag_names['plural'])),
					'add_or_remove_items'           => sprintf( __( 'Add or remove %s','pt_portfolio' ), strtolower($tag_names['plural'])),
					'choose_from_most_used'         => sprintf( __( 'Choose from the most used %s','pt_portfolio' ), strtolower($tag_names['plural'])),
				),
				'public' => true,
				'show_ui' => true,
				'query_var' => true,
				'rewrite' => array(
					'slug' => $this->taxonomy_tag_slug
				),
			));
		}
	}

	/**
	 * internal
	 */
	public function _action_admin_rename_projects() {
		global $menu;

		foreach ( $menu as $key => $menu_item ) {
			if ( $menu_item[2] == 'edit.php?post_type=' . $this->post_type ) {
				$menu[ $key ][0] = __( 'Portfolio', 'pt_portfolio' );
			}
		}
	}

	/**
	 * Change the title of Featured Image Meta box
	 * @internal
	 */
	public function _action_admin_featured_image_label() {
		remove_meta_box( 'postimagediv', $this->post_type, 'side' );
		add_meta_box(
			'postimagediv',
			__( 'Project Cover Image', 'pt_portfolio' ),
			'post_thumbnail_meta_box',
			$this->post_type,
			'side'
		);
	}

	/**
	 * @internal
	 *
	 * @param string $column_name
	 * @param int $id
	 */
	public function _action_admin_manage_custom_column( $column_name, $id ) {

		switch ( $column_name ) {
			case 'image':
				if ( get_the_post_thumbnail( intval( $id ) ) ) {
					$value = '<a href="' . get_edit_post_link( $id,
							true ) . '" title="' . esc_attr( __( 'Edit this item', 'pt_portfolio' ) ) . '">' .
					         wp_get_attachment_image( get_post_thumbnail_id( intval( $id ) ),
						         array( 150, 100 ),
						         true ) .
					         '</a>';
				} else {
					$value = '';
				}
				echo $value;
				break;

			default:
				break;
		}
	}

	/**
	 * @internal
	 */
	public function _action_admin_initial_nav_menu_meta_boxes() {
		$screen = array(
			'only' => array(
				'base' => 'nav-menus'
			)
		);
		if ( ! pt_gallery_current_screen_match( $screen ) ) {
			return;
		}

		if ( get_user_option( 'pt-metaboxhidden_nav-menus' ) !== false ) {
			return;
		}

		$user              = wp_get_current_user();
		$hidden_meta_boxes = get_user_meta( $user->ID, 'metaboxhidden_nav-menus' );

		if ( $key = array_search( 'add-' . $this->taxonomy_name, $hidden_meta_boxes[0] ) ) {
			unset( $hidden_meta_boxes[0][ $key ] );
		}

		update_user_option( $user->ID, 'metaboxhidden_nav-menus', $hidden_meta_boxes[0], true );
		update_user_option( $user->ID, 'pt-metaboxhidden_nav-menus', 'updated', true );
	}

	/**
	 * @internal
	 */
	public function _action_admin_add_portfolio_edit_page_filter() {
		$screen = pt_gallery_current_screen_match( array(
			'only' => array(
				'base'      => 'edit',
				'id'        => 'edit-' . $this->post_type,
				'post_type' => $this->post_type,
			)
		) );

		if ( ! $screen ) {
			return;
		}

		$terms = get_terms( $this->taxonomy_name );

		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			echo '<select name="pt-portfolio-filter-by-portfolio-category"><option value="0">' . __( 'View all categories',
					'pt_portfolio' ) . '</option></select>';

			return;
		}

		
		$id  = 0;

		$dropdown_options = array(
			'selected'        => $id,
			'name'            => 'pt-portfolio-filter-by-portfolio-category',
			'taxonomy'        => $this->taxonomy_name,
			'show_option_all' => __( 'View all categories', 'pt_portfolio' ),
			'hide_empty'      => true,
			'hierarchical'    => 1,
			'show_count'      => 0,
			'orderby'         => 'name',
		);

		wp_dropdown_categories( $dropdown_options );
	}

	/**
	 * @internal
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public function _filter_admin_manage_edit_columns( $columns ) {
		$new_columns          = array();
		$new_columns['cb']    = $columns['cb']; // checkboxes for all projects page
		$new_columns['image'] = __( 'Cover Image', 'pt_portfolio' );

		return array_merge( $new_columns, $columns );
	}

	/**
	 * @internal
	 *
	 * @param WP_Query $query
	 *
	 * @return WP_Query
	 */
	public function _filter_admin_filter_portfolios_by_portfolio_category( $query ) {
		$screen = pt_gallery_current_screen_match( array(
			'only' => array(
				'base'      => 'edit',
				'id'        => 'edit-' . $this->post_type,
				'post_type' => $this->post_type,
			)
		) );

		if ( ! $screen || ! $query->is_main_query() ) {
			return $query;
		}

		$filter_value = 0;

		if(isset($_GET['pt-portfolio-filter-by-portfolio-category'])) {
			$filter_value = $_GET['pt-portfolio-filter-by-portfolio-category'];
		}

		if ( empty( $filter_value ) ) {
			return $query;
		}

		$filter_value = (int) $filter_value;

		$query->set( 'tax_query',
			array(
				array(
					'taxonomy' => $this->taxonomy_name,
					'field'    => 'id',
					'terms'    => $filter_value,
				)
			) );

		return $query;
	}

	/**
	 * @internal
	 *
	 * @param array $filters
	 *
	 * @return array
	 */
	public function _filter_admin_remove_select_by_date_filter( $filters ) {
		$screen = array(
			'only' => array(
				'base' => 'edit',
				'id'   => 'edit-' . $this->post_type,
			)
		);

		if ( ! pt_gallery_current_screen_match( $screen ) ) {
			return $filters;
		}

		return array();
	}

	/**
	 * @internal
	 *
	 * @return string
	 */
	public function _get_link() {
		return self_admin_url( 'edit.php?post_type=' . $this->post_type );
	}

	public function get_settings() {

		$response = array(
			'post_type'     => $this->post_type,
			'slug'          => $this->slug,
			'taxonomy_slug' => $this->taxonomy_slug,
			'taxonomy_name' => $this->taxonomy_name
		);

		return $response;
	}

	public function get_image_sizes() {
		return $this->get_config( 'image_sizes' );
	}

	public function get_post_type_name() {
		return $this->post_type;
	}

	public function get_taxonomy_name() {
		return $this->taxonomy_name;
	}
}

$cleaner = new PT_Portfolio();
$cleaner->_init();

function pt_gallery_current_screen_match( array $rules ) {
	$available_options = array(
		'action'      => true,
		'base'        => true,
		'id'          => true,
		'is_network'  => true,
		'is_user'     => true,
		'parent_base' => true,
		'parent_file' => true,
		'post_type'   => true,
		'taxonomy'    => true,
	);

	if ( empty( $rules ) ) {
		return true;
	}

	$rules = array_merge(
		array(
			'exclude' => array(),
			'only'    => array(),
		),
		$rules
	);

	if ( empty( $rules['exclude'] ) && empty( $rules['only'] ) ) {
		return true;
	}

	global $current_screen;

	if ( gettype( $current_screen ) != 'object' ) {
		return false;
	}

	do {
		$only = $rules['only'];

		if ( empty( $only ) ) {
			break;
		}

		if ( ! isset( $only[0] ) ) {
			$only = array( $only );
		}

		$found_one = false;
		$counter   = 0;
		foreach ( $only as $rule ) {
			if ( ! count( $rule ) ) {
				continue;
			}

			$match = true;

			foreach ( $rule as $r_key => $r_val ) {
				if ( ! isset( $available_options[ $r_key ] ) ) {
					continue;
				}

				if ( gettype( $r_val ) != 'array' ) {
					$r_val = array( $r_val );
				}

				$counter ++;

				if ( ! in_array( $current_screen->{$r_key}, $r_val ) ) {
					$match = false;
					break;
				}
			}

			if ( $match ) {
				$found_one = true;
				break;
			}
		}

		if ( ! $found_one && $counter ) {
			return false;
		}
	} while ( false );

	do {
		$exclude = $rules['exclude'];

		if ( empty( $exclude ) ) {
			break;
		}

		if ( ! isset( $exclude[0] ) ) { // if not array of arrays
			$exclude = array( $exclude );
		}

		foreach ( $exclude as $rule ) {
			if ( ! count( $rule ) ) {
				continue;
			}

			$match   = true;
			$counter = 0;

			foreach ( $rule as $r_key => $r_val ) {
				if ( ! isset( $available_options[ $r_key ] ) ) {
					continue;
				}

				if ( gettype( $r_val ) != 'array' ) {
					$r_val = array( $r_val );
				}

				$counter ++;

				if ( ! in_array( $current_screen->{$r_key}, $r_val ) ) {
					$match = false;
					break;
				}
			}

			if ( $match && $counter ) {
				return false;
			}
		}
	} while ( false );

	return true;
}
define( 'PT_GALLERY_META_BOX_URL', plugin_dir_url( __FILE__ ) );

class PT_Gallery_Meta_Box {
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'add' ) );
		foreach ( $this->post_types() as $post_type ) {
			add_action( 'save_post_' . $post_type, array( $this, 'save' ), 10, 3 );
		}
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'admin_footer', array( $this, 'js_template' ) );
	}
	/**
	 * Enqueue necessary js and css.
	 */
	public function enqueue() {
		if ( ! $this->is_editing_screen() ) {
			return;
		}
		wp_enqueue_style( 'pt-gallery-meta-box', PT_GALLERY_META_BOX_URL . 'static/css/pt_portfolio_admin.css', array(), false );
		wp_enqueue_script( 'pt-gallery-meta-box', PT_GALLERY_META_BOX_URL . 'static/js/pt_portfolio_admin.js', array( 'backbone', 'jquery' ), false, true );
	}
	/**
	 * Add meta box.
	 *
	 * @param string $post_type Post type name.
	 */
	public function add( $post_type ) {
		if ( ! in_array( $post_type, $this->post_types() ) ) {
			return;
		}
		add_meta_box(
			'pt-gallery',
			__( 'Gallery', 'gallery-meta-box' ),
			array( $this, 'render' ),
			$post_type,
			'side',
			'default'
		);
	}
	/**
	 * Save meta data.
	 *
	 * @param int     $post_id Post id.
	 * @param WP_Post $post    Post object.
	 * @param bool    $update  Is updating or not.
	 * @return mixed
	 */
	public function save( $post_id, $post, $update ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */
		// Check if our nonce is set.
		if ( ! isset( $_POST['gallery_meta_box_nonce'] ) ) {
			return $post_id;
		}
		$nonce = $_POST['gallery_meta_box_nonce'];
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'gallery_meta_box' ) ) {
			return $post_id;
		}
		/*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}
		// Save data.
		if ( isset( $_POST['gallery_meta_box'] ) ) {
			$value = array_map( 'absint', $_POST['gallery_meta_box'] );
			update_post_meta( $post_id, $this->meta_key(), $value );
		} else {
			delete_post_meta( $post_id, $this->meta_key() );
		}
		/**
		 * Fires after saving gallery data.
		 *
		 * @var int     $post_id Post ID.
		 * @var WP_Post $post    Post object.
		 * @var bool    $update  Whether this is an existing post being updated or not.
		 */
		do_action( 'gallery_meta_box_save', $post_id, $post, $update );
		return $post_id;
	}
	/**
	 * Render meta box output.
	 *
	 * @param WP_Post $post Post object.
	 */
	public function render( $post ) {
		wp_nonce_field( 'gallery_meta_box', 'gallery_meta_box_nonce' );
		$ids = get_post_meta( $post->ID, $this->meta_key(), true );
		if ( ! $ids ) {
			$ids = array();
		}
		?>
		<div id="pt-gallery-container" class="pt-gallery">
			<?php foreach ( $ids as $id ) : ?>
				<div id="gallery-image-<?php echo absint( $id ); ?>" class="pt-gallery-item">
					<div class="item">
						<?php echo wp_get_attachment_image( $id, 'thumbnail' ); ?>
					</div>
					<a href="#" class="gallery-remove">&times;</a>
					<input type="hidden" name="gallery_meta_box[]" value="<?php echo absint( $id ); ?>">
				</div>
			<?php endforeach; ?>
		</div>

		<a href="#" id="pt-add-gallery"><?php esc_html_e( 'Set gallery images', 'gallery-meta-box' ); ?></a>

		<input type="hidden" id="pt-gallery-ids" value="<?php echo esc_attr( implode( ',', $ids ) ); ?>">
		<?php
	}
	public function js_template() {
		if ( ! $this->is_editing_screen() ) {
			return;
		}
		?>
		<script type="text/html" id="tmpl-gallery-meta-box-image">
			<div id="gallery-image-{{{ data.id }}}" class="pt-gallery-item">
				<div class="item">
					<img src="{{{ data.url }}}">
				</div>
				<a href="#" class="gallery-remove">&times;</a>
				<input type="hidden" name="gallery_meta_box[]" value="{{{ data.id }}}">
			</div>
		</script>
		<?php
	}
	/**
	 * Get post types for this meta box.
	 *
	 * @return array
	 */
	protected function post_types() {
		$post_types = array( 'pt-portfolio' );
		/**
		 * Filters supported post types.
		 *
		 * @var array $post_types List supported post types.
		 */
		return apply_filters( 'gallery_meta_box_post_types', $post_types );
	}
	/**
	 * Returns gallery meta key.
	 *
	 * @return string
	 */
	protected function meta_key() {
		/**
		 * Filters meta key to store the gallery.
		 *
		 * @var string $meta_key Meta key.
		 */
		return apply_filters( 'gallery_meta_box_meta_key', 'pt_gallery' );
	}
	/**
	 * Check if is in editing screen.
	 *
	 * @return bool
	 */
	protected function is_editing_screen() {
		$screen = get_current_screen();
		return in_array( $screen->id, $this->post_types() );
	}
}

function pt_gallery_meta_box_init() {
	$meta_box = new PT_Gallery_Meta_Box();
	$meta_box->init();
}
add_action( 'plugins_loaded', 'pt_gallery_meta_box_init' );