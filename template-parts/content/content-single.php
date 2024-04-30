<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>

<!-- <article id="post-<?php// the_ID(); ?>" <?php// post_class(); ?>> -->

	<header class="entry-header alignwide">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<?php the_post_thumbnail(); ?> 
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php
		the_content();
        
        //get_template_part('photos-single')
        //$term = get_queried_object();                                              
          //  $term_id  = my_acf_load_value('categorie', $term);
    
        
        //$cate =  my_acf_load_value('name', get_field('categorie'));
        //echo $cate;
        // Vérifier si des termes ont été récupérés
        //if ($cate) {
           // echo '<ul>';
          //  foreach ($categorie as $cate) {
          //      echo '<li>' . $categorie->name . '</li>'; // Afficher le nom de chaque terme
          //  }
          //  echo '</ul>';
      //  }

      //  echo '$cate';

		wp_link_pages(
			array(
				'before'   => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'twentytwentyone' ) . '">',
				'after'    => '</nav>',
				/* translators: %: Page number. */
				'pagelink' => esc_html__( 'Page %', 'twentytwentyone' ),
			)
		);
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer default-max-width">
		<?php// twenty_twenty_one_entry_meta_footer(); ?>
	</footer><!-- .entry-footer -->

	<?php if ( ! is_singular( 'attachment' ) ) : ?>
		<?php get_template_part( 'template-parts/post/author-bio' ); ?>
	<?php endif; ?>

</article><!-- #post-<?php the_ID(); ?> -->
