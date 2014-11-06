<?php

/**
 * Description of ExhibitionCategory
 *
 * @author chec2chec
 */

class ExhibitionCategory {       
    //------------------------------------------------------------------------------
    /**
    * Creating Exhibition category custom fields.
    */
    public static function add_extra_fields_to_exhibition_category($taxonomy_name){
	if (get_bloginfo('version') >= 3.5){
            wp_enqueue_media();
        } else {
            wp_enqueue_style('thickbox');
            wp_enqueue_script('thickbox');
	}
        
        wp_enqueue_script( 'upload_image', plugins_url('/js/upload_image.js',dirname(__FILE__) ));

        wp_localize_script( 'upload_image', 'php_vars', [
            'wp_version'        => get_bloginfo('version'),
            'image_placeholder' => self::get_image_placeholder(),
        ]);
        wp_enqueue_script( 'upload_image' );
        
        ?>
        <div class="form-field">
            <label>Category Image<br/>
                <input class="z_upload_image_button" type="text" name="taxonomy_image" id="taxonomy_image" 
                    value="<?php echo self::taxonomy_image_url(NULL, NULL, TRUE)?>" style="width: 74%"/>
                <span style="width: 1%"></span>
                <button class="z_remove_image_button button" style="width: 20%"><?php _e('Remove', 'zci'); ?></button><br/>
                <img class="taxonomy-image" 
                    src="<?php echo self::taxonomy_image_url(NULL, NULL, TRUE)?>" alt="Thumbnail" width="100"/>
            </label>
            <p>Click here and choose or browse a image.</p>
        </div>
        <div class="form-field">
            <label>Public
                <select name="taxonomy_public">
                    <option value="false">No</option>
                    <option value="true">Yes</option>
                </select>
            </label>            
        </div>
        <?php
    }
    
    public static function edit_extra_fields_to_exhibition_category($taxonomy){
	if (get_bloginfo('version') >= 3.5){
            wp_enqueue_media();
        } else {
            wp_enqueue_style('thickbox');
            wp_enqueue_script('thickbox');
	}
        
        wp_enqueue_script( 'upload_image', plugins_url('/js/upload_image.js',dirname(__FILE__) ));

        wp_localize_script( 'upload_image', 'php_vars', [
            'wp_version'        => get_bloginfo('version'),
            'image_placeholder' => self::get_image_placeholder(),
            'image_url'         => self::taxonomy_image_url($taxonomy->term_id, NULL, TRUE),
        ]);
        wp_enqueue_script( 'upload_image' );
        
        ?>
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="taxonomy_image">
                    <?php _e('Category image', 'zci'); ?><br/><br/>
                    <img class="taxonomy-image" 
                        src="<?php echo self::taxonomy_image_url($taxonomy->term_id, NULL, TRUE)?>" alt="Thumbnail" width="100"/>
                </label>
            </th>
            <td valign="top" style="vertical-align: baseline; width: auto;">
                <input class="z_upload_image_button" type="text" name="taxonomy_image" id="taxonomy_image" 
                    value="<?php echo self::taxonomy_image_url($taxonomy->term_id, NULL, TRUE)?>" style="width: 74%"/>
                <span style="width: 1%"></span>
                <button class="z_remove_image_button button" style="width: 20%"><?php _e('Remove', 'zci'); ?></button>
            </td>
        <tr class="form-field">
	</tr>
            <th scope="row">
                <label for="taxonomy_public">Public</label>
            </th>
            <td>
                <select name="taxonomy_public" id="taxonomy_public">
                    <?php $taxonomy_public = get_option('taxonomy_public_'.$taxonomy->term_id);?>
                    <option value="false" <?php if($taxonomy_public == "false"){ echo "selected";}?>>No</option>
                    <option value="true" <?php if($taxonomy_public == "true"){ echo "selected";}?>>Yes</option>
                </select>
            </td>
	</tr>
        <?php
    }
    
    public static function exhibition_category_taxonomy_columns($columns){ 
	$new_columns = array();
	$new_columns['cb'] = $columns['cb'];
	$new_columns['thumb'] = __('Image', 'zci');
        $new_columns['name'] = $columns['name'];
        $new_columns['description'] = $columns['description'];
        $new_columns['slug'] = $columns['slug'];
        $new_columns['posts'] = $columns['posts'];
        $new_columns['public'] = __('Public', 'zci');
        
	unset( $columns['cb'] );
	unset( $columns['name'] );
	unset( $columns['description'] );
	unset( $columns['slug'] );
	unset( $columns['posts'] );

        return array_merge( $new_columns, $columns );
    }
    
    public static function exhibition_category_taxonomy_thumb_column($columns, $column, $id){
	if ( $column == 'thumb' ){
            $columns = '<span><img src="'.self::taxonomy_image_url($id, NULL, TRUE).'" alt="' . __('Thumbnail', 'zci') . '" class="wp-post-image" width="100"/></span>';
        }
	
	return $columns;
    }
    
    public static function exhibition_category_taxonomy_public_column($columns, $column, $id){
	if ( $column == 'public' ){
            $taxonomy_public = get_option('taxonomy_public_'.$id);
            $taxonomy_val = ($taxonomy_public == "true" ? "Yes" : "No"); 
            $columns = '<span>'.$taxonomy_val.'</span>';
        }
	
	return $columns;
    }
    
    private static function get_image_placeholder() {
        $img_path = plugins_url('images/placeholder.png',dirname(__FILE__) );
        return $img_path;
    }
    
    private static function get_attachment_id_by_url($image_src) {
        global $wpdb;
        $query = "SELECT ID FROM {$wpdb->posts} WHERE guid = '$image_src'";
        $id = $wpdb->get_var($query);
        return (!empty($id)) ? $id : NULL;
    }
    
    // get taxonomy image url for the given term_id (Place holder image by default)
    private static function taxonomy_image_url($term_id = NULL, $size = NULL, $return_placeholder = FALSE) {
	if (!$term_id) {
            if (is_category()) {
                $term_id = get_query_var('cat');
            } elseif (is_tax()) {
                $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
                $term_id = $current_term->term_id;
            }
	}
        	
        $taxonomy_image_url = get_option('z_taxonomy_image_'.$term_id);
        if(!empty($taxonomy_image_url)) {
            $attachment_id = self::get_attachment_id_by_url($taxonomy_image_url);
            if(!empty($attachment_id)) {
                if (empty($size)) {
                    $size = 'full';
                }
                $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
                $taxonomy_image_url = $taxonomy_image_url[0];
            }
        }

        if ($return_placeholder) {
            return ($taxonomy_image_url != '') ? $taxonomy_image_url : self::get_image_placeholder();
        } else {
            return $taxonomy_image_url;
        }
    }
    
    private static function exhibition_save_taxonomy_image($term_id) {
        if(isset($_POST['taxonomy_image'])) {
            update_option('z_taxonomy_image_'.$term_id, $_POST['taxonomy_image']);
        }
    }
    
    private static function exhibition_save_taxonomy_public_field($term_id) {
        if(isset($_POST['taxonomy_public'])) {
            update_option('taxonomy_public_'.$term_id, $_POST['taxonomy_public']);
        }
    }
    
    public static function exhibition_save_taxonomy_custom_fields($term_id) {
        self::exhibition_save_taxonomy_image($term_id);
        self::exhibition_save_taxonomy_public_field($term_id);
    }
    
    public static function quick_edit_custom_box( $column_name, $screen, $name ) {
        $data = ['column_name'=>$column_name, 'screen'=>$screen, 'name'=>$name];
        //var_dump($data);
        if ($column_name == 'thumb') {
            echo '<fieldset>
		<div class="thumb inline-edit-col">
                    <label>
                        <span class="title"><img src="" alt="Thumbnail"/></span>
                        <span class="input-text-wrap">
                            <input type="text" name="taxonomy_image" value="" class="tax_list z_upload_image_button" style="width: 78%"/>
                            <button class="z_remove_image_button button" style="width: 20%; margin-left: 1%">' . __('Remove', 'zci') . '</button>
                        </span>
                    </label>
		</div>
            </fieldset>';
        }
    }
}
