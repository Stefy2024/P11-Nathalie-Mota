<?php
/**
 * Template Name: Page personnalisée
 *
 * Description: Modèle pour une page personnalisée avec filtres et affichage de photos.
 *
 * @package WordPress
 * @subpackage NathalieMota
 */

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

?>