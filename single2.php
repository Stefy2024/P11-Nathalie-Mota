<?php
/**
 * Template Name: Page personnalisée
 *
 * Description: Modèle pour une page personnalisée avec filtres et affichage de photos.
 *
 * @package WordPress
 * @subpackage NathalieMota
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">

        <div class="filters">
            <select id="category-filter">
                <option value="">Catégories</option>
                <?php

                // Récupérer catégories ACF et les afficher dans la liste déroulante

                $categories = get_terms('categorie'); 
                foreach ($categories as $category) {
                    echo '<option value="' . $category->slug . '">' . $category->name . '</option>';
                }
                ?>
            </select>

            <select id="format-filter">
                <option value="">Formats</option>
                <?php
				
                // Récupérer formats ACF et les afficher dans la liste déroulante

                $formats = get_terms('format'); 
                foreach ($formats as $format) {
                    echo '<option value="' . $format->slug . '">' . $format->name . '</option>';
                }
                ?>
            </select>

            <select id="sort-filter">
                <option value="date">Trier par date</option>
                <option value="title">Trier par titre</option>
               
            </select>
        </div>

        <div class="photo-grid">
            <?php
            // Récupére photos ACF
            $photos = get_posts(array(
                'post_type' => 'photo-publi',
                'posts_per_page' => -1, // récupérer tous les posts
                'orderby' => 'date', // trier par date par défaut
                'order' => 'DESC', // ordre décroissant par défaut
                
            ));
           
            if ($photos) {
          
                foreach ($photos as $photo) {
                    // Récupérer les informations de chaque photo
                    $photo_image = get_field('photo_image', $photo->ID);
                    $photo_title = get_field('photo_titre', $photo->ID);
                    $photo_reference = get_field('photo_reference', $photo->ID);
                    $photo_annee = get_field('photo_annee', $photo->ID);
                    $photo_type = get_field('photo_type', $photo->ID);

                    // vérif image récupérée avec succès
                    if ($photo_image) {
                        $photo_url = $photo_image['url'];
                        $photo_alt = $photo_image['alt'];

                        // Afficher chaque image avec son titre et son attribut alt
                        echo '<div class="photo">';
                        echo '<img src="' . $photo_url . '" alt="' . $photo_alt . '">';
                        echo '<h3>' . $photo_title . '</h3>';
                        
                        echo '</div>';
                    }
                }
            } else {
                echo 'Aucune photo trouvée.';
            }
            ?>
        </div>

    </main><!-- #main -->
</div><!-- #primary -->

<?php
get_footer();
?>
