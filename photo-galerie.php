<?php
/**
 * Template Name: Page personnalisée
 *
 * Description: Modèle pour une page personnalisée avec filtres et affichage de photos.
 *
 * @package WordPress
 * @subpackage NathalieMota
 */

        // Récupére les champs ACF pour chaque photo
        $photo = get_field('photo_image');
        $type = get_field('photo_type');
        $date = get_field('photo_annee');
        $titre = get_field('photo_titre');
        $reference = get_field('photo_reference');
        $categorie = get_the_terms($post->ID, 'categorie')[0]->name;

        // Vérifie si l'image existe et l'affiche
        if ($photo) {
            // Obtenir l'URL de la publication correspondante
            $post_url = get_permalink($post->ID);
        
            // Affiche l'image avec un lien vers la publication correspondante (photo-publi ou lightbox)
            echo '<div class="photo_simple">';
                echo wp_get_attachment_image($photo, 'large');
                    echo '<div class="overlay">';
                        echo '<a href="#" class="link_lightbox">';
                            echo '<img class="img_lightbox" src="wp-content/themes/NathalieMota/assets/images/lien_lightbox.png" alt="lien lightbox">';
                        echo '</a>';
                        echo '<a href="' . esc_url($post_url) . '" class="link_publi">';
                            echo '<img class="img_publi" src="wp-content/themes/NathalieMota/assets/images/lien_publi.png" alt="lien publication">';
                        echo '</a>';
                        echo '<p class="photo_reference">' . $reference . '</p>';
                        echo '<p class="photo_category">' . $categorie . '</p>';
                    echo '</div>';
            echo '</div>';
        }

?>