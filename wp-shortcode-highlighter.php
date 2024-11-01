<?php
/*
Plugin Name: WP Shortcode Highlighter
Plugin URI: 
Description: Highlights the shortcodes in the editor so they are easier to see.
Author: Roland Murg 
Version: 1.0
*/

add_filter( 'mce_css', 'wpsh_custom_mce_style' );
function wpsh_custom_mce_style( $mce_css ) {
	if ( ! empty( $mce_css ) )
		$mce_css .= ',';
	$mce_css .= plugins_url( 'assets/css/wp-shortcode-highlighter-editor.css', __FILE__ ) . ',' . admin_url('admin-ajax.php') ."/?action=wpsh_dynamic_styles";
	return $mce_css;
}
require('inc/dynamic-css.php');

register_activation_hook( __FILE__, 'wpsh_activate' );
function wpsh_activate() {
    add_option( 'wpsh_background_color', '#f5f5f5' );
	add_option( 'wpsh_border_color', '#dddddd' );
	add_option( 'wpsh_text_color', '#1a1a1a' );
    add_option( 'wpsh_parameter_color', '#006EFF' );
}


add_action( 'admin_init', 'wpsh_admin_init' );
function wpsh_admin_init() {
    add_filter( 'mce_external_plugins', 'wpsh_custom_mce_script' );
    
    wp_enqueue_script( 'wpsh-script', plugins_url( 'assets/javascript/wp-shortcode-highlighter.js', __FILE__ ), array('jquery', 'wp-color-picker'));
    wp_enqueue_style( 'wpsh-style', plugins_url( 'assets/css/wp-shortcode-highlighter.css', __FILE__ ));   
    wp_enqueue_style( 'wpsh-style', plugins_url( 'assets/css/wp-shortcode-highlighter-editor.css', __FILE__ ));   
    wp_enqueue_style( 'wp-color-picker' ); 

}

add_action( 'admin_menu', 'wpsh_menu' );
function wpsh_menu(){
    add_options_page( 'Shortcode Highlighter', 'Shortcode Highlighter', 'read', 'shortcode-highlighter', 'wpsh_options_page');   
}


add_action( 'admin_init', 'wpsh_register_settings' );
function wpsh_register_settings() {
	register_setting( 'wp-shortcode-highlighter-options', 'wpsh_background_color' );
	register_setting( 'wp-shortcode-highlighter-options', 'wpsh_border_color' );
	register_setting( 'wp-shortcode-highlighter-options', 'wpsh_text_color' );
    register_setting( 'wp-shortcode-highlighter-options', 'wpsh_parameter_color' );
}


function wpsh_options_page(){
    require_once('templates/options.php');
}

function wpsh_custom_mce_script( $plugin_array ) {
     $plugin_array['shortcode_highlighter'] = plugins_url( 'assets/javascript/wp-shortcode-highlighter-editor.js', __FILE__ ) ;
     return $plugin_array;
}

add_filter( 'wp_insert_post_data', 'wpsh_remove_markup', '99', 2 );
function wpsh_remove_markup( $data , $postarr ){
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = true;
    $dom->loadHTML('<div>' . utf8_decode(stripslashes($data['post_content'])) . '</div>');
    $xpath = new DomXPath($dom);
    $classname='shortcode-highlighter';
    $xpath_results = $xpath->query("//span[contains(@class, $classname)]");
    foreach($xpath_results as $span) {            
        $possibillitiesStart = array('"',"'",'[');
        $possibillitiesEnd = array('"',"'",']');
        if(in_array(substr($span->textContent,0,1),$possibillitiesStart) && in_array(substr($span->textContent,-1),$possibillitiesEnd)){
            while($span->hasChildNodes()) {
                $span->parentNode->insertBefore($span->firstChild, $span);
            }
            $span->parentNode->removeChild($span);    
        }   
    }   
    $html  = $dom->saveHTML();
    $html = html_entity_decode($html);
    $start = strpos($html, '<div>');
    $end   = strrpos($html, '</div>');
    $data['post_content'] = addslashes( substr($html, $start + 5, $end - $start - 5));
    return $data;
}

add_action('media_buttons', 'wpsh_add_refresh_button', 20);
function wpsh_add_refresh_button(){
    $is_post_edit_page = in_array(basename($_SERVER['PHP_SELF']), array('post.php', 'page.php', 'page-new.php', 'post-new.php'));
    if(!$is_post_edit_page)
        return;
    echo '<button type="button" id="wpsh-refresh-shortcodes" class="button"><span class="dashicons dashicons-update "></span> Refresh Shortcodes</button>';
    echo '<button type="button" id="wpsh-disable-shortcodes" data-state="enabled" class="button">Disable Highlighting</button>';
}

?>
