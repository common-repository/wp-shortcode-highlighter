<?php
add_action('wp_ajax_wpsh_dynamic_styles', 'wpsh_dynamic_styles_callback');
function wpsh_dynamic_styles_callback(){
    header("Content-Type: text/css");
    header("X-Content-Type-Options: nosniff");
    echo "#tinymce span.shortcode-highlighter-parameter {color:".esc_attr( get_option('wpsh_parameter_color') ).";}";
    echo "#tinymce span.shortcode-highlighter-container {background-color:".esc_attr( get_option('wpsh_background_color') )."; border-color:".esc_attr( get_option('wpsh_border_color') )."; color:".esc_attr( get_option('wpsh_text_color') ).";}";
}