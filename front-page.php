<?php 
get_header(); 

$photo = get_field('photo_image');

?>
    <!-- partie 1: le hero -->
<div class="hero_mota">
    <?php
    // Récupére tous les posts qui ont une image définie dans le champ 'photo_image'
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

    // Crée un tableau pour stocker les URLs des images
    $photos_urls = array();

    // Rempli le tableau avec les URLs des images
    if ($photos_query->have_posts()) {
        while ($photos_query->have_posts()) {
            $photos_query->the_post();
            $photo_id = get_field('photo_image');
            if ($photo_id) {
                // Utilisation de l'ID pour obtenir l'URL de l'image
                $photo_url = wp_get_attachment_url($photo_id);
                $photos_urls[] = $photo_url;
            }
        }
    }
    // Réinitialise la requête WordPress
    wp_reset_postdata();

    // Sélectionne une URL d'image aléatoire
    if (!empty($photos_urls)) {
        $random_photo_url = $photos_urls[array_rand($photos_urls)];
        echo '<img class="hero_img" src="' . esc_url($random_photo_url) . '" alt="Image aléatoire" />';
    }
    ?>
            <!-- insertion du titre avec le hero-->
    <img class="hero_title" src="<?php echo get_template_directory_uri(); ?>\assets\images\hero_title.png" alt="photographe event" />
</div>

<!-- partie 2: mise en place des filtres grâce au template part filtres.php-->
<?php get_template_part('filtres'); ?>

<div class="photo_flex photo-autre-lightbox">
    <!--affichage des photos -->
<?php
    //paramètres pour l'affichage des photos pour le template part photo-galerie
$paramrequette= array(
    'post_type' => 'photo-publi', // type de contenu où sont stockées les photos
    'posts_per_page' => 8, // Récupère tous les articles  de ce type et en affiche 8
);

$photos = new WP_Query($paramrequette);

// Affiche les photos récupérées, avec le template part photo-galerie
if ($photos->have_posts()) {
    
    while ($photos->have_posts()) {
        $photos->the_post();

        if ( has_post_thumbnail() ) {
            the_post_thumbnail('large');
        }

        get_template_part('template-parts/photo-galerie');
    }
}
// Réinitialise la requête WordPress
wp_reset_postdata();
?>
</div>
    <!--bouton Charger plus -->
<div class="load-more">
    <button id="load-more-btn">Charger plus</button>
</div>


<?php get_footer(); ?>