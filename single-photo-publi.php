
<?php

/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage NathalieMota
 */
get_header();

$reference = get_field('photo_reference');
$categories = get_the_terms(get_the_ID(), 'categorie');
$formats = get_the_terms(get_the_ID(), 'format');
$type = get_field('photo_type');
$annee = get_field('photo_annee');
$photo = get_field('photo_image');

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

		<div class="container__photo flex-item photo-lightbox">
			<?php if ($photo) {
				$post_url = get_permalink($post->ID);
								echo '<div class="photo_alone"> '; 
									echo '<a href="' . esc_url($post_url) . '"><img src="' . wp_get_attachment_image_url( $photo, 'large' ) . '" alt="photos même catégorie"></a>';
									echo '<div class="overlay">';
										echo '<a href="#" class="link_lightbox">';
											echo '<img class="img_lightbox" src="' . get_template_directory_uri() . '/assets/images/lien_lightbox.png" alt="lien lightbox">';
										echo '</a>';
									
									echo '</div>';
								echo '</div>';
							}else {
					echo ('Pas de correspondance');
				} ?> 		
		</div>
	</article>

	<div class="container_contact">
		<div class="photo_contact">
			<p>Cette photo vous intéresse?</p>
				<button id="btn_single_photo" type="button"class="open-modal" data-reference="<?php echo esc_attr($reference); ?>">Contact</button>
			
		</div>
		<!-- pour afficher les posts précédents ou suivants -->
		<div class="photo_next_prev">
				<?php
					$previous_post = get_previous_post();
					$next_post = get_next_post();

					if ($previous_post) {
						$previous_title = strip_tags($previous_post->post_title);
						$previous_url = get_permalink($previous_post);
						$previous_thumbnail_id = get_field('photo_image', $previous_post->ID); // Récupère l'ID de l'image
						$previous_thumbnail_url = wp_get_attachment_image_url($previous_thumbnail_id, 'thumbnail'); // Obtient l'URL de la miniature
						
						echo '<a class="nav-thumbnail" href="' . $previous_url . '" title="' . $previous_title . '">';
						
						if ($previous_thumbnail_url) {
							echo '<img src="' . $previous_thumbnail_url . '" alt="' . $previous_title . '" />';
						}
						echo '<span>←</span>';
						echo '</a>';
					}

					if ($next_post) {
						$next_title = strip_tags($next_post->post_title);
						$next_url = get_permalink($next_post);
						$next_thumbnail_id = get_field('photo_image', $next_post->ID);
						$next_thumbnail_url = wp_get_attachment_image_url($next_thumbnail_id, 'thumbnail');
						
						echo '<a class="nav-thumbnail" href="' . $next_url . '" title="' . $next_title . '">';
						if ($next_thumbnail_url) {
							echo '<img src="' . $next_thumbnail_url . '" alt="' . $next_title . '" />';
						}
						echo '<span>→</span>';
						echo '</a>';
					}
				?>
		</div>
	</div>

<hr>

<div class="other-photo">
	<p>Vous aimerez aussi</p>

	<?php get_template_part('template-parts/photo-autre'); ?>
			
</div>

<?php get_footer(); ?>