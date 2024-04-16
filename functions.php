<?php

//ajout du fichier js
add_action('wp_enqueue_scripts', 'enqueue_contact_Mota_scripts');
function enqueue_contact_Mota_scripts() {
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js');
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style('NathalieMota', get_stylesheet_directory_uri() . '/style.css');
    
}


//ajout des menus du header (main) et du footer (footer)
function register_my_menu(){
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
 }
 add_action('after_setup_theme', 'register_my_menu');

//ajout jquery
 function enqueue_custom_scripts() {
    wp_enqueue_script('jquery');
}
add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');



?>


