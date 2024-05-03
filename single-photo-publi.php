<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage NathalieMota
 */
$reference = get_field('photo_reference');
$categories = get_the_terms(get_the_ID(), 'categorie');
$formats = get_the_terms(get_the_ID(), 'format');
$type = get_field('photo_type');
$annee = get_field('photo_annee');
$photo = get_field('photo_image');


get_header();
?>
	<article class="photo__container">
		<div class="container__info flex-item">
			<h1><?php the_title(); ?></h1>
				<ul class="list_info">
					<li class="photo_reference">Référence:<?php
					if($reference) {
						echo $reference;
						} else {
						echo ('Pas de correspondance');
						}
					?>
				</li>
				<li class="photo_categorie">Catégorie:
					<?php
						if ($categories && !is_wp_error($categories)) {
							foreach ($categories as $categorie) {
								$categorie_value = $categorie->name;
								echo $categorie_value;
							}
						} else {
							echo 'Pas de correspondance';
						}
					?>
				</li>
				<li class="photo_format">Format:<?php
						if ($formats && !is_wp_error($formats)) {
							foreach ($formats as $format) {
								$format_value = $format->name;
								echo $format_value;
							}
						} else {
							echo 'Pas de correspondance';
						}
					?>
				</li>
				<li class="photo_type">Type:<?php
					if($type) {
						echo $type;
						} else {
						echo ('Pas de correspondance');
						}
					?>
				</li>
				<li class="photo_annee">Année:<?php
					if($annee) {
						echo $annee;
						} else {
						echo ('Pas de correspondance');
						}
					?>
				</li>
				</ul>
		</div>

		<div class="container__photo flex-item">
			<?php if($photo) {
						echo wp_get_attachment_image( $photo, 'large' );
						} else {
						echo ('Pas de correspondance');
						} ?> 		
		</div>
	</article>

	<div class="container_contact">
		<div class="photo_contact">
			<p>Cette photo vous intéresse?
				<button id="btn_single_photo" type="button">Contact</button>
			</p>
			<?php 
			
			?>
		</div>
		<!-- pour afficher les posts précédents ou suivants -->
		<div class="photo_next_prev">
			<?php		
			$previous_post = get_previous_post();
			$next_post = get_next_post();

				if ($previous_post) {
					$previous_title = $previous_post->post_title;
					$previous_url = get_permalink($previous_post);
					echo '<a href="' . $previous_url . '">← ' . '</a>';
				}

				if ($next_post) {
					$next_title = $next_post->post_title;
					$next_url = get_permalink($next_post);
					echo '<a href="' . $next_url . '">' . ' →</a>';
				}
			?>
		</div>
	</div>
<hr>

<div class="other-photo">
	<p>Vous aimerez aussi</p>
<?php
get_template_part('template-parts/photo-autre');
get_template_part('template-parts/modal/contact');

?>
			

</div>
<?php


/* Start the Loop */
while ( have_posts() ) :
	the_post();

	//get_template_part( 'template-parts/content/content-single' );


	// if ( is_attachment() ) {
	// 	// Parent post navigation.
	// 	the_post_navigation(
	// 		array(
	// 			/* translators: %s: Parent post link. */
	// 			'prev_text' => sprintf( __( '<span class="meta-nav">Published in</span><span class="post-title">%s</span>', 'twentytwentyone' ), '%title' ),
	// 		)
	// 	);
	// }

	// // If comments are open or there is at least one comment, load up the comment template.
	// if ( comments_open() || get_comments_number() ) {
	// 	comments_template();
	// }

	// Previous/next post navigation.
	// $twentytwentyone_next = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' );
	// $twentytwentyone_prev = is_rtl() ? twenty_twenty_one_get_icon_svg( 'ui', 'arrow_right' ) : twenty_twenty_one_get_icon_svg( 'ui', 'arrow_left' );

	// $twentytwentyone_next_label     = esc_html__( 'Next post', 'twentytwentyone' );
	// $twentytwentyone_previous_label = esc_html__( 'Previous post', 'twentytwentyone' );

	// the_post_navigation(
	// 	array(
	// 		'next_text' => '<p class="meta-nav">' . $twentytwentyone_next_label . $twentytwentyone_next . '</p><p class="post-title">%title</p>',
	// 		'prev_text' => '<p class="meta-nav">' . $twentytwentyone_prev . $twentytwentyone_previous_label . '</p><p class="post-title">%title</p>',
	// 	)
	// );
endwhile; // End of the loop.
?>
<?php
get_footer();
?>