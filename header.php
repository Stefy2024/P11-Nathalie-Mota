<!doctype html>
<html lang="fr">
    <head>
        
        
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Nathalie Mota</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&family=Space+Mono:ital,wght@0,400;1,400;1,700&display=swap" rel="stylesheet">

        <?php wp_head(); ?>
    </head>

<body>
   
    <div class="nav_bar">

        <a href="http://nathaliemota.test/"> <img class="mota_logo" src="<?php echo get_template_directory_uri(); ?>\assets\images\logo.png" alt="logo Nathalie Mota" /></a>

        <nav id="navigation">
            <?php wp_nav_menu(
                array(
                    'theme_location' => 'main')); ?>
        </nav>

        <!-- Bouton du menu burger -->
        <button class="burger_menu" aria-label="Menu principal">
            <span></span>
            <span></span>
            <span></span>
        </button>

         <!-- Icône de la croix pour fermer le menu -->
        <div class="close_icon" aria-label="Fermer le menu" style="display: none;">
            &times;
        </div>
    </div>




 


    

