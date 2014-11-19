<?php
/*
Plugin Name: Exhibitions
Plugin URI: http://expoartgallery.com
Description: Display paintings organized in exhibitions.
Author: Ivan Simeonov
Version: 0.1
Author URI: http://ivansimeonoff.wordpress.com
*/
include_once('includes/Utils.php');
include_once('includes/Exhibitions.php');
include_once('includes/ExhibitionCategory.php');
include_once('includes/ExhibitionAuthors.php');

add_action( 'init', 'Exhibitions::register_paintings_post_type');
add_action( 'init', 'Exhibitions::register_custom_taxonomies');
add_action( 'admin_enqueue_scripts', 'Exhibitions::enqueue_add_painting_javascript', 10, 1 );
add_action( 'add_meta_boxes', 'Exhibitions::create_paintings_meta_boxes' );
add_action( 'save_post', 'Exhibitions::save_painting_meta' );
// uncomment if using slashes in your taxonomy slugs
/*
if ( ! is_admin() ) {
    add_filter( 'rewrite_rules_array', 'Exhibitions::takien_custom_tax1_slug_forward_slash',100);
    add_filter( 'rewrite_rules_array', 'Exhibitions::takien_custom_tax2_slug_forward_slash',101);
}
 */
add_action( 'exhibition_category_add_form_fields', 'ExhibitionCategory::add_extra_fields_to_exhibition_category' );
add_action( 'exhibition_category_edit_form_fields', 'ExhibitionCategory::edit_extra_fields_to_exhibition_category' );
add_filter( 'manage_edit-exhibition_category_columns', 'ExhibitionCategory::exhibition_category_taxonomy_columns' );
add_filter( 'manage_exhibition_category_custom_column', 'ExhibitionCategory::exhibition_category_taxonomy_thumb_column', 10, 3 );
add_filter( 'manage_exhibition_category_custom_column', 'ExhibitionCategory::exhibition_category_taxonomy_public_column', 10, 3 );
add_action( 'edit_term','ExhibitionCategory::exhibition_save_taxonomy_custom_fields' );
add_action( 'create_term','ExhibitionCategory::exhibition_save_taxonomy_custom_fields' );

add_action( 'exhibition_authors_add_form_fields', 'ExhibitionAuthors::add_extra_fields_to_exhibition_authors' );
add_action( 'exhibition_authors_edit_form_fields', 'ExhibitionAuthors::edit_extra_fields_to_exhibition_authors' );
add_filter( 'manage_edit-exhibition_authors_columns', 'ExhibitionAuthors::exhibition_authors_taxonomy_columns' );
add_filter( 'manage_exhibition_authors_custom_column', 'ExhibitionAuthors::exhibition_authors_taxonomy_thumb_column', 10, 3 );
add_action( 'edit_term','ExhibitionAuthors::exhibition_save_taxonomy_custom_fields' );
add_action( 'create_term','ExhibitionAuthors::exhibition_save_taxonomy_custom_fields' );

if ( strpos( $_SERVER['SCRIPT_NAME'], 'edit-tags.php' ) > 0 ) {
    // TODO: add custom quick edit
    //add_action('quick_edit_custom_box', 'ExhibitionCategory::quick_edit_custom_box', 10, 3);
}

/*EOF*/