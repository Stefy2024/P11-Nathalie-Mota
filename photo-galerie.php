<?php
/**
 * Template Name: Page personnalisée
 *
 * Description: Modèle pour une page personnalisée avec filtres et affichage de photos.
 *
 * @package WordPress
 * @subpackage NathalieMota
 */

// Vérifier si un filtre a été sélectionné
// if (isset($_POST['category']) && !empty($_POST['category'])) {
//     // Filtrez les photos en fonction de la catégorie sélectionnée
//     $category = $_POST['category'];
//     $args = array(
//         'post_type' => 'votre_type_de_post',
//         'tax_query' => array(
//             array(
//                 'taxonomy' => 'categorie',
//                 'field' => 'slug',
//                 'terms' => $category
//             )
//         )
//     );
// } else {
//     // Récupérez toutes les photos
//     $args = array(
//         'post_type' => 'votre_type_de_post'
//     );
// }

$args = array(
    'post_type' => 'photo-publi', // type de contenu où sont stockées les photos
    'posts_per_page' => 8, // Récupère tous les articles  de ce type et en affiche 8
);
$photos = new WP_Query($args);

// Affichez les photos récupérées
if ($photos->have_posts()) {
    while ($photos->have_posts()) {
        $photos->the_post();
        
        // Récupérez les champs ACF pour chaque photo
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
?>
<div id="ajax_return"></div>
<?php
// Réinitialisez la requête WordPress
wp_reset_postdata();
?>
