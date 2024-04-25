<?php 
get_header(); 
?>
<div class="hero_mota">
    <img class="hero_img" src="<?php echo get_template_directory_uri(); ?>.\assets\images\nathalie-0.jpeg" alt="fête d'un mariage" />
    <img class="hero_title" src="<?php echo get_template_directory_uri(); ?>.\assets\images\hero_title.png" alt="photographe event" />
</div>
<?php get_template_part('filtres'); ?>

<div class="photo_flex">
<?php

$args = array(
    'post_type' => 'photo-publi', // type de contenu où sont stockées les photos
    'posts_per_page' => 8, // Récupère tous les articles  de ce type
);

$query = new WP_Query($args);


    while ($query->have_posts()) : $query->the_post();
            get_template_part('single');
        endwhile;
        wp_reset_postdata();

?>
</div>

<div class="load-more">
    <button id="load-more-btn">Charger plus</button>
</div>


<?php 
get_footer(); 
?>