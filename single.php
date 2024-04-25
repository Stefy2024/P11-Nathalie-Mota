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
        $photo = get_field('photo_image'); // 'false, false' pour obtenir l'URL directement
        $type = get_field('photo_type');
        $date = get_field('photo_annee');
        $titre = get_field('photo_titre');

       
        // Vérifie si l'image existe et affichez-la
        if ($photo) {
            echo '<div class="photo_simple">';
            echo wp_get_attachment_image( $photo, 'medium' );
            echo '</div>';
        }
    
?>
