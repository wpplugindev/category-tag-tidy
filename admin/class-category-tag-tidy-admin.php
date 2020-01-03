<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.wpplugins.tech
 * @since      1.0.0
 *
 * @package    Category_Tag_Tidy
 * @subpackage Category_Tag_Tidy/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Category_Tag_Tidy
 * @subpackage Category_Tag_Tidy/admin
 * @author     WPplugins.Tech <info@wpplugins.tech>
 */
class Category_Tag_Tidy_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name   The name of this plugin.
	 * @param      string    $version       The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/category-tag-tidy-admin.css', array(), $this->version, 'all' );

	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/category-tag-tidy-admin.js', array( 'jquery' ), $this->version, false );

	}


	/**
	 * Add new page under tools menu
	 */
	function add_page_to_tools_menu() {

		add_submenu_page( 'tools.php',
			__( 'Category Tag Tidy','category-tag-tidy' ),
			__( 'Category Tag Tidy','category-tag-tidy' ),
			'manage_categories',
			'category-tag-tidy',
			array( $this, 'display_form')
		);
	}


	/**
	 * Add new page under network admin menu
	 */
	function add_network_admin_page() {

		add_menu_page( 
			__( 'Category Tag Tidy','category-tag-tidy' ),
			__( 'Category Tag Tidy','category-tag-tidy' ),
			'manage_categories',
			'category-tag-tidy',
			array( $this, 'display_form'),
			'dashicons-tag'
		);
	}


	/**
	 * Add link under available tools sub menu
	 */ 
	public function add_link_to_available_tools() {

		if ( current_user_can( 'manage_categories' ) ) : 
			?>
			<div class="card">
				<h2 class="title"><?php _e( 'Category Tag Tidy', 'category-tag-tidy' ) ?></h2>
				<p><?php printf( __('To tidy up empty categories and tags, use the <a href="%s">
				Category Tag Tidy</a> Tool available under the Tools menu.'), 'tools.php?page=category-tag-tidy' ); ?></p>
			</div>
			<?php
			
		endif;
	}


	/**
	 * Sanitizes and validates check box data from _POST
	 * @param  'on'|null  $post_value        _POST value from checkbox
	 * @return 'on'|null  $sanitized_value
	 */ 
	public function sanitize_check_box($post_value) {

		$sanitized_value = sanitize_key($post_value);
		/* check for valid values - if anything other than 'on' or NULL set to NULL */
		if ($sanitized_value != 'on' && $sanitized_value != null) { 
			$sanitized_value = null;
		}

		return $sanitized_value;
	}


	/**
	 * Display Admin form and confirmation page
	 */
	public function display_form() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Category and Tag Tidy', 'category-tag-tidy' ); ?></h2>
		<?php
		if (is_multisite() && is_network_admin() ) {
			$heading = __('Clear all unused Tags or Categories for all Blogs on this Network','category-tag-tidy');
			$network_message = ' ' . __('across ALL blogs on this network','category-tag-tidy'); }
		else {
			$heading = __('Clear all unused Tags or Categories from blog', 'category-tag-tidy' );
			$network_message = ''; 
		}
		
		/* display initial form */
		if (!isset($_POST['nonce_tag_tidy']) && !isset( $_POST['nonce_confirm_tag_tidy'] )) {
			?>
			<div class="card">
				<h3><?php echo $heading; ?></h3>
				<form method="post" actions="">
				<?php wp_nonce_field( 'action_tag_tidy', 'nonce_tag_tidy' ); ?>
				<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php _e( 'Select Taxonomies to Tidy', 'category-tag-tidy' ); ?></th>
					<td>
					<label for="tidy_categories">
					<input name="tidy_categories" type="checkbox" id="tidy_categories"  />
					<?php _e( 'Categories', 'category-tag-tidy' ); ?></label>
					<br />
					<label for="tidy_post_tags">
					<input name="tidy_post_tags" type="checkbox" id="tidy_post_tags" />
					<?php _e( 'Post Tags', 'category-tag-tidy'); ?></label>
					<br />
					<br />
					<p class="description"><?php echo __( 'How it works: In order to maintain your categories structure - unused parent categories will not be deleted if they have a child category still in use.', 'category-tag-tidy' ) ; ?></p>
					<p class="description"><?php echo __( 'Tags are not hierarchical so all non-used tags will be deleted.', 'category-tag-tidy' ) ; ?></p>
					<p class="description"><?php echo __( 'Categories or Tags linked with content in the trash will not be deleted.', 'category-tag-tidy' ) ; ?></p>
					<p class="description"><?php echo '(' . __( 'Note: you will be asked to confirm on the next screen', 'category-tag-tidy' ) . ')'; ?></p>
				</td>
				</tr>
				</table>
				<?php submit_button(__( 'Run Tag Tidy', 'category-tag-tidy' ), 'primary', 'tag-tidy' ); ?>
				</form> 
			</div>	
			<?php
		}
		/* display confirmation form */
		if ( isset( $_POST['nonce_tag_tidy'] ) &&  wp_verify_nonce( $_POST['nonce_tag_tidy'], 'action_tag_tidy' ) ) {

			$tidy_post_tags = $this->sanitize_check_box($_POST['tidy_post_tags']);
			$tidy_categories = $this->sanitize_check_box($_POST['tidy_categories']);
		
			$show_error = false;
			
			if ($tidy_post_tags && $tidy_categories) {
				$message = __('This process will clear all unused <b>tags</b> and <b>categories</b>', 'category-tag-tidy') . $network_message; }
			else if ($tidy_post_tags && !$tidy_categories) {
				$message = __('This process will clear all unused <b>tags</b>', 'category-tag-tidy') . $network_message; }
			else if (!$tidy_post_tags && $tidy_categories) {
				$message = __('This process will clear all unused <b>categories</b>', 'category-tag-tidy') . $network_message; }
			else {
				$show_error = true; }
				
			if ($show_error) {
			?>
				<div class="card">
					<?php /* translators: %s is replaced with the back link */ ?>
					<p><?php printf( __( 'Please go <a href="%s">back</a> and select a taxonomy', 'category-tag-tidy' ), esc_url( 'javascript:javascript:history.go(-1)' ) ); ?></p>
				</div>
			<?php
			}
			else {	
			?>
				<div class="card">
				<h3><?php _e($message, 'category-tag-tidy'); ?></h3>
				<p><?php _e('Are you sure you wish to proceed?', 'category-tag-tidy'); ?></p>
				<p><?php _e('<b>Note:</b> This action is <i>not</i> reversible', 'category-tag-tidy'); ?></p>
				<form method="post">
				<?php wp_nonce_field( 'action_confirm_tag_tidy', 'nonce_confirm_tag_tidy' ); ?>
					<input type="hidden" name="tidy_post_tags"  value="<?php echo $tidy_post_tags; ?>" />
					<input type="hidden" name="tidy_categories" value="<?php echo $tidy_categories; ?>" />
				<?php submit_button(__( 'Let\'s Do it!', 'category-tag-tidy' ), 'primary', 'tag-tidy' ); ?>
				<input type="button" name="cancel" value="Cancel" class="button" onClick="window.location='tools.php?page=category-tag-tidy';" />			
				</form>
				</div>
			<?php

			}
		}

		/* action has been confirmed - continue processing */
		if ( isset( $_POST['nonce_confirm_tag_tidy'] ) &&  wp_verify_nonce( $_POST['nonce_confirm_tag_tidy'], 'action_confirm_tag_tidy' ) ) {
			
			$tidy_post_tags = $this->sanitize_check_box($_POST['tidy_post_tags']);
			$tidy_categories = $this->sanitize_check_box($_POST['tidy_categories']);

			if ( is_multisite() && is_network_admin() ) 
				$network_blogs = $this->get_sites();
			else
				$network_blogs = array ( array('blog_id' => get_current_blog_id()) );
			
			foreach( $network_blogs as $site ) {
				if (array_key_exists('domain',$site)) 
					echo '<h3>' . $site['domain'] . '</h3>';
					echo '<div style="margin-left: 40px;">';

				if ($tidy_categories) {
					echo '<p>';
					_e('Processing post categories: ', 'category-tag-tidy');
					$num_deleted_terms = $this->process_terms('category',$site['blog_id']);
					if ($num_deleted_terms == 1) 
						/* translators: %d is replaced with the number 1 (for one term deleted) */
						printf( __( '%d term deleted',  'category-tag-tidy' ), $num_deleted_terms );
					else 
						/* translators: %d is replaced with number of deleted terms */
						printf( __( '%d terms deleted', 'category-tag-tidy' ), $num_deleted_terms );
					echo '</p>';
				}

				if ($tidy_post_tags) {
					echo '<p>';
						_e('Processing post tags: ', 'category-tag-tidy');
					$num_deleted_terms = $this->process_terms('post_tag',$site['blog_id']);
					if ($num_deleted_terms == 1) 
						printf( __( '%d term deleted', 'category-tag-tidy' ), $num_deleted_terms );
					else 
						printf( __( '%d terms deleted', 'category-tag-tidy' ), $num_deleted_terms );
					echo '</p>';
				}
				echo '</div>';
			
			}
			
		}
		?>
		</div><!-- /.wrap -->
		<?php

	}


	/**
	 * Returns an array of sites for the network
	 * @return array 
	 */
	public  function get_sites( $args = array() ) {

		if ( version_compare( get_bloginfo('version'), '4.6', '>=' ) ) {
			$defaults = array( 'number' => 5000 );
			$args = wp_parse_args( $args, $defaults );
			$args = apply_filters( 'msfaq_get_sites_args', $args );
			$sites = get_sites( $args );
			foreach( $sites as $key => $site ) {
				$sites[$key] = (array) $site;
			}
			return $sites;
		} else {
			$defaults = array( 'limit' => 5000 );
			$args = apply_filters( 'msfaq_get_sites_args', $args );
			$args = wp_parse_args( $args, $defaults );
			return wp_get_sites( $args );
		}

	}


	/**
	 * Processes all the empty terms
	 *
	 * @param string $taxonomy          the name of the taxonomy
	 * @param int $blog_id              the blog id
	 * @return int $num_deleted_terms   the number of deleted terms
	 */
	public function process_terms($taxonomy,$blog_id) {
		global $wpdb;
		$prefix = $wpdb->get_blog_prefix($blog_id);
		$num_deleted_terms = 0;
	
		$terms = $wpdb->get_results( $wpdb->prepare( 
			"
				SELECT t.term_id, t.name
				FROM {$prefix}terms t
				JOIN {$prefix}term_taxonomy tt
				ON t.term_id = tt.term_id
				And tt.taxonomy = %s
			",
			$taxonomy 
			) );

		if ($taxonomy == 'category') {
			foreach ($terms as $term) {
				$term_deleted = $this->process_category($term,$blog_id);
				if ($term_deleted) {
					$num_deleted_terms++;
				}
			}
		}
		else {
			foreach ($terms as $term) {
				$term_deleted = $this->process_tag($term,$blog_id);
				if ($term_deleted) {
					$num_deleted_terms++;
				}
			}	
		}
		
		return $num_deleted_terms;
	}


	/**
	 * Processes the tag
	 *
	 * @param  stdClass  $term            class containing term.id and term.name
	 * @return bool      $term_deleted    indicates if term was deleted
	 */
	public function process_tag ($term,$blog_id) {
		global $wpdb;
		$prefix = $wpdb->get_blog_prefix($blog_id);   //  fix for multisite

		$term_deleted = false;

		$posts_exist = $wpdb->get_results ( $wpdb->prepare( 
			"
				SELECT object_id
				FROM   {$prefix}term_relationships tr
		WHERE  tr.term_taxonomy_id = %s
			", 
			$term->term_id 
			) );

		if (!$posts_exist) {
		
			$this->delete_term($term->term_id,$term->name,'post_tag',$blog_id);
			$term_deleted = true;
		}

		return $term_deleted;
	}


	/**
	 * Processes the category - checks for child categories with posts before deletion
	 *
	 * @param  stdClass $term           class containing term.id and term.name
	 * @return bool     $term_deleted   indicates if term was deleted
	 */
	public function process_category($term,$blog_id) {
		global $wpdb;

		$prefix = $wpdb->get_blog_prefix($blog_id);

		$term_deleted = false;
		
		$child_terms = $wpdb->get_results( $wpdb->prepare( 
			"
				SELECT tt.term_id, t.name
				FROM   {$prefix}term_taxonomy tt
				JOIN   {$prefix}terms t on t.term_id = tt.term_id
				WHERE  tt.parent = %s
			", 
			$term->term_id 
			) );
			
			
		if ($child_terms) { 
			foreach ($child_terms as $child) {
				/* run this function recursively for the child category */
				$this->process_category($child,$blog_id);
			}
		}
		else {
			/* there are no  child categories */
			/* check if there are posts for this category */
			$posts_exist = $wpdb->get_results ( $wpdb->prepare( 
				"
					SELECT object_id
					FROM   {$prefix}term_relationships tr
					WHERE  tr.term_taxonomy_id = %s
				", 
				$term->term_id 
				) );

			if (!$posts_exist) {
				$this->delete_term($term->term_id,$term->name,'category',$blog_id);
				$term_deleted = true;
			}
		}

		return $term_deleted;
	}


	/**
	 * Deletes the passed in term - tag or category
	 *
	 * @param int    $term_id    the term ID
	 * @param string $name       the term name
	 * @param string $taxonomy   the taxonomny - post_tag or category
	 */
	public function delete_term($term_id,$name,$taxonomy,$blog_id) {
		
		global $wpdb;
		$prefix = $wpdb->get_blog_prefix($blog_id);

		if ($taxonomy == 'category') {
			/* first check to see if exists as it may have already been deleted */
			$term_exists = $wpdb->get_var( $wpdb->prepare( 
				"
					SELECT term_id
					FROM   {$prefix}terms
					WHERE  term_id = %d
				", 
				$term_id 
				) );
		}
		else {
			/* no need to check for deletion if post_tag */
			$term_exists = true;
		}
		
		if ($term_exists) {

			$test_mode = false;

			if (!$test_mode) {
			
				/* Remove the associated record from term_taxonomy table */
				$rows_deleted = $wpdb->query( $wpdb->prepare(
					"
						DELETE 
						FROM   {$prefix}term_taxonomy
						WHERE  term_id = %d
					", 
					$term_id
					) );

				/* Remove the associated record from termmeta table */
				$rows_deleted = $wpdb->query( $wpdb->prepare(
					"
						DELETE 
						FROM   {$prefix}termmeta
						WHERE  term_id = %d
					", 
					$term_id
					) );

				/* Remove the associated record from terms table */
				$rows_deleted = $wpdb->query( $wpdb->prepare(
					"
						DELETE 
						FROM   {$prefix}terms
						WHERE  term_id = %d
					", 
					$term_id
					) );
			}
		}
	}
}
