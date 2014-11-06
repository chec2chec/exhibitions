<?php
/*
Plugin Name: Exhibitions
Plugin URI: http://expoartgallery.com
Description: Display paintings organized in exhibitions.
Author: Ivan Simeonov
Version: 0.1
Author URI: http://ivansimeonoff.wordpress.com
*/
include_once('includes/Exhibitions.php');
include_once('includes/ExhibitionCategory.php');

add_action( 'init', 'Exhibitions::register_paintings_post_type');
add_action( 'init', 'Exhibitions::register_paintings_taxonomies');
add_action( 'admin_enqueue_scripts', 'Exhibitions::enqueue_add_painting_javascript', 10, 1 );
add_action( 'add_meta_boxes', 'Exhibitions::create_paintings_meta_boxes' );
add_action( 'save_post', 'Exhibitions::save_painting_meta' );
add_action( 'exhibition_category_add_form_fields', 'ExhibitionCategory::add_extra_fields_to_exhibition_category' );

add_action( 'exhibition_category_add_form_fields', 'ExhibitionCategory::add_extra_fields_to_exhibition_category' );
add_action( 'exhibition_category_edit_form_fields', 'ExhibitionCategory::edit_extra_fields_to_exhibition_category' );
add_filter( 'manage_edit-exhibition_category_columns', 'ExhibitionCategory::exhibition_category_taxonomy_columns' );
add_filter( 'manage_exhibition_category_custom_column', 'ExhibitionCategory::exhibition_category_taxonomy_thumb_column', 10, 3 );
add_filter( 'manage_exhibition_category_custom_column', 'ExhibitionCategory::exhibition_category_taxonomy_public_column', 10, 3 );
add_action( 'edit_term','ExhibitionCategory::exhibition_save_taxonomy_custom_fields' );
add_action( 'create_term','ExhibitionCategory::exhibition_save_taxonomy_custom_fields' );

if ( strpos( $_SERVER['SCRIPT_NAME'], 'edit-tags.php' ) > 0 ) {
    //add_action('quick_edit_custom_box', 'ExhibitionCategory::quick_edit_custom_box', 10, 3);
}

/*EOF*/