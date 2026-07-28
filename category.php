<?php
/**
 * Category archive template: /porady/kategoria/{slug}/ — only used for post
 * categories (the only taxonomy this theme registers content in). Near-empty
 * archives (<3 posts) get noindex via ef_blog_robots_meta() in inc/blog.php.
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
get_header();
$term = get_queried_object();
?>
<section aria-labelledby="page-title">
	<div class="container">
		<div class="section__head">
			<span class="eyebrow"><a class="eyebrow__link" href="<?php echo esc_url( ef_url( '/porady/' ) ); ?>"><?php esc_html_e( 'Porady', 'elegant-fryzjer' ); ?></a></span>
			<h1 id="page-title"><?php echo esc_html( single_cat_title( '', false ) ); ?></h1>
			<?php if ( $term && $term->description ) : ?>
				<p class="lead"><?php echo esc_html( $term->description ); ?></p>
			<?php endif; ?>
		</div>

		<?php if ( have_posts() ) : ?>
			<div class="grid grid--3">
				<?php while ( have_posts() ) : the_post(); ef_post_card( get_the_ID() ); endwhile; ?>
			</div>
			<?php ef_blog_pagination(); ?>
		<?php else : ?>
			<p class="muted"><?php esc_html_e( 'Wkrótce pojawią się tu pierwsze porady z tej kategorii.', 'elegant-fryzjer' ); ?></p>
		<?php endif; ?>
	</div>
</section>
<?php
wp_reset_postdata();
get_footer();
