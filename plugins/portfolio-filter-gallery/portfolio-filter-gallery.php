<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
Plugin Name: Portfolio Filter Gallery
Plugin URI: http://awplife.com/
Description: Portfolio Filter Gallery For Wordpress.
Version: 0.1.7
Author: A WP Life
Author URI: http://awplife.com/
License: GPLv2 or later
Text Domain: PFG_TXTDM
Domain Path: /languages
**/

if ( ! class_exists( 'Awl_Portfolio_Filter_Gallery' ) ) {

	class Awl_Portfolio_Filter_Gallery {		
		
		public function __construct() {
			$this->_constants();
			$this->_hooks();
		}		
		
		protected function _constants() {
			//Plugin Version
			define( 'PFG_PLUGIN_VER', '0.1.2' );
			
			//Plugin Text Domain
			define("PFG_TXTDM","awl-portfolio-filter-gallery" );

			//Plugin Name
			define( 'PFG_PLUGIN_NAME', __( 'Portfolio Filter Gallery', PFG_TXTDM ) );

			//Plugin Slug
			define( 'PFG_PLUGIN_SLUG', 'awl_filter_gallery' );

			//Plugin Directory Path
			define( 'PFG_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

			//Plugin Directory URL
			define( 'PFG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

			define( 'PFG_SECURE_KEY', md5( NONCE_KEY ) );
			
		} // end of constructor function
		
		protected function _hooks() {
			
			//Load text domain
			add_action( 'plugins_loaded', array( $this, 'load_textdomain' ) );
			
			//add gallery menu item, change menu filter for multisite
			add_action( 'admin_menu', array( $this, 'pfg_menu' ), 101 );
			
			//Create Portfolio Filter Gallery Custom Post
			add_action( 'init', array( $this, 'Portfolio_Filter_Gallery' ));
			
			//Add meta box to custom post
			add_action( 'add_meta_boxes', array( $this, 'admin_add_meta_box' ) );
			 
			//loaded during admin init 
			add_action( 'admin_init', array( $this, 'admin_add_meta_box' ) );
			
			add_action('wp_ajax_pfg_gallery_js', array(&$this, '_ajax_pfg_gallery'));
		
			add_action('save_post', array(&$this, '_pfg_save_settings'));

			//Shortcode Compatibility in Text Widgets
			add_filter('widget_text', 'do_shortcode');

		} // end of hook function
		
		public function load_textdomain() {
			load_plugin_textdomain( PFG_TXTDM, false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}
		
		public function pfg_menu() {
			$filter_menu = add_submenu_page( 'edit.php?post_type='.PFG_PLUGIN_SLUG, __( 'Filters', PFG_TXTDM ), __( 'Filters', PFG_TXTDM ), 'administrator', 'pfg-filter-page', array( $this, 'awl_filter_page') );
			$doc_menu    = add_submenu_page( 'edit.php?post_type='.PFG_PLUGIN_SLUG, __( 'Docs', PFG_TXTDM ), __( 'Docs', PFG_TXTDM ), 'administrator', 'sr-doc-page', array( $this, 'pfg_doc_page') );
			$featured_menu    = add_submenu_page( 'edit.php?post_type='.PFG_PLUGIN_SLUG, __( 'Featured-plugin', PFG_TXTDM ), __( 'Featured plugin', PFG_TXTDM ), 'administrator', 'sr-featured-page', array( $this, 'pfg_featured_page') );
		}
		
		public function Portfolio_Filter_Gallery() {
			$labels = array(
				'name'                => _x( 'Portfolio Filter Gallery', 'Post Type General Name', PFG_TXTDM ),
				'singular_name'       => _x( 'Portfolio Filter Gallery', 'Post Type Singular Name', PFG_TXTDM ),
				'menu_name'           => __( 'Portfolio Gallery', PFG_TXTDM ),
				'name_admin_bar'      => __( 'Portfolio Filter', PFG_TXTDM ),
				'parent_item_colon'   => __( 'Parent Item:', PFG_TXTDM ),
				'all_items'           => __( 'All Gallery', PFG_TXTDM ),
				'add_new_item'        => __( 'Add New Gallery', PFG_TXTDM ),
				'add_new'             => __( 'Add New Gallery', PFG_TXTDM ),
				'new_item'            => __( 'New Portfolio Filter Gallery', PFG_TXTDM ),
				'edit_item'           => __( 'Edit Portfolio Filter Gallery', PFG_TXTDM ),
				'update_item'         => __( 'Update Portfolio Filter Gallery', PFG_TXTDM ),
				'search_items'        => __( 'Search Portfolio Filter Gallery', PFG_TXTDM ),
				'not_found'           => __( 'Portfolio Filter Gallery Not found', PFG_TXTDM ),
				'not_found_in_trash'  => __( 'Portfolio Filter Gallery Not found in Trash', PFG_TXTDM ),
			);
			$args = array(
				'label'               => __( 'Portfolio Filter Gallery', PFG_TXTDM ),
				'description'         => __( 'Custom Post Type For Portfolio Filter Gallery', PFG_TXTDM ),
				'labels'              => $labels,
				'supports'            => array('title'),
				'taxonomies'          => array(),
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'menu_position'       => 65,
				'menu_icon'           => 'dashicons-screenoptions',
				'show_in_admin_bar'   => true,
				'show_in_nav_menus'   => true,
				'can_export'          => true,
				'has_archive'         => true,		
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'page',
			);
			register_post_type( 'awl_filter_gallery', $args );
		} // end of post type function
		
		public function admin_add_meta_box() {
			add_meta_box( '', __('Add Portfolio Filter Gallery', PFG_TXTDM), array(&$this, 'pfg_image_upload'), 'awl_filter_gallery', 'normal', 'default' );
		}
			
		public function pfg_image_upload($post) {		
			wp_enqueue_script('jquery');
			wp_enqueue_script('media-upload');
			wp_enqueue_script('awl-pfg-uploader.js', PFG_PLUGIN_URL . 'js/awl-pfg-uploader.js', array('jquery'));
			wp_enqueue_style('awl-pfg-uploader-css', PFG_PLUGIN_URL . 'css/awl-pfg-uploader.css');
			wp_enqueue_script( 'awl-pfg-color-picker-js', plugins_url('js/pfg-color-picker.js', __FILE__ ), array( 'wp-color-picker' ), false, true );
			wp_enqueue_media();			
			wp_enqueue_style( 'wp-color-picker' );
			?>
			<div id="image-gallery">
				<p><strong>First add filters for images by clicking filters menu.</strong></p>
				<p><strong>Please do not reapeat images. Use control ( Ctrl ) or shift ( Shift ) key for select multiple filters. For unselect filters use ( Ctrl ) key.</strong></p>
				
				<input type="button" id="remove-all-images" name="remove-all-images" class="button button-large remove-all-images" rel="" value="<?php _e('Delete All Images', PFG_TXTDM); ?>">
				<ul id="remove-images" class="sbox">
					<?php
					$allimagesetting = unserialize(base64_decode(get_post_meta( $post->ID, 'awl_filter_gallery'.$post->ID, true)));
					
					$all_category = get_option('awl_portfolio_filter_gallery_categories');
					if(isset($allimagesetting['image-ids'])) {
						$filters = $allimagesetting['filters'];
						$count = 0;
						foreach($allimagesetting['image-ids'] as $id) {
						$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
						$attachment = get_post( $id );
						$image_link = $allimagesetting['image-link'][$count];
						?>
						<li class="image">
							<img class="new-image" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
							<input type="hidden" id="image-ids[]" name="image-ids[]" value="<?php echo $id; ?>" />
							<input type="text" name="image-title[]" id="image-title[]" style="width: 100%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">
							<input type="text" name="image-link[]" id="image-link[]" style="width: 100%;" placeholder="Image Link URL" value="<?php echo $image_link; ?>">
							<?php
							if(isset($filters[$id])) {
								$selected_filters_array = $filters[$id];
							} else {
								$selected_filters_array = array();
							}
							?>
							<select name="filters[<?php echo $id; ?>][]" multiple="multiple" id="filters" style="width: 100%;">
								<?php
								foreach ($all_category as $key => $value) {
									if($key != 0) {																					
									?><strong><option value="<?php echo $key; ?>" <?php if(count($selected_filters_array)) { if(in_array($key, $selected_filters_array)) echo "selected=selected"; } ?>><?php echo ucwords($value); ?></option></strong><?php
									}
								}							
								?>
							</select>
							<input type="button" name="remove-image" id="remove-image" class="button remove-single-image button-danger" style="width: 100%;" value="Delete">
						</li>
					<?php $count++; } // end of foreach
					} //end of if
					?>
				</ul>
			</div>
			<!--Add New Image Button-->
			<div name="add-new-images" id="add-new-images" class="new-images" style="height: 200px; width: 202px; border-radius: 8px;">
				<div class="menu-icon dashicons dashicons-format-image"></div>
				<div class="add-text"><?php _e('Add Image', PFG_TXTDM); ?></div>
			</div>
			<div style="clear:left;"></div>
			<br>
			<br>
			<h1>Copy Portfolio Filter Gallery Shortcode</h1>
			<hr>
			<p class="input-text-wrap">
				<p><?php _e('Copy & Embed shortcode into any Page/ Post / Text Widget to display your image gallery on site.', PFG_TXTDM); ?><br></p>
				<input type="text" name="shortcode" id="shortcode" value="<?php echo "[PFG id=".$post->ID."]"; ?>" readonly style="height: 60px; text-align: center; font-size: 24px; width: 25%; border: 2px dashed;" onmouseover="return pulseOff();" onmouseout="return pulseStart();">
			</p>
			<br>
			<br>
			<h1><?php _e('Portfolio Filter Gallery Setting', PFG_TXTDM); ?></h1>
			<hr>
			<?php
			require_once('filter-gallery-settings.php');	
		}// end of upload multiple image
		
		public function _pfg_ajax_callback_function($id) {
			//wp_get_attachment_image_src ( int $attachment_id, string|array $size = 'thumbnail', bool $icon = false );
			//thumb, thumbnail, medium, large, post-thumbnail
			$thumbnail = wp_get_attachment_image_src($id, 'medium', true);
			$attachment = get_post( $id ); // $id = attachment id
			$all_category = get_option('awl_portfolio_filter_gallery_categories');
			?>
			<li class="image">
				<img class="new-image" src="<?php echo $thumbnail[0]; ?>" alt="<?php echo get_the_title($id); ?>" style="height: 150px; width: 98%; border-radius: 8px;">
				<input type="hidden" id="image-ids[]" name="image-ids[]" value="<?php echo $id; ?>" />
				<input type="text" name="image-title[]" id="image-title[]" style="width: 100%;" placeholder="Image Title" value="<?php echo get_the_title($id); ?>">
				<input type="text" name="image-link[]" id="image-link[]" style="width: 100%;" placeholder="Image Link URL">
				<select name="filters[<?php echo $id; ?>][]" multiple id="filters" style="width: 100%;">
					<?php
					foreach ($all_category as $key => $value) {
						if($key != 0) {
							?><strong><option value="<?php echo $key; ?>"><?php echo ucfirst($value); ?></option></strong><?php
						}
					}							
					?>
				</select>
				<input type="button" name="remove-image" id="remove-image" style="width: 100%;" class="button" value="Delete">
			</li>
			<?php
		}
		
		public function _ajax_pfg_gallery() {
			echo $this->_pfg_ajax_callback_function($_POST['PFGimageId']);
			die;
		}
		
		public function _pfg_save_settings($post_id) {
			if(isset($_POST['pfg_save_nonce'])) {
				if (!isset( $_POST['pfg_save_nonce'] ) || ! wp_verify_nonce( $_POST['pfg_save_nonce'], 'pfg_save_settings' ) ) {
				   print 'Sorry, your nonce did not verify.';
				   exit;
				} else {
					
					$image_ids 		= $_POST['image-ids'];
					$image_titles 	= $_POST['image-title'];
					
					$i = 0;
					foreach($image_ids as $image_id) {
						$single_image_update = array(
							'ID'           => $image_id,
							'post_title'   => $image_titles[$i],						
						);
						wp_update_post( $single_image_update );
						$i++;
					}
					
					$awl_image_gallery_shortcode_setting = "awl_filter_gallery".$post_id;
					update_post_meta($post_id, $awl_image_gallery_shortcode_setting, base64_encode(serialize($_POST)));
				}
			}
		}// end save setting
		
		//filter/category page
		public function awl_filter_page() {
			require_once('filters.php');
		}
		
		//Doc page
		public function pfg_doc_page() {
			require_once('docs.php');
			}
			
		public function pfg_featured_page() {
			require_once('featured-plugins/featured-plugins.php');
		}
	}
	$pfg_portfolio_gallery_object = new Awl_Portfolio_Filter_Gallery();		
	require_once('filter-gallery-shortcode.php');
}
?>