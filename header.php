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
        <img class="mota_logo" src="<?php echo get_template_directory_uri(); ?>.\assets\images\logo.png" alt="logo Nathalie Mota" />

        <nav id="navigation">
            <?php wp_nav_menu(
                array(
                    'theme_location' => 'main')); ?>
        </nav>
    </div>


    <!-- The Modal -->
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
<!-- <script src="./wp-content/themes/NathalieMota/js/scripts.js"></script> -->
</div>

    

