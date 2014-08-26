<?php
/*
Plugin Name: Exhibitions
Plugin URI: http://example.com
Description: Keeps track of a music collection by album,
artist, and genre.
Version: 0.1
Author: WROX
Author URI: http://wrox.com
*/

/* Set up the post types. */
add_action( 'init', 'boj_exhibitions_register_post_types');
/* Registers post types. */
function boj_exhibitions_register_post_types() {
	/* Set up the arguments for the 'exhibitions' post type. */
	$exhibitions_args = array(
		'public' => true,
		'query_var' => 'exhibitions',
		'rewrite' => array(
			'slug' => 'exhibitions/paintings',
			'with_front' => false,
		),
		'supports' => array(
			'title',
			'thumbnail'
		),
		'labels' => array(
			'name' => 'Paintings',
			'singular_name' => 'Painting',
			'add_new' => 'Add New Painting',
			'add_new_item' => 'Add New Painting',
			'edit_item' => 'Edit Painting',
			'new_item' => 'New Painting',
			'view_item' => 'View Painting',
			'search_items' => 'Search Paintings',
			'not_found' => 'No Paintings Found',
			'not_found_in_trash' => 'No Paintings Found In Trash'
		),
	);
	/* Register the music album post type. */
	register_post_type( 'exhibitions', $exhibitions_args );
}

/* Set up the taxonomies. */
add_action( 'init', 'boj_exhibitions_register_taxonomies');
/* Registers taxonomies. */
function boj_exhibitions_register_taxonomies() {
/* Set up the artist taxonomy arguments. */
	$artist_args = array(
		'hierarchical' => false,
		'query_var' => 'exhibition_artist',
		'show_tagcloud' => true,
		'rewrite' => array(
			'slug' => 'exhibitions/artists',
			'with_front' => false
		),
		'labels' => array(
			'name' => 'Artists',
			'singular_name' => 'Artist',
			'edit_item' => 'Edit Artist',
			'update_item' => 'Update Artist',
			'add_new_item' => 'Add New Artist',
			'new_item_name' => 'New Artist Name',
			'all_items' => 'All Artists',
			'search_items' => 'Search Artists',
			'popular_items' => 'Popular Artists',
			'separate_items_with_commas' => 'Separate artists with commas',
			'add_or_remove_items' => 'Add or remove artists',
			'choose_from_most_used' => 'Choose from the most popular artists',
		),
	);
	/* Set up the category taxonomy arguments. */
	$exhibition_args = array(
		'hierarchical' => false,
		'query_var' => 'exhibition_category',
		'show_tagcloud' => true,
		'rewrite' => array(
			'slug' => 'exhibitions',
			'with_front' => false
		),
		'labels' => array(
			'name' => 'Exhibitions',
			'singular_name' => 'Exhibition',
			'edit_item' => 'Edit Exhibition',
			'update_item' => 'Update Exhibition',
			'add_new_item' => 'Add New Exhibition',
			'new_item_name' => 'New Exhibition Name',
			'all_items' => 'All Exhibitions',
			'search_items' => 'Search Exhibition',
			'parent_item' => 'Parent Exhibition',
			'parent_item_colon' => 'Parent Exhibition:',
		),
	);
	/* Register the album artist taxonomy. */
	register_taxonomy( 'exhibition_artist', array( 'exhibitions' ), $artist_args );
	/* Register the album genre taxonomy. */
	register_taxonomy( 'exhibition_category', array( 'exhibitions' ), $exhibition_args );
	/* Register admin javascript */
	wp_register_script( 'my-plugin-script', plugins_url( 'js/validation.js', __FILE__ ), array('jquery'), 0.01, false );
}

/* Adding custom javascript */
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );
function add_admin_scripts( $hook ) {
    global $post;

    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'exhibitions' === $post->post_type ) {     
			wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'my-plugin-script' );
        }
    }
}

add_action( 'add_meta_boxes', 'boj_mbe_create' );
function boj_mbe_create() {
	//create a custom meta box
	add_meta_box( 'boj-meta', 'Painting Details', 'boj_mbe_function', 'exhibitions', 'normal', 'high' );
}

function boj_mbe_function( $post ) {
	//retrieve the metadata values if they exist
	$boj_mbe_image = get_post_meta( $post->ID, '_boj_mbe_image', true );
	$boj_mbe_public = get_post_meta( $post->ID, '_boj_mbe_public', true );
	$boj_mbe_type = get_post_meta( $post->ID, '_boj_mbe_type', true );
	$boj_mbe_price = get_post_meta( $post->ID, '_boj_mbe_price', true );
	$boj_mbe_size_height = get_post_meta( $post->ID, '_boj_mbe_size_height', true );
	$boj_mbe_size_width = get_post_meta( $post->ID, '_boj_mbe_size_width', true );
	$boj_mbe_size_depth = get_post_meta( $post->ID, '_boj_mbe_size_depth', true );
	$boj_mbe_border_size_height = get_post_meta( $post->ID, '_boj_mbe_border_size_height', true );
	$boj_mbe_border_size_width = get_post_meta( $post->ID, '_boj_mbe_border_size_width', true );

	/*
	$test = array(
				$boj_mbe_image,
				$boj_mbe_public,
				$boj_mbe_type,
				$boj_mbe_price,
				$boj_mbe_size_height,
				$boj_mbe_size_width,
				$boj_mbe_border_size_height,
				$boj_mbe_border_size_width
			);
	*/

	$screen = get_current_screen();
	
	//echo '<pre>' .print_r(get_current_screen(), true). '</pre>';
	
	
	
	
	?>
	
	<table class="form-table">
		<tr valign="top">
			<th>
				Use image exhibition cover:
			</th>
			<td>
				<label>
					Yes <input type="radio" name="boj_mbe_image" value="true" <?php echo ($boj_mbe_image == 'true')? 'checked="checked"':''; ?> />
				</label> <label>
					No <input type="radio" name="boj_mbe_image" value="false" <?php echo ($boj_mbe_image == 'false' || $screen->action == 'add')? 'checked="checked"':''; ?> />
				</label>
			</td>
		</tr>
		<tr valign="top">
			<th>
				Public:
			</th>
			<td>
				<label>
					Yes <input type="radio" name="boj_mbe_public" value="true" <?php echo ($boj_mbe_public == 'true')? 'checked="checked"':''; ?> />
				</label> <label>
					No <input type="radio" name="boj_mbe_public" value="false" <?php echo ($boj_mbe_public == 'false' || $screen->action == 'add')? 'checked="checked"':''; ?> />
				</label>
			</td>
		</tr>
		<tr valign="top">
			<th>
				Type:
			</th>
			<td>
				<label>
					Painting <input type="radio" name="boj_mbe_type" value="true" <?php echo ($boj_mbe_type == 'true' || $screen->action == 'add')? 'checked="checked"':''; ?> />
				</label> <label>
					Sculpture <input type="radio" name="boj_mbe_type" value="false" <?php echo ($boj_mbe_type == 'false')? 'checked="checked"':''; ?> />
				</label>
			</td>
		</tr>
		<tr valign="top" id="boj_mbe_dimensions">
			<th>
				Size:
			</th>
			<td>
				<input type="text" name="boj_mbe_size_height" value="<?php echo esc_attr( $boj_mbe_size_height ); ?>" />
				 x 
				<input type="text" name="boj_mbe_size_width" value="<?php echo esc_attr( $boj_mbe_size_width ); ?>" />
				<span id="boj_mbe_depth">x <input type="text" name="boj_mbe_size_depth" value="<?php echo esc_attr( $boj_mbe_size_depth ); ?>" /></span>
			</td>
		</tr>
		<tr valign="top" id="boj_mbe_type">
			<th>
				Border Size:
			</th>
			<td>
				<input type="text" name="boj_mbe_border_size_height" value="<?php echo esc_attr( $boj_mbe_border_size_height ); ?>" />
				x <input type="text" name="boj_mbe_border_size_width" value="<?php echo esc_attr( $boj_mbe_border_size_width ); ?>" />
			</td>
		</tr>
		<tr valign="top">
			<th>
				Price:
			</th>
			<td>
				<input type="text" name="boj_mbe_price" value="<?php echo $boj_mbe_price; ?>" />
			</td>
		</tr>
	</table>

	<?php
}

//hook to save the meta box data
add_action( 'save_post', 'boj_mbe_save_meta' );

function boj_mbe_save_meta( $post_id ) {	
	//verify the metadata is set	
	if (!empty($_POST)) {
		//save the metadata
		$allowed = array('true','false');
		
		if ( isset($_POST['boj_mbe_image']) && $_POST['boj_mbe_image'] != null ) {
			$safe_image = strip_tags($_POST['boj_mbe_image']);
			if( in_array($safe_image, $allowed)) {
				update_post_meta( $post_id, '_boj_mbe_image', $safe_image );
			}else{
				update_post_meta( $post_id, '_boj_mbe_image', '' );
			}
		}
		
		if ( isset($_POST['boj_mbe_public']) && $_POST['boj_mbe_public'] != null ) {
			$safe_public = strip_tags($_POST['boj_mbe_public']);
			if( in_array($safe_public, $allowed)) {
				update_post_meta( $post_id, '_boj_mbe_public', $safe_public );
			}else{
				update_post_meta( $post_id, '_boj_mbe_public', '' );
			}
		}
		
		if ( isset($_POST['boj_mbe_type']) && $_POST['boj_mbe_type'] != null ) {
			$safe_type = strip_tags($_POST['boj_mbe_type']);
			if( in_array($safe_public, $allowed)) {
				update_post_meta( $post_id, '_boj_mbe_type', $safe_type );
			}else{
				update_post_meta( $post_id, '_boj_mbe_type', '' );
			}
		}
		
		function validateNumber($number) {
			$check = preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", $number);
			if($check == true) {
				return $number;
			} else {
				return '';
			}
		}

		if ( isset($_POST['boj_mbe_size_height']) && $_POST['boj_mbe_size_height'] != null ) {
			$safe_size_height = validateNumber($_POST['boj_mbe_size_height']);
			update_post_meta( $post_id, '_boj_mbe_size_height', $safe_size_height );
		}
		
		if ( isset($_POST['boj_mbe_size_width']) && $_POST['boj_mbe_size_width'] != null ) {
			$safe_size_width = validateNumber($_POST['boj_mbe_size_width']);
			update_post_meta( $post_id, '_boj_mbe_size_width', $safe_size_width );
		}
		
		if ( isset($_POST['boj_mbe_size_depth']) && $_POST['boj_mbe_size_depth'] != null ) {
			$safe_size_depth = validateNumber($_POST['boj_mbe_size_depth']);
			update_post_meta( $post_id, '_boj_mbe_size_depth', $safe_size_depth );
		}
		
		if ( isset($_POST['boj_mbe_border_size_height']) && $_POST['boj_mbe_border_size_height'] != null ) {
			$safe_border_size_height = validateNumber($_POST['boj_mbe_border_size_height']);
			update_post_meta( $post_id, '_boj_mbe_border_size_height', $safe_border_size_height );
		}

		if ( isset($_POST['boj_mbe_border_size_width']) && $_POST['boj_mbe_border_size_width'] != null ) {
			$safe_border_size_width = validateNumber($_POST['boj_mbe_border_size_width']);
			update_post_meta( $post_id, '_boj_mbe_border_size_width', $save_border_size_width );
		}
		
		if ( isset($_POST['boj_mbe_price']) && $_POST['boj_mbe_price'] != null ) {
			$safe_price = validateNumber($_POST['boj_mbe_price']);
			update_post_meta( $post_id, '_boj_mbe_price', $safe_price );
		}
	}
}
?>