<?php
//ajout du fichier js
add_action('wp_enqueue_scripts', 'enqueue_contact_Mota_scripts');
function enqueue_contact_Mota_scripts() {
    wp_enqueue_script('jquery'); // Charge jQuery
    wp_enqueue_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js');

    //création du nonce pour Ajax
    wp_localize_script('scripts', 'filterAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nonce_filter')
    ));
}
//ajout style
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style('NathalieMota', get_stylesheet_directory_uri() . '/style.css');
}

//défini ajaxurl
add_action('wp_enqueue_scripts', 'theme_ajaxurl');
function theme_ajaxurl() {
    echo '<script type="text/javascript">var ajaxurl = "' . admin_url('admin-ajax.php') . '";</script>';
}

//ajout des menus du header (main) et du footer (footer)
function register_my_menu(){
    register_nav_menu('main', "Menu principal");
    register_nav_menu('footer', "Menu pied de page");
 }
 add_action('after_setup_theme', 'register_my_menu');



//définition de la fonction filter
function filter() {
     // Vérifie le nonce pour la sécurité.
     check_ajax_referer('nonce_filter', 'nonce');
     //vérifie si le nonce est valide
     $nonce_valid = check_ajax_referer('nonce_filter', 'nonce', false);
     //si le nonce n'est pas valide, renvoi d'une erreur
     if (!$nonce_valid) {
         wp_send_json_error('Nonce invalide.');
     }
     //vérifie si catégorie et format sont vides
    if (empty(($_POST['categorieSelection'])) && empty($_POST['formatSelection']))
    {
        $taxonomie='';
    }elseif(empty(($_POST['categorieSelection'])) || empty($_POST['formatSelection'])){
        //si l'un des 2 est vide, on utilise "OR" pour la taxonomie
        $taxonomie=array(
            'relation' => 'OR',
               array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $_POST['categorieSelection'],
               ),
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                   'terms' => $_POST['formatSelection'],
                ),
            );
    }
else{
    //sinon, si aucun des 2 n'est vide, on utilise "AND"
        $taxonomie=array(
            'relation' => 'AND',
               array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => $_POST['categorieSelection'],
               ),
                array(
                    'taxonomy' => 'format',
                    'field' => 'slug',
                   'terms' => $_POST['formatSelection'],
                ),
            );
    }
    //création d'une nouvelle requête WP_QUERY, avec les paramètres spécifiés
     $requeteAjax = new WP_Query(array(
        'post_type' => 'photo-publi',
        'orderby' => 'annee',
        'order' => $_POST['orderDirection'],  //recupere la valeur du menu déroulant de droite -trier par
        'posts_per_page' => 8,
        'paged' => $_POST['page'],
        'tax_query' =>  $taxonomie
         )
     );
     //mise en mémoire tampon de sortie
   ob_start();
   //si la requête a des posts
   if($requeteAjax->have_posts()) {
    //on parcourt tous les posts
        while ($requeteAjax->have_posts()) { 
            $requeteAjax->the_post();
            //appel du template part photo-galerie
            get_template_part('template-parts/photo-galerie');
        }
    }
    
    // Réinitialise la requête WordPress
    wp_reset_postdata();  //pour libérer les données de wp_query au niveau de la mémoire pour éviter de surcharger le serveur

   //on récupère le contenu de la mise en mémoire tampon
   $html_content = ob_get_clean();
   //on affiche le contenu de la mise en mémoire
    echo ($html_content );

    // Termine le script
    die();
}
// ajout de l'action pour la fonction filter
add_action('wp_ajax_nopriv_filter', 'filter');
add_action('wp_ajax_filter', 'filter');

?>