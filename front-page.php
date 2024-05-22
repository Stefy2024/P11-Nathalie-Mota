<?php 
get_header(); 

$photo = get_field('photo_image');

?>



<div class="hero_mota">
    <?php
    // Récupérez tous les posts qui ont une image définie dans le champ 'photo_image'
    $args = array(
        'post_type' => 'photo-publi', // Remplacez par le type de post approprié
        'posts_per_page' => -1, // Récupère tous les posts
        'meta_query' => array(
            array(
                'key' => 'photo_image',
                'compare' => 'EXISTS'
            ),
        )
    );
    $photos_query = new WP_Query($args);

    // Créez un tableau pour stocker les URLs des images
    $photos_urls = array();

    // Remplissez le tableau avec les URLs des images
    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            $photo_id = get_field('photo_image');
            if ($photo_id) {
                // Utilisez l'ID pour obtenir l'URL de l'image
                $photo_url = wp_get_attachment_url($photo_id);
                $photos_urls[] = $photo_url;
            }
        }
    }

    // Réinitialisez la requête WordPress
    wp_reset_postdata();

    // Sélectionnez une URL d'image aléatoire
    if (!empty($photos_urls)) {
        $random_photo_url = $photos_urls[array_rand($photos_urls)];
        echo '<img class="hero_img" src="' . esc_url($random_photo_url) . '" alt="Image aléatoire" />';
    }
    ?>
    <img class="hero_title" src="<?php echo get_template_directory_uri(); ?>.\assets\images\hero_title.png" alt="photographe event" />
</div>


<?php get_template_part('filtres'); ?>

<div class="photo_flex photo-autre-lightbox">
<?php
$paramrequette= array(
    'post_type' => 'photo-publi', // type de contenu où sont stockées les photos
    'posts_per_page' => 8, // Récupère tous les articles  de ce type et en affiche 8
);

$photos = new WP_Query($paramrequette);

// Affichez les photos récupérées
if ($photos->have_posts()) {
    
    while ($photos->have_posts()) {
        $photos->the_post();

        if ( has_post_thumbnail() ) {
            the_post_thumbnail('large');
        }
//var_dump($paramrequette["post_type"]);
get_template_part('template-parts/photo-galerie');
}
} else {
    // Aucune photo trouvée
}

// Réinitialisez la requête WordPress
wp_reset_postdata();
?>
</div>

<div class="load-more">
    <button id="load-more-btn">Charger plus</button>
</div>


<?php get_footer(); ?>