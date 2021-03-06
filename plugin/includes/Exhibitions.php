<?php
class Exhibitions {
    // Used to uniquely identify this plugin's menu page in the WP manager
    const admin_menu_slug = 'content_chunks';
    const default_shortcode_name = 'get-chunk';
    const option_key = 'content_chunks_shortcode';

    //------------------------------------------------------------------------------
    /**
    * Register the custom post type so it shows up in menus
    */
    public static function register_paintings_post_type()
    {
        register_post_type( 'paintings', 
            array(
                'public' => true,
                'has_archive' => true,
                'query_var' => 'paintings',
                'rewrite' => array(
                    'slug' => 'paintings',
                    //'with_front' => false,
                ),
                'supports' => array(
                    'title',
                    'thumbnail'
                ),
                'label' => 'Paintings',
                'labels' => array(
                    'add_new' 			=> 'Add New',
                    'add_new_item'		=> 'Add New Painting',
                    'edit_item'			=> 'Edit Painting',
                    'new_item'			=> 'New Painting',
                    'view_item'			=> 'View Painting',
                    'search_items'		=> 'Search Paintings',
                    'not_found'			=> 'No paintings Found',
                    'not_found_in_trash'=> 'Not Found in Trash',
                ),
                'description' => 'Display paintings organized in exhibitions',
                'show_ui' => true,
                'menu_icon' => WP_CONTENT_URL. '/plugins/exhibitions/images/body-painting-gallery-icon.png',
                'menu_position' => 3,
            )
        );
    }

    //------------------------------------------------------------------------------
    /**
    * Register the custom taxonomies.
    */
    public static function register_custom_taxonomies()
    {
        self::register_exhibition_authors_taxonomy();
        self::register_exhibition_category_taxonomy();
    }
    
    private static function register_exhibition_authors_taxonomy()
    {
        /* Set up the artist taxonomy arguments. */
        $authors_args = array(
            'hierarchical' => true,
            'query_var' => true,
            'show_tagcloud' => false,
            'rewrite' => array(
                'slug' => 'authors',
                //'with_front' => false,
            ),
            'labels' => array(
                'name' => 'Authors',
                'singular_name' => 'Author',
                'edit_item' => 'Edit Author',
                'update_item' => 'Update Author',
                'add_new_item' => 'Add New Author',
                'new_item_name' => 'New Author Name',
                'all_items' => 'All Authors',
                'search_items' => 'Search Authors',
                'popular_items' => 'Popular Authors',
                'separate_items_with_commas' => 'Separate authors with commas',
                'add_or_remove_items' => 'Add or remove authors',
                'choose_from_most_used' => 'Choose from the most popular authors',
            ),
        );
        
        /* Register the album artist taxonomy. */
        register_taxonomy( 'exhibition_authors', array('paintings') , $authors_args );
        flush_rewrite_rules();
    }
        
    private static function register_exhibition_category_taxonomy()
    {        
        /* Set up the category taxonomy arguments. */
        $exhibition_args = array(
            'hierarchical' => true,
            'query_var' => true,
            'show_tagcloud' => false,
            'rewrite' => array(
                'slug' => 'exhibitions',
                //'with_front' => false
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

        /* Register the album genre taxonomy. */
        register_taxonomy( 'exhibition_category', array('paintings') , $exhibition_args );
        flush_rewrite_rules();
    }

    //------------------------------------------------------------------------------
    /**
    * Enqueue javascript files for Add painting page.
    */
    public static function enqueue_add_painting_javascript( $hook )
    {
        global $post;
        /* Register admin javascript */
        wp_register_script( 'my-plugin-script', plugins_url( '../js/validation.js', __FILE__ ), array('jquery'), 0.01, false );

        if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
            if ( 'paintings' === $post->post_type ) {     
                wp_enqueue_script( 'jquery' );
                wp_enqueue_script( 'my-plugin-script' );
            }
        }
    }

    //------------------------------------------------------------------------------
    /**
    * Creating paintings meta boxes.
    */
    public static function create_paintings_meta_boxes()
    {
        //create a custom meta box
        add_meta_box( 'boj-meta', 'Painting Details', 'Exhibitions::create_paintings_details_meta_box', 'paintings', 'normal', 'high' );
    }

    public static function create_paintings_details_meta_box( $post )
    {
        //retrieve the meta data values if they exist
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
                    <input type="text" name="boj_mbe_size_height" size="5" value="<?php echo esc_attr( $boj_mbe_size_height ); ?>" />
                    x 
                    <input type="text" name="boj_mbe_size_width" size="5" value="<?php echo esc_attr( $boj_mbe_size_width ); ?>" />
                    <span id="boj_mbe_depth">x <input type="text" name="boj_mbe_size_depth" size="5" value="<?php echo esc_attr( $boj_mbe_size_depth ); ?>" /></span> cm
                </td>
            </tr>
            <tr valign="top" id="boj_mbe_type">
                <th>
                    Border Size:
                </th>
                <td>
                    <input type="text" name="boj_mbe_border_size_height" size="5" value="<?php echo esc_attr( $boj_mbe_border_size_height ); ?>" />
                    x <input type="text" name="boj_mbe_border_size_width" size="5" value="<?php echo esc_attr( $boj_mbe_border_size_width ); ?>" /> cm
                </td>
            </tr>
            <tr valign="top">
                <th>
                    Price:
                </th>
                <td>
                    <input type="text" name="boj_mbe_price" size="15" value="<?php echo $boj_mbe_price; ?>" />
                </td>
            </tr>
        </table>

        <?php
    }

    public static function save_painting_meta( $post_id )
    {
        self::save_painting_details_meta( $post_id );
    }

    private static function save_painting_details_meta( $post_id )
    {
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

            if ( isset($_POST['boj_mbe_size_height']) && $_POST['boj_mbe_size_height'] != null ) {
                $safe_size_height = Utils::validateNumber($_POST['boj_mbe_size_height']);
                update_post_meta( $post_id, '_boj_mbe_size_height', $safe_size_height );
            }

            if ( isset($_POST['boj_mbe_size_width']) && $_POST['boj_mbe_size_width'] != null ) {
                $safe_size_width = Utils::validateNumber($_POST['boj_mbe_size_width']);
                update_post_meta( $post_id, '_boj_mbe_size_width', $safe_size_width );
            }

            if ( isset($_POST['boj_mbe_size_depth']) && $_POST['boj_mbe_size_depth'] != null ) {
                $safe_size_depth = Utils::validateNumber($_POST['boj_mbe_size_depth']);
                update_post_meta( $post_id, '_boj_mbe_size_depth', $safe_size_depth );
            }

            if ( isset($_POST['boj_mbe_border_size_height']) && $_POST['boj_mbe_border_size_height'] != null ) {
                $safe_border_size_height = Utils::validateNumber($_POST['boj_mbe_border_size_height']);
                update_post_meta( $post_id, '_boj_mbe_border_size_height', $safe_border_size_height );
            }

            if ( isset($_POST['boj_mbe_border_size_width']) && $_POST['boj_mbe_border_size_width'] != null ) {
                $safe_border_size_width = Utils::validateNumber($_POST['boj_mbe_border_size_width']);
                update_post_meta( $post_id, '_boj_mbe_border_size_width', $safe_border_size_width );
            }

            if ( isset($_POST['boj_mbe_price']) && $_POST['boj_mbe_price'] != null ) {
                $safe_price = Utils::validateNumber($_POST['boj_mbe_price']);
                update_post_meta( $post_id, '_boj_mbe_price', $safe_price );
            }
        }
    }
}

/*EOF*/