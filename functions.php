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

// ajout swiper
function add_swiper_scripts() {
    wp_enqueue_style( 'swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css' );
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11.0.7', true);

       // Ajouter le script JavaScript pour initialiser Swiper en ligne
       $swiper_script = "
       jQuery(document).ready(function($) {
           var swiper = new Swiper('.swiper-container', {
               autoplay: false,
               slidesPerView: 1,
               allowTouchMove: true,
               navigation: {
                   nextEl: '.swiper-button-next',
                   prevEl: '.swiper-button-prev',
               },
               pagination: {
                   el: '.swiper-pagination',
                   type: 'bullets',
                   clickable: true,
               },
           });
       });
   ";
   wp_add_inline_script('swiper-js', $swiper_script);
}
add_action( 'wp_enqueue_scripts', 'add_swiper_scripts' );


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

// Fonction pour gérer la requête AJAX et renvoyer les photos filtrées
add_action('wp_ajax_filter_photos', 'filter_photos');
add_action('wp_ajax_nopriv_filter_photos', 'filter_photos');
function filter_photos() {
    $category = $_POST['category'];
    
    // Effectuer la même requête WP_Query que dans le code précédent pour récupérer les photos filtrées
    
    // Construction du HTML des photos filtrées
    ob_start();
    if ($photos->have_posts()) {
        while ($photos->have_posts()) {
            $photos->the_post();
            
            // Récupére les champs ACF pour chaque photo
            
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

// Fonction pour récupérer les 8 photos suivantes à partir d'ACF
function get_next_eight_photos_from_acf($offset) {
    $eight_next_photos = array();

    // Récupére les 8 photos suivantes à partir d'ACF en utilisant l'offset
    $all_photos = get_field('photo_image', 'options');
    $eight_next_photos = array_slice($all_photos, $offset, 8);

    return $eight_next_photos;
}

/*test pour filtres*/


//function afficherTaxonomies($nomTaxonomie) {
//     if($terms = get_terms(array(
//         'taxonomy' => $nomTaxonomie,
//         'orderby' => 'name'
//     ))) {
//         foreach ( $terms as $term ) {
//             echo '<option class="js-filter-item" value="' . $term->slug . '">' . $term->name . '</option>';
//         }
//     }
// }
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
            $photo = get_field('photo_image'); // 'false, false' pour obtenir l'URL directement
            $type = get_field('photo_type');
            $date = get_field('photo_annee');
            $titre = get_field('photo_titre');

            // Vérifie si l'image existe et l'affiche
            if ($photo) {
                // Obtenir l'URL de la publication correspondante
                $post_url = get_permalink($post->ID);
            
                // Affiche l'image avec un lien vers la publication correspondante (photo-publi ou lightbox)
                echo '<div class="photo_simple">';
                echo wp_get_attachment_image($photo, 'medium');
                echo '<a href="#" class="link_lightbox">';
                echo '<img class="img_lightbox" src="wp-content/themes/NathalieMota/assets/images/lien_lightbox.png" alt="lien lightbox">';
                echo '</a>';
                echo '<a href="' . esc_url($post_url) . '" class="link_publi">';
                echo '<img class="img_publi" src="wp-content/themes/NathalieMota/assets/images/lien_publi.png" alt="lien publication">';
                echo '</a>';
                echo '</div>';
            }
        }
    } else {
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