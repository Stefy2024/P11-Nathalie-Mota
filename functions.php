<?php
//ajout du fichier js
add_action('wp_enqueue_scripts', 'enqueue_contact_Mota_scripts');
function enqueue_contact_Mota_scripts() {
    wp_enqueue_script('jquery'); // Charge jQuery
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js');

    //création du nonce
    wp_localize_script('scripts', 'filterAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nonce_filter')
    ));
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

 

// Fonction pour gérer la requête AJAX et renvoyer les photos filtrées
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
function filter_photos() {
    // Vérification du nonce
    check_ajax_referer('nonce_filter', 'nonce');
    $nonce_valid = check_ajax_referer('nonce_filter', 'nonce', false);
    if (!$nonce_valid) {
        wp_send_json_error('Nonce invalide.');
    }
    $category = $_POST['category'];
    
    // Construction du HTML des photos filtrées
    ob_start();
    if ($photos->have_posts()) {
        while ($photos->have_posts()) {
            $photos->the_post();
            // Construit le HTML pour chaque photo filtrée
        }
    } else {
        // Aucune photo trouvée
    }
    $html = ob_get_clean();
    echo $html;
    wp_die();
}

// Ajoute la fonction pour gérer la requête AJAX "charger plus"
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


function filter() {
   
    if (empty(($_POST['categorieSelection'])) && empty($_POST['formatSelection']))
    {
        $taxonomie='';
    }elseif(empty(($_POST['categorieSelection'])) || empty($_POST['formatSelection']))
    {
        $taxonomie=array(
            'relation' => 'OR',
               array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $_POST['categorieSelection'],
               ),
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                   'terms' => $_POST['formatSelection'],
                ),
            );
    }
    else{
        $taxonomie=array(
            'relation' => 'AND',
               array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $_POST['categorieSelection'],
               ),
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                   'terms' => $_POST['formatSelection'],
                ),
            );
    }
     $requeteAjax = new WP_Query(array(
        'post_type' => 'photo-publi',
         'orderby' => 'annee',
         'order' => $_POST['orderDirection'],
        'posts_per_page' => 8,
         'paged' => $_POST['page'],
         'tax_query' =>  $taxonomie
         )
     );
   ob_start();
   if($requeteAjax->have_posts()) {
        while ($requeteAjax->have_posts()) { 
            $requeteAjax->the_post();
            get_template_part('template-parts/photo-galerie');
        }
        }
     else {
            // Aucune photo trouvée
    }
    
    // Réinitialise la requête WordPress
    wp_reset_postdata();
   //afficherImages($requeteAjax, true);
   $html_content = ob_get_clean();
    echo ($html_content );

    // Termine le script
    die();
}
add_action('wp_ajax_nopriv_filter', 'filter');
add_action('wp_ajax_filter', 'filter');

?>