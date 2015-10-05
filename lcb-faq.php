<?php
/*
Plugin Name: LCB FAQ
Description: Displays questions with answers
Version: 1.1
Author: LeftCurlyBracket
Author URI: http://leftcurlybracket.com
License: MIT
*/

add_action('plugins_loaded', 'lcb_faq_load_textdomain');

function lcb_faq_load_textdomain()
{
    load_plugin_textdomain('lcb-faq', false, dirname(plugin_basename(__FILE__)) . '/languages');
}

include_once 'shortcode.php';

add_action('init', 'lcb_faq_create_post_type');

function lcb_faq_create_post_type()
{
    register_post_type('faq', array(
        'labels' => array(
            'name' => __('Faq', 'lcb-faq'),
            'singular_name' => __('Faq', 'lcb-faq'),
            'add_new' => __('Add new', 'lcb-faq'),
            'add_new_item' => __('Add new question', 'lcb-faq')
        ),
        'public' => true,
        'show_in_nav_menus' => true,
        'show_ui' => true,
        'has_archive' => true,
        'hierarchical' => true,
        'supports' => array('title', 'editor' ),
        )
    );
}

/**
 * Create FAQ's categories
 */

add_action( 'init', 'lcb_faq_create_category' );

function lcb_faq_create_category(){
    $arg = array(
        'label' => __( 'Faq categories', 'lcb-faq' ),
	'hierarchical' => true,
    );
    register_taxonomy( 'faq-category', 'faq', $arg );
}

/**
 * Replaces title placeholder
 * 
 * @param string $title
 * @return string $title
 */

function lcb_faq_change_title_text( $title ){
     $screen = get_current_screen();

     if  ( 'faq' == $screen->post_type ) {
          $title = __('Enter question', 'lcb-faq');
     }
 
     return $title;
}
 
add_filter( 'enter_title_here', 'lcb_faq_change_title_text' );

/**
 *  Change title column name to "Question", add categories column
 */

function lcb_faq_columns($columns) {
	
	$new_columns = array(
		'title' => __('Question', 'lcb-faq'),
                'faq-categories' => __('Faq categories', 'lcb-faq')
	);
    return array_merge($columns, $new_columns);
}
add_filter('manage_faq_posts_columns' , 'lcb_faq_columns');

/**
 * Display categories in new column
 */

add_action( 'manage_faq_posts_custom_column' , 'lcb_faq_display_categories_column', 10, 2 );
function lcb_faq_display_categories_column( $column, $post_id ) {
    if ($column == 'faq-categories'){
       echo get_the_term_list( $post_id, 'faq-category', '', ', ' );
    }
}

/**
 * Get FAQ categories array
 * 
 * @return array $categories
 */

function get_faq_categories(){
    $categories = get_terms('faq-category');
    return $categories;
}
