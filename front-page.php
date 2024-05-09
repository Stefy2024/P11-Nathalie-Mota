<?php 
get_header(); 

// Modal contact
get_template_part('template-parts/modal/contact');
?>
<div id="myModal" class="modal">

    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">x</span>
        <div class="mota-form-container">
                <?php
                echo do_shortcode('[contact-form-7 id="0e5d643" title="Formulaire de contact modal"]')
                ?>
        </div>
    </div>
</div>

<div class="hero_mota">
    <img class="hero_img" src="<?php echo get_template_directory_uri(); ?>.\assets\images\nathalie-0.jpeg" alt="fête d'un mariage" />
    <img class="hero_title" src="<?php echo get_template_directory_uri(); ?>.\assets\images\hero_title.png" alt="photographe event" />
</div>
<?php get_template_part('filtres'); ?>

<div class="photo_flex">
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
//var_dump($paramrequette["post_type"]);
get_template_part('photo-galerie');
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


<?php 
get_template_part('template-parts/lightbox');
get_footer(); 
?>