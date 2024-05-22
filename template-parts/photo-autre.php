<?php
    // Récupère la catégorie de la publication principale
    $main_post_category = get_the_terms(get_the_ID(), 'categorie');

    // Vérifier si des termes ont été trouvés
    if ($main_post_category && !is_wp_error($main_post_category)) {
        $main_post_category_slug = $main_post_category[0]->slug;

        // Récupère les deux publications de la même catégorie
        $args = array(
            'post_type' => 'photo-publi',
            'posts_per_page' => 2,
            'post__not_in' => array(get_the_ID()), // Exclu la publication principale
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $main_post_category_slug // Utilise le slug de la catégorie principale
                )
            )
        );
        $query = new WP_Query($args);
?>
   
        <div class="flex-container photo-autre-lightbox">
            <?php
                // Boucle pour afficher les deux photos
                if ($query->have_posts()) :
                    while ($query->have_posts()) : $query->the_post();

                        get_template_part('template-parts/photo-galerie');

                    endwhile;
                    wp_reset_postdata();
                endif;
    }
        ?>
    </div>

