<!-- <div class="lightbox">
    <button class="lightbox__close"></button>
    <button class="lightbox__next"></button>
    <button class="lightbox__prev"></button>
    <div class="lightbox__container">
        <?php
        
        // $photo_champs = get_field('photos_champs'); // Récupére le groupe de champs 'photo_champs'
        // $images = $photo_champs['photo_image']; // Récupére le champ 'photo_image' dans le groupe de champs

        // if ($images) {
        //     foreach ($images as $image) {
        //         echo '<img src="' . $image['url'] . '" alt="' . $image['alt'] . '">';
        //     }
        // }
        ?>
        <img src="wp-content/themes/NathalieMota/assets/images/nathalie-0.jpeg" alt="test">
    </div>
</div> -->


<hr class="menu-divider">
<nav id="navigation">
    <?php wp_nav_menu(array('theme_location' => 'footer')); ?>
    <p class="footer_text">Tous droits réservés</p>
</nav>
    </body>
</html>