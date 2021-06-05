<?php
// add gallery custome post
function wpgm_custom_post_type() {
 

    $labels = array(
        'name'                => _x( 'Gallery', 'Post Type General Name', 'gallery_management_plugin' ),
        'singular_name'       => _x( 'Gallery', 'Post Type Singular Name', 'gallery_management_plugin' ),
        'menu_name'           => __( 'Gallery', 'gallery_management_plugin' ),
        'parent_item_colon'   => __( 'Parent Gallery', 'gallery_management_plugin' ),
        'all_items'           => __( 'All Gallery', 'gallery_management_plugin' ),
        'view_item'           => __( 'View Gallery', 'gallery_management_plugin' ),
        'add_new_item'        => __( 'Add New Gallery', 'gallery_management_plugin' ),
        'add_new'             => __( 'Add New', 'gallery_management_plugin' ),
        'edit_item'           => __( 'Edit Gallery', 'gallery_management_plugin' ),
        'update_item'         => __( 'Update Gallery', 'gallery_management_plugin' ),
        'search_items'        => __( 'Search Gallery', 'gallery_management_plugin' ),
        'not_found'           => __( 'Not Found', 'gallery_management_plugin' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'gallery_management_plugin' ),
    );
   $args = array(
        'label'               => __( 'gallery', 'gallery_management_plugin' ),
        'description'         => __( 'Gallery news and reviews', 'gallery_management_plugin' ),
        'labels'              => $labels,
       
        'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ),
        
        'taxonomies'          => array( 'genres' ),
        
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 5,
        'menu_icon'           => 'dashicons-format-gallery',
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true,
 
    );
     
   
    register_post_type( 'gallery', $args );
 
}
 
add_action( 'init', 'wpgm_custom_post_type', 0 );

//add custome taxonomy for gallery post
add_action( 'init', 'create_subjects_hierarchical_taxonomy', 0 );
function create_subjects_hierarchical_taxonomy() {
 $labels = array(
    'name' => _x( 'Gallery Categories', 'taxonomy general name' ),
    'singular_name' => _x( 'Gallery Category', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Gallery Categories' ),
    'all_items' => __( 'All Gallery Categories' ),
    'parent_item' => __( 'Parent Gallery Category' ),
    'parent_item_colon' => __( 'Parent Gallery Category:' ),
    'edit_item' => __( 'Edit Gallery Category' ), 
    'update_item' => __( 'Update Gallery Category' ),
    'add_new_item' => __( 'Add New Gallery Category' ),
    'new_item_name' => __( 'New Gallery Category Name' ),
    'menu_name' => __( 'Gallery Categories' ),
  );    
 
// Now register the taxonomy
  register_taxonomy('gallery-category',array('gallery'), array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_in_rest' => true,
    'show_admin_column' => true,
    'query_var' => true,
    'rewrite' => array( 'slug' => 'gallery-category' ),
  ));
 
}