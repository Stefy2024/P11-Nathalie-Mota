<?php

//ajout du fichier js
add_action('wp_enqueue_scripts', 'enqueue_contact_Mota_scripts');
function enqueue_contact_Mota_scripts() {
    wp_enqueue_script('jquery'); // Charge jQuery
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js');
}

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style('NathalieMota', get_stylesheet_directory_uri() . '/style.css');
    
}
//défini ajaxurl
add_action('wp_enqueue_scripts', 'theme_ajaxurl');
function theme_ajaxurl() {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
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


// Ajoutez la fonction pour gérer la requête AJAX
add_action('wp_ajax_load_more_photos', 'load_more_photos');
add_action('wp_ajax_nopriv_load_more_photos', 'load_more_photos');

function load_more_photos() {
    $offset = $_POST['offset'];

    // Récupére les 8 photos suivantes à partir d'ACF
    $eight_next_photos = get_next_eight_photos_from_acf($offset);

    // Affiche les nouvelles photos
    foreach ($eight_next_photos as $photo) {
        echo '<img src="' . esc_url($photo['url']) . '" alt="' . esc_attr($photo['alt']) . '">';
    }

    // arrête l'exécution après avoir renvoyé la réponse
    wp_die();
}

// Fonction pour récupérer les 8 photos suivantes à partir d'ACF
function get_next_eight_photos_from_acf($offset) {
    $eight_next_photos = array();

    // Récupére les 8 photos suivantes à partir d'ACF en utilisant l'offset
    $all_photos = get_field('photo_image', 'options');
    $eight_next_photos = array_slice($all_photos, $offset, 8);

    return $eight_next_photos;
}


?>


