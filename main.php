<?php
/**
 * Plugin Name: Gallery Management
 * Plugin URI: https://edexa.com/en/
 * Description: This plugin create gallery management custome post with front end page..
 * Version: 1.0
 * Author: tahir mansuri
 * Author URI: https://edexa.com/en/
 */
//include files
include( plugin_dir_path( __FILE__ ) . 'include/custom_post_type.php');
/*include js and css*/
add_action( 'wp_enqueue_scripts', 'wpgm_wedding_scripts' );
function wpgm_wedding_scripts() {
  
  wp_enqueue_style( 'wpgm-bootstrap-css', plugin_dir_url(__FILE__) . 'css/bootstrap.css', array(), '3.3.7', 'all');
  wp_enqueue_script( 'wpgm-bootstrap-script', plugin_dir_url(__FILE__)  . 'js/bootstrap.js', array ( 'jquery' ), 3.7, true);
  wp_enqueue_script( 'wpgm-jquery-script', plugin_dir_url(__FILE__)  . 'js/jquery.min.js', array ( 'jquery' ), 3.7, true);
}

/*add template in dropdown*/
add_filter( 'theme_page_templates', 'wpgm_add_page_template_to_dropdown' );
function wpgm_add_page_template_to_dropdown( $templates )
{
   $templates['gallery-template.php'] = __( 'Gallery Management Template', 'text-domain' );
 
   return $templates;
}


/*use template*/
add_filter( 'template_include', 'use_wpgm_page_template', 99 );

function use_wpgm_page_template( $template ) {

    if ( is_page( 'My gallery list' )  ) {
        $new_template =  plugin_dir_path( __FILE__ ) . 'gallery-template.php';
        return $new_template;
    }else{
        return $template;
    }

}
/*plugin active hook*/
register_activation_hook( __FILE__, 'wpgm_plugin_activate' );
function wpgm_plugin_activate(){

    $page_title = 'My gallery list';
    $page_template = 'gallery-template.php'; 

    $page_check = get_page_by_title($page_title);
    $page = array(
            'post_type' => 'page',
            'post_title' => $page_title,
            'post_status' => 'publish',
            'post_author' => 1,
    );

    if(!isset($page_check->ID)){
            $page_id = wp_insert_post($page);
            if (metadata_exists('page', $page_id, '_wp_page_template') === false) {  // Only when meta _wp_page_template is not 
                add_post_meta($page_id, '_wp_page_template', $page_template);
            }
    }


}

/*plugin deactive hook*/
register_deactivation_hook( __FILE__, 'my_plugin_remove_database' );
function my_plugin_remove_database() {
     global $wpdb;
     
     $page = get_page_by_path( 'My gallery list' );
     wp_delete_post($page->ID,true);
}


add_action('wp_ajax_load_gallery_data', 'load_gallery_data_act');
add_action('wp_ajax_nopriv_load_gallery_data', 'load_gallery_data_act');

function load_gallery_data_act(){
global $wpdb;
$cat_slug =$_POST['cat_slug'];
$html='<style>.content {
display: none;
}</style><div class="row" >';
wp_reset_query();
$args = array('post_type' => 'gallery',
              //'posts_per_page' => '3',
       'tax_query' => array(
        array(
            'taxonomy' => 'gallery-category',
            'field' => 'slug',
            'terms' => $cat_slug,
        ),
    ),
 );

 $loop = new WP_Query($args);
 if($loop->have_posts()) {
    

    while($loop->have_posts()) : $loop->the_post();
        $html .= '<div class="col-md-4 content">
              <div class="thumbnail">
                <a href="'.wp_get_attachment_url( get_post_thumbnail_id() ).'" target="_blank">
                  <img src="'.wp_get_attachment_url( get_post_thumbnail_id() ).'"  style="width:100%;height: 167px;">
                  
                </a>
              </div>
            </div>';
    endwhile;
 }else{
 	 $html .= '<div class="col-md-4">
              <div class="thumbnail">
                No data found.
              </div>
            </div>';
 }
 $html .='</div>';
$return['html'] = $html;

echo json_encode($return, true);    
die();
}


